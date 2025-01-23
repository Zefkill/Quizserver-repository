<?php 
require 'header.php';

?>

<h1>Index</h1>

<h2><a href="create.php">Create</a></h2>
<h4>- Able to create different types of questions with groups existing in <a href="groups.php">groups</a>.</h4>

<h2><a href="search.php">Search</a></h2>
<h4>- Able to search up existing questions, delete specific questions or purge the entire database.</h4>

<h2><a href="porting.php">Porting</a></h2>
<h4>- Able to import questions through a ZIP file.</h4>
<h4>- Able to export all or a specific bunch of selected questions.</h4>

<h2><a href="groups.php">Groups</a></h2>
<h4>- Able to view, create, update and delete all groups in the database.</h4>

<h2><a href="multitool.php">Multitool</a></h2>
<h4>- Able to back up all current records.</h4>
<h4>- Able to select a record to restore.</h4>
<h4>- Able to delete all records from back-up.</h4>
<h4>- Able to rewind every record from back-up.</h4>

<?php 
require 'footer.php';
?>

