<?php
require "header.php";

$input = $_POST["input"];

$sql = $conn->prepare("SELECT * FROM vraag WHERE Title = ?");
$sql->bindParam(1, $input);
$sql->execute();
$result = $sql->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header("Location: search.php");
    exit();
}

$vraag->readVraag($input);

require 'footer.php';
?>
<script>
    function submitForm() {
        document.getElementById('questionForm').submit();
    }
</script>
