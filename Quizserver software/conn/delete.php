<?php
header("location: ../search.php");
require "../header.php";

echo "<pre>";
print_r($_POST);
echo "</pre>";

$output = $_POST['input'];

echo "<br>Received input: " . $output . "<br>";

$search = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
$search->bindParam(1, $output);
$search->execute();
$result = $search->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $input = $result['ID'];
    echo '<br>Result is a title <br>';
    echo "<br>delete.php<br>Received input: " . $input ."<br>delete.php<br>";
    
    $vraag->deleteVraag($input);
} else {
    $input = $output;
    echo "<br>Result is an ID <br>";
    echo "<br>delete.php<br>Received input: " . $input ."<br>delete.php<br>";
    
    $vraag->deleteVraag($input);
}
?>
