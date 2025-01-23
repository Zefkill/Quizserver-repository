<?php 
session_start();

require "conn/vraag.php";
require "conn/connect.php";
$vraag = new Vraag();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TUD Question Database</title>
    <ico>
    <link rel="stylesheet" type="text/css" href="style/stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="create.php">Create</a></li>
        <li><a href="search.php">Search/Update/Delete</a></li>
        <li><a href="porting.php">Porting</a></li>
        <li><a href="groups.php">Groups</a></li>
        <li><a href="multitool.php">Multitool</a></li>
        
        <!-- <li style="float:right"><a href="credits.php">Credits</a></li> -->
    </ul>
<style>

</style>
