<?php
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clean_database'])) {
    $vraag->deleteAll();
}
?>

<h1 style="text-align:center;">Search Questions</h1>

<div class="container">
    <div class="left-column-2">
        <h3>View Specific Question</h3>
        <form action="read.php" method="post">
            <div class="autocomplete-container" style="width:300px;">
                <input type="text" id="title" name="input" placeholder="Question Title">
                <div id="autocomplete-results-title"></div>
            </div>
            <input type="submit" name="submit" value="View">
        </form>
    </div>
    <div class="right-column-2">
        <h3>Delete Question</h3>
        <form id="deleteForm" action="conn/delete.php" method="post">
            <div class="autocomplete-container" style="width:300px;">
                <input type="text" id="deleteTitle" name="input" placeholder="Question Title or ID">
                <div id="autocomplete-results-delete"></div>
            </div>
            <input type="button" class="buttonYes" id="deleteBtn" value="Delete" onclick="openDeleteModal();">
        </form>

        <!-- Delete Question Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <p>Are you sure you want to delete the question: <span id="questionToDeleteDisplay"></span>? This action <b>can</b> be undone.</p>
                <form id="confirmDeleteForm" action="conn/delete.php" method="post">
                    <input type="hidden" id="questionToDelete" name="input"> <!-- Hidden input to hold the question title for deletion -->
                    <button class="buttonYes" type="submit">Yes</button>
                    <button type="button" id="cancelDeleteModalBtn" onclick="closeDeleteModal();">Cancel</button>
                </form>
            </div>
        </div>
        <br>
        <h3>Purge Database</h3>
        <input type="button" class="buttonYes" id="purgeBtn" value="Purge Database" onclick="openPurgeModal();">

        <!-- Purge Database Modal -->
        <div id="purgeModal" class="modal">
            <div class="modal-content">
                <p>Are you sure you want to clean the entire database? This action <b>cannot</b> be undone.</p>
                <form action="" method="post">
                    <input type="hidden" name="clean_database" value="1"> 
                    <button class="buttonYes" type="submit">Yes</button>
                    <button type="button" id="cancelPurgeBtn" onclick="closePurgeModal();">Cancel</button>
                </form>
            </div>
        </div>
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

<br>
<?php
$vraag->showSelectVragen();
?>

<script>
function search() {
    const fields = [
        'id', 'title', 'question', 'feedback', 'pool', 'tags', 
        'courses', 'chapters', 'categories', 'exams'
    ];

    const searchValues = fields.reduce((acc, field) => {
        acc[field] = document.getElementById('search_' + field).value.toLowerCase();
        return acc;
    }, {});

    const rows = document.getElementsByClassName('vraagRow');

    for (let row of rows) {
        let showRow = true;
        for (let field of fields) {
            const cellValue = row.querySelector('.' + field).innerText.toLowerCase();
            if (!cellValue.includes(searchValues[field])) {
                showRow = false;
                break;
            }
        }
        row.style.display = showRow ? '' : 'none';
    }
}

function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.vraagRow input[type="checkbox"]');
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].parentNode.parentNode.style.display !== 'none') {
            checkboxes[i].checked = source.checked;
        }
    }
}

function confirmDelete() {
            return confirm("Are you sure you want to delete this question?");
        }


function confirmCleanDatabase() {
    return confirm("Are you sure you want to clean the entire database? This action cannot be undone.");
}

// Modal for "Purge Database" & "Delete Question"

var deleteModal = document.getElementById("deleteModal");
var purgeModal = document.getElementById("purgeModal");

// Function to open the Delete Question modal
function openDeleteModal() {
    const questionToDelete = document.getElementById("deleteTitle").value.trim();
    
    if (!questionToDelete) {
        alert("Please enter a question title or ID to delete.");
        return; // Prevent opening the modal if input is empty
    }

    document.getElementById("questionToDelete").value = questionToDelete; // Set the question to delete
    document.getElementById("questionToDeleteDisplay").innerText = questionToDelete; // Display the question in the modal
    deleteModal.style.display = "block";
}

// Function to close the Delete Question modal
function closeDeleteModal() {
    deleteModal.style.display = "none";
}

// Function to open the Purge Database modal
function openPurgeModal() {
    purgeModal.style.display = "block";
}

// Function to close the Purge Database modal
function closePurgeModal() {
    purgeModal.style.display = "none";
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target == deleteModal) {
        closeDeleteModal();
    } else if (event.target == purgeModal) {
        closePurgeModal();
    }
};

// Cancel button to hide the modal
document.getElementById("cancelDeleteModalBtn").onclick = function() {
    closeDeleteModal();
};

document.getElementById("cancelPurgeBtn").onclick = function() {
    closePurgeModal();
};

$(document).ready(function() {
    // Autocomplete for Title
    $('#title').keyup(function() {
        var queryTitle = $(this).val();
        if (queryTitle.trim() !== '') {
            $.ajax({
                url: 'json/autocomplete.php',
                method: 'POST',
                data: {query: queryTitle},
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, item) {
                        html += '<div class="autocomplete-item">' + item.Title + '</div>';
                    });
                    $('#autocomplete-results-title').html(html);
                }
            });
        } else {
            $('#autocomplete-results-title').empty();
        }
    });

    // Autocomplete for Delete Title
    $('#deleteTitle').keyup(function() {
        var queryDelete = $(this).val();
        if (queryDelete.trim() !== '') {
            $.ajax({
                url: 'json/autocomplete.php',
                method: 'POST',
                data: {query: queryDelete},
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, item) {
                        html += '<div class="autocomplete-item">' + item.Title + '</div>';
                    });
                    $('#autocomplete-results-delete').html(html);
                }
            });
        } else {
            $('#autocomplete-results-delete').empty();
        }
    });

    // Handle click on autocomplete item
    $(document).on('click', '.autocomplete-item', function() {
        var selectedValue = $(this).text();
        $(this).closest('.autocomplete-container').find('input[type="text"]').val(selectedValue);
        $(this).parent().empty();
    });
});
</script>

<?php require 'footer.php'; ?>