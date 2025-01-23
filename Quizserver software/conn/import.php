<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";

foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        echo "$key: " . implode(',', $value) . "<br>";
    } else {
        echo "$key: $value <br>";
    }
}

try {
    $id = isset($_POST['ID']) ? $_POST['ID'] : '';
    $type = isset($_POST['Type']) ? $_POST['Type'] : '';
    $title = isset($_POST['Title']) && trim($_POST['Title']) !== '' ? $_POST['Title'] : $id . $type;
    
    $points = $_POST['Points'] ?? '';
    $time = $_POST['Time'] ?? '';
    $difficulty = $_POST['Difficulty'] ?? '';
    $image = $_POST['Image'] ?? '';
    $questionText = $_POST['QuestionText'] ?? '';
    $feedback = $_POST['Feedback'] ?? '';
    $hint = $_POST['Hint'] ?? '';
    $pool = $_POST['Pool'] ?? '';
    $tags = $_POST['Tags'] ?? [];
    $courses = $_POST['Courses'] ?? [];
    $chapters = $_POST['Chapters'] ?? [];
    $categories = $_POST['Categories'] ?? [];
    $exams = $_POST['Exams'] ?? [];
    
    $valuesToCheck = [
        'pool' => $pool,
        'tags' => $tags,
        'courses' => $courses,
        'chapters' => $chapters,
        'categories' => $categories,
        'exams' => $exams,
    ];
    
    foreach ($valuesToCheck as $columnName => $values) {
        if (empty($values)) {
            continue;
        }
        
        if (!is_array($values)) {
            $values = array_map('trim', explode(',', $values));
        }
        $values = array_filter($values);
        
        if (empty($values)) {
            continue;
        }
        
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $checkValuesQuery = $conn->prepare("SELECT * FROM $columnName WHERE name IN ($placeholders)");
        $checkValuesQuery->execute(array_values($values));
        $existingValues = $checkValuesQuery->fetchAll(PDO::FETCH_ASSOC);
        $existingValueNames = array_column($existingValues, 'name');
        echo "<br><br>Entered column: " . $columnName;
        foreach ($values as $value) {
            echo "<br>Entered values: " . $value;
            if (!in_array($value, $existingValueNames)) {
                $addValueQuery = $conn->prepare("INSERT INTO $columnName (name) VALUES (?)");
                $addValueQuery->execute([$value]);
            }
        }
    }
    
    $vraag->createVraag($type, $title, $points, $time, $difficulty, $image, $questionText, $feedback, $hint, $pool, $tags, $courses, $chapters, $categories, $exams);
    
    if ($type == "MC" || $type == "MS") {
        $numberOptions = $_POST['NumberOptions'] ?? '';
        $optionUnique = $_POST['OptionUnique'] ?? '';
        
        $vraag->insertOption($title, $numberOptions, $optionUnique);
        
        $options = $_POST['Option'] ?? [];
        $optionPoints = $_POST['OptionPoints'] ?? [];
        $optionFeedback = $_POST['OptionFeedback'] ?? [];
        $optionRequired = $_POST['OptionRequired'] ?? [];
        $optionExpression = $_POST['OptionExpression'] ?? [];
        
        foreach ($options as $index => $option) {
            $optionTitle = $option;
            $points = isset($optionPoints[$index]) ? $optionPoints[$index] : '';
            $feedback = isset($optionFeedback[$index]) ? $optionFeedback[$index] : '';
            $required = isset($optionRequired[$index]) ? 1 : 0;
            $expression = isset($optionExpression[$index]) ? $optionExpression[$index] : '';
            
            $vraag->insertOptionIndividual($title, $index + 1, $optionTitle, $points, $feedback, $required, $expression);
        }
    } elseif ($type == "TF") {
        $trueOption = $_POST['TRUE'] ?? 'True';
        $trueFeedback = $_POST['TrueFeedback'] ?? '';
        $falseOption = $_POST['FALSE'] ?? 'False';
        $falseFeedback = $_POST['FalseFeedback'] ?? '';
        
        $vraag->insertTFOptions($title, $trueOption, $trueFeedback, $falseOption, $falseFeedback);
    } elseif ($type == "WR") {
        $initialText = $_POST['InitialText'] ?? '';
        $answerKey = $_POST['AnswerKey'] ?? '';
        $answerType = $_POST['AnswerType'] ?? '';
        
        $vraag->insertWROptions($title, $initialText, $answerKey, $answerType);
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>