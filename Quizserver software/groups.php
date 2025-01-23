<?php
require 'header.php';
ob_start();
?>
<div style="text-align:center;">
    <h3>Add/Delete/Search Groups</h3>
    <form id="mainForm" action="" method="post" onsubmit="openConfirmModal(event);">
        <select id="function" name="function" required>
            <option value="create">Create</option>
            <option value="delete">Delete</option>
            <option value="show">Show</option>
        </select>
        <select id="group" name="group" required>
            <option value="pool">Pool</option>
            <option value="tags">Tags</option>
            <option value="courses">Courses</option>
            <option value="chapters">Chapters</option>
            <option value="categories">Categories</option>
            <option value="exams">Examen</option>
        </select>
        <input type="hidden" name="AddDelSearch" value="1"> 
        <input type="text" name="name" placeholder="name">
        <input type="submit" name="submit" value="Go">
    </form>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to <span id="actionType"></span> the <span id="groupType"></span> named "<span id="groupName"></span>"?</p>
        <form id="confirmForm" action="" method="post">
            <input type="hidden" name="function" id="modalFunction">
            <input type="hidden" name="group" id="modalGroup">
            <input type="hidden" name="name" id="modalName">
            <input type="hidden" name="AddDelSearch" value="1">
            <button class="buttonYes" type="submit">Yes</button>
            <button type="button" onclick="closeConfirmModal();">Cancel</button>
        </form>
    </div>
</div>

<style>
    /* Basic modal styling */

    .buttonYes:hover {
        background-color: rgba(255, 0, 0, 1); 
    }
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        background-color: rgba(0, 0, 0, 0.5); 
    }
    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 300px;
        text-align: center;
    }
    .modal button {
        margin: 10px;
    }
</style>

<script>
    // Open confirmation modal and populate its data
    function openConfirmModal(event) {
        event.preventDefault();
        const functionInput = document.getElementById('function').value;
        const groupInput = document.getElementById('group').value;
        const nameInput = document.querySelector('[name="name"]').value;

        document.getElementById('actionType').innerText = functionInput;
        document.getElementById('groupType').innerText = groupInput;
        document.getElementById('groupName').innerText = nameInput;

        document.getElementById('modalFunction').value = functionInput;
        document.getElementById('modalGroup').value = groupInput;
        document.getElementById('modalName').value = nameInput;

        document.getElementById('confirmModal').style.display = 'block';
    }

    // Close confirmation modal
    function closeConfirmModal() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('confirmModal');
        if (event.target == modal) {
            closeConfirmModal();
        }
    }
</script>

<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['AddDelSearch'])) {
    $function = $_POST['function'];
    $group = $_POST['group'];
    $name = $_POST['name'];
    
    //echo "<br>AddDelSearch<br>";
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    
    $vraag->allGroupChecker($function, $group, $name);
    
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $id = $_POST['id'];
    $group = $_POST['group'];
    $oldname = $_POST['oldname'];
    
    $vraag->deleteEntry($id, $group, $oldname);
    
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    
    $id = $_POST['id'];
    $oldname = $_POST['oldname'];
    $name = $_POST['name'];
    $group = $_POST['group'];
    
    echo "<br><br> New Entries: " . $id . " and " . $oldname . " and " . $name . " and " . $group . "<br><br>";
    
    $vraag->updateEntry($id, $oldname, $name, $group);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

echo "<br><br>";
$vraag->showAllGroups();

ob_end_flush();
require 'footer.php';
?>
