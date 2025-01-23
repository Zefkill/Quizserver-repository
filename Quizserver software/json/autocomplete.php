<?php
include('../conn/connect.php');

if(isset($_POST['query'])) {
    $query = $_POST['query'];
    $stmt = $conn->prepare("SELECT Title FROM vraag WHERE id LIKE ?");
    $stmt->execute(['%' . $query . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} elseif(isset($_POST['queryText'])) {
    $queryText = $_POST['queryText'];
    $stmt = $conn->prepare("SELECT QuestionText FROM vraag WHERE QuestionText LIKE ?");
    $stmt->execute(['%' . $queryText . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}
?>
