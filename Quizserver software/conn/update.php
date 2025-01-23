<?php
header("location: ../search.php");
require '../header.php';
echo 'update.php <br>';

echo "<pre>";
print_r($_POST);
echo "</pre>";

foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        if ($key === 'options') {
            echo "$key: <br>";
            foreach ($value as $index => $option) {
                echo "Option $index:<br>";
                foreach ($option as $subKey => $subValue) {
                    echo "&emsp;$subKey: $subValue<br>";
                }
            }
        } else {
            echo "$key: " . implode(',', $value) . "<br>";
        }
    } else {
        echo "$key: $value <br>";
    }
}

$id = $_POST['id'];
$type = $_POST['type'];
$title = $_POST['title'] ?? '';
$points = $_POST['points'] ?? '';
$time = $_POST['time'] ?? '';
$difficulty = $_POST['difficulty'] ?? '';
$image = $_POST['image'] ?? '';
$questionText = $_POST['question_text'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$hint = $_POST['hint'] ?? '';
$pool = $_POST['pool'] ?? '';
$tags = isset($_POST['tags']) ? implode(',', $_POST['tags']) . ',' : '';
$courses = isset($_POST['courses']) ? implode(',', $_POST['courses']) . ',' : '';
$chapters = isset($_POST['chapters']) ? implode(',', $_POST['chapters']) . ',' : '';
$categories = isset($_POST['categories']) ? implode(',', $_POST['categories']) . ',' : '';
$exams = isset($_POST['exams']) ? implode(',', $_POST['exams']) . ',' : '';

$vraag->updateVraag($id, $title, $points, $time, $difficulty, $image, $questionText, $feedback, $hint, $pool, $tags, $courses, $chapters, $categories, $exams);

if ($type == "MC" || $type == "MS") {
    $optionUnique = $_POST['optionunique'] ?? '';
    
    $vraag->updateVraagMCMS($id, $optionUnique);
    
    if (isset($_POST['options']) && is_array($_POST['options'])) {
        foreach ($_POST['options'] as $option) {
            $optionNumber = $option['optionNumber'] ?? '';
            $optionTitle = $option['option'] ?? '';
            $optionPoints = $option['optionPoints'] ?? '';
            $optionFeedback = $option['optionFeedback'] ?? '';
            $optionRequired = isset($option['optionRequired']) ? 1 : 0;
            $optionExpression = isset($option['optionExpression']) ? 1 : 0;
            
            echo "<br> Debugging <br>";
            echo "Option Number: $optionNumber<br>";
            echo "Option Title: $optionTitle<br>";
            echo "Option Points: $optionPoints<br>";
            echo "Option Feedback: $optionFeedback<br>";
            echo "Option Required: $optionRequired<br>";
            echo "Option Expression: $optionExpression<br>";
            echo "<br> Debugging <br>";
            
            $vraag->updateOptionsMCMS($id, $optionNumber, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression);
        }
        
    }
} elseif ($type == "TF") {
    $true_text = $_POST['true_text'] ?? '';
    $true_feedback = $_POST['true_feedback'] ?? '';
    $false_text = $_POST['false_text'] ?? '';
    $false_feedback = $_POST['false_feedback'] ?? '';
    
    $vraag->updateVraagTF($id, $true_text, $true_feedback, $false_text, $false_feedback);
} elseif ($type == "WR") {
    $initialText = $_POST['initialText'] ?? '';
    $answerKey = $_POST['answerKey'] ?? '';
    $answerType = $_POST['answerType'] ?? '';
    
    $vraag->updateVraagWR($id, $initialText, $answerKey, $answerType);
}
?>