<?php
require 'header.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle Back-up and Restore Actions
        if (isset($_POST['duplicateRecords'])) {
            try {
                $conn->beginTransaction();
        
                // Back-up the 'vraag' table to 'backedup'
                $backupQueryVraag = "REPLACE INTO backedup (ID, Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories, exams)
                                     SELECT ID, Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories, exams
                                     FROM vraag";
                $conn->prepare($backupQueryVraag)->execute();
        
                // Back-up the 'vraagmcms' table to 'backedupmcms'
                $backupQueryMcm = "REPLACE INTO backedupmcms (ID, VraagID, NumberOptions, OptionUnique)
                                   SELECT ID, VraagID, NumberOptions, OptionUnique
                                   FROM vraagmcms";
                $conn->prepare($backupQueryMcm)->execute();
        
                // Back-up the 'vraagtf' table to 'backeduptf'
                $backupQueryTtf = "REPLACE INTO backeduptf (ID, VraagID, `True`, TrueFeedback, `False`, FalseFeedback)
                                   SELECT ID, VraagID, `True`, TrueFeedback, `False`, FalseFeedback
                                   FROM vraagtf";
                $conn->prepare($backupQueryTtf)->execute();
        
                // Back-up the 'vraagwr' table to 'backedupwr'
                $backupQueryWr = "REPLACE INTO backedupwr (ID, VraagID, InitialText, AnswerKey, AnswerType)
                                  SELECT ID, VraagID, InitialText, AnswerKey, AnswerType
                                  FROM vraagwr";
                $conn->prepare($backupQueryWr)->execute();
        
                $conn->commit();
                $successMessage = "Current progress has been successfully backed-up!";
            } catch (PDOException $e) {
                $conn->rollBack();
                $errorMessage = "Error backing up progress: " . $e->getMessage();
            }
        }

        if (isset($_POST['deleteAllRecords'])) {
            try {
                $conn->beginTransaction();
                foreach (['backedup', 'backedupmcms', 'backeduptf', 'backedupwr'] as $table) {
                    $conn->prepare("DELETE FROM $table")->execute();
                }
                $conn->commit();
                $successMessage = "All records from backed-up tables have been deleted!";
            } catch (PDOException $e) {
                $conn->rollBack();
                $errorMessage = "Error deleting records: " . $e->getMessage();
            }
        }

        if (isset($_POST['replaceRecords'])) {
            try {
                $conn->beginTransaction();

                // Restore the 'backedup' table to 'vraag'
                $restoreQueryVraag = "REPLACE INTO vraag (ID, Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories, exams)
                                      SELECT ID, Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories, exams
                                      FROM backedup";
                $conn->prepare($restoreQueryVraag)->execute();

                // Restore the 'backedupmcms' table to 'vraagmcms'
                $restoreQueryMcm = "REPLACE INTO vraagmcms (ID, VraagID, NumberOptions, OptionUnique)
                                   SELECT ID, VraagID, NumberOptions, OptionUnique
                                   FROM backedupmcms";
                $conn->prepare($restoreQueryMcm)->execute();

                // Restore the 'backeduptf' table to 'vraagtf'
                $restoreQueryTtf = "REPLACE INTO vraagtf (ID, VraagID, `True`, TrueFeedback, `False`, FalseFeedback)
                                   SELECT ID, VraagID, `True`, TrueFeedback, `False`, FalseFeedback
                                   FROM backeduptf";
                $conn->prepare($restoreQueryTtf)->execute();

                // Restore the 'backedupwr' table to 'vraagwr'
                $restoreQueryWr = "REPLACE INTO vraagwr (ID, VraagID, InitialText, AnswerKey, AnswerType)
                                  SELECT ID, VraagID, InitialText, AnswerKey, AnswerType
                                  FROM backedupwr";
                $conn->prepare($restoreQueryWr)->execute();

                $conn->commit();
                $successMessage = "All records have been successfully restored and replaced from the back-up!";
            } catch (PDOException $e) {
                $conn->rollBack();
                $errorMessage = "Error restoring and replacing records: " . $e->getMessage();
            }
        }

        // Restore a specific question from `backedup` to `vraag`
        if (isset($_POST['restoreQuestion']) && !empty($_POST['restoreID'])) {
            $restoreID = $_POST['restoreID']; // This is the Title of the record

            // Check if the question exists in the `backedup` table based on Title
            $checkQuery = "SELECT COUNT(*) FROM backedup WHERE Title = :Title";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bindParam(':Title', $restoreID);
            $checkStmt->execute();
            $existsInBackedUp = $checkStmt->fetchColumn();

            if ($existsInBackedUp > 0) {
                // Delete the question from `vraag` if it already exists
                $deleteQuery = "DELETE FROM vraag WHERE Title = :Title";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bindParam(':Title', $restoreID);
                $deleteStmt->execute();

                // Restore the question from `backedup` to `vraag`
                $restoreQuery = "INSERT INTO vraag (ID, Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories, exams)
                                 SELECT ID, Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories, exams
                                 FROM backedup WHERE Title = :Title";
                $restoreStmt = $conn->prepare($restoreQuery);
                $restoreStmt->bindParam(':Title', $restoreID);
                $restoreStmt->execute();

                $successMessage = "Question successfully restored from back-up!";
            } else {
                $errorMessage = "No question found with Title '$restoreID' in the back-up.";
            }
        }
    }
} catch (PDOException $e) {
    $errorMessage = "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .buttonVraag:hover {
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
</head>
<body>
<h1 style="text-align:center;">Multitool</h1>

<?php if (isset($successMessage)): ?>
    <p style="color: green;"><?php echo $successMessage; ?></p>
<?php elseif (isset($errorMessage)): ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>

<div class="container">
    <div class="left-column-2">
        <h3>Back-up Current Progress</h3>
        <form method="POST" action="">
            <button type="submit" name="duplicateRecords" id="duplicateRecordsBtn">Back-up current progress</button>
        </form>

        <h3>Delete All Records from Back-up Tables</h3>
        <button class="buttonVraag" onclick="openDeleteModal();">Delete All Back-up Records</button>
    </div>

    <div class="right-column-2">
        <h3>Select a Question to Restore</h3>
        <form id="restoreForm" method="POST" action="">
            <div class="autocomplete-container" style="width:300px;">
                <input type="text" id="restoreTitle" name="input" placeholder="Question Title or ID">
                <div id="autocomplete-results-restore"></div>
            </div>
            <input type="hidden" id="restoreID" name="restoreID">
            <button type="button" onclick="openRestoreModal();">Restore</button>
        </form>

        <!-- Restore Question Modal -->
        <div id="restoreModal" class="modal">
            <div class="modal-content">
                <p>Are you sure you want to restore the question: <span id="questionToRestoreDisplay"></span>?</p>
                <button type="submit" class="buttonVraag" form="restoreForm" name="restoreQuestion">Yes</button>
                <button type="button" onclick="closeRestoreModal();">Cancel</button>
            </div>
        </div>

        <h3>Rewind from Back-up</h3>
        <button class="buttonVraag" onclick="openRewindModal();">Rewind everything from the back-up</button>
    </div>
</div>

<!-- Delete All Records Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete all records from the back-up tables?</p>
        <form method="POST" action="">
            <button type="submit" class="buttonVraag" name="deleteAllRecords">Yes</button>
            <button type="button" onclick="closeDeleteModal();">Cancel</button>
        </form>
    </div>
</div>

<!-- Rewind Modal -->
<div id="rewindModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to rewind everything from the back-up?</p>
        <form method="POST" action="">
            <button type="submit" class="buttonVraag" name="replaceRecords">Yes</button>
            <button type="button" onclick="closeRewindModal();">Cancel</button>
        </form>
    </div>
</div>

<script>
    // Modal Handling
    var deleteModal = document.getElementById("deleteModal");
    var rewindModal = document.getElementById("rewindModal");
    var restoreModal = document.getElementById("restoreModal");

    function openDeleteModal() {
        deleteModal.style.display = "block";
    }

    function closeDeleteModal() {
        deleteModal.style.display = "none";
    }

    function openRewindModal() {
        rewindModal.style.display = "block";
    }

    function closeRewindModal() {
        rewindModal.style.display = "none";
    }

    function openRestoreModal() {
        const questionToRestore = document.getElementById("restoreTitle").value.trim();
        if (!questionToRestore) {
            alert("Please enter a question title or ID to restore.");
            return;
        }
        document.getElementById("restoreID").value = questionToRestore; // Set the Title for restoration
        document.getElementById("questionToRestoreDisplay").innerText = questionToRestore; // Show the Title in the modal
        restoreModal.style.display = "block";
    }

    function closeRestoreModal() {
        restoreModal.style.display = "none";
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
        if (event.target == rewindModal) {
            closeRewindModal();
        }
        if (event.target == restoreModal) {
            closeRestoreModal();
        }
    };

    // Autocomplete for Restore Title
    $(document).ready(function() {
        // Bind autocomplete only for #restoreTitle field to avoid interference
        $('#restoreTitle').keyup(function() {
            var query = $(this).val();
            if (query.trim() !== '') {
                $.ajax({
                    url: 'json/autocompleteBackedUp.php',  
                    method: 'POST',
                    data: { query: query, table: 'backedup' },  
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        $.each(data, function(index, item) {
                            html += '<div class="autocomplete-item" data-id="' + item.ID + '">' + item.Title + '</div>';
                        });
                        $('#autocomplete-results-restore').html(html);
                    }
                });
            } else {
                $('#autocomplete-results-restore').empty();
            }
        });

        // Handle click on autocomplete item
        $(document).on('click', '.autocomplete-item', function() {
            var selectedValue = $(this).text();
            var selectedID = $(this).data('id');
            $('#restoreTitle').val(selectedValue);
            $('#restoreID').val(selectedValue); // Set the Title for restoration
            $('#autocomplete-results-restore').empty();
        });
    });
</script>
</body>
</html>

<?php require 'footer.php'; ?>