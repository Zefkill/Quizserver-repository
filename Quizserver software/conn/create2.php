<?php
header("location: ../create.php");
require '../header.php';

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

$type = $_POST['type'] ?? '';
$title = $_POST['title'] ?? '';
$points = $_POST['points'] ?? '';
$time = $_POST['time'] ?? '';
$difficulty = $_POST['difficulty'] ?? '';
$image = $_POST['image'] ?? '';
$questionText = $_POST['question_text'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$hint = $_POST['hint'] ?? '';
$pool = $_POST['pool'] ?? '';
$tags = $_POST['tags'] ?? [];
$courses = $_POST['courses'] ?? [];
$chapters = $_POST['chapters'] ?? [];
$categories = $_POST['categories'] ?? [];
$exams = $_POST['exams'] ?? [];

$tagsStr = implode(',', $tags) . ',';
$coursesStr = implode(',', $courses) . ',';
$chaptersStr = implode(',', $chapters) . ',';
$categoriesStr = implode(',', $categories) . ',';
$examsStr = implode(',', $exams) . ',';

$vraag->createVraag($type, $title, $points, $time, $difficulty, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr, $examsStr);

if ($type == "MC" || $type == "MS") {
    $numberOptions = $_POST['numberoptions'] ?? '';
    $optionUnique = $_POST['optionunique'] ?? '';
    
    $vraag->insertOption($title, $numberOptions, $optionUnique);
    $vraag->deleteOptionIndividual($title);
    
    for ($i = 1; $i <= $numberOptions; $i++) {
        $optionNumber = $i;
        $optionTitle = $_POST["option{$i}"] ?? '';
        $optionPoints = $_POST["optionPoints{$i}"] ?? '';
        $optionFeedback = $_POST["optionFeedback{$i}"] ?? '';
        $optionRequired = isset($_POST["optionRequired{$i}"]) ? 1 : 0;
        $optionExpression = isset($_POST["optionRequired{$i}"]) ? 1 : 0;
        
        echo "Option Number: $optionNumber <br>";
        $vraag->insertOptionIndividual($title, $optionNumber, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression);
    }
} elseif ($type == "TF") {
    $trueOption = $_POST['trueOption'] ?? 'True';
    $trueFeedback = $_POST['trueFeedback'] ?? '';
    $falseOption = $_POST['falseOption'] ?? 'False';
    $falseFeedback = $_POST['falseFeedback'] ?? '';
    
    $vraag->insertTFOptions($title, $trueOption, $trueFeedback, $falseOption, $falseFeedback);
} elseif ($type == "WR") {
    $initialText = $_POST['initialText'] ?? '';
    $answerKey = $_POST['answerKey'] ?? '';
    $answerType = $_POST['answerType'] ?? '';
    
    $vraag->insertWROptions($title, $initialText, $answerKey, $answerType);
}
?>