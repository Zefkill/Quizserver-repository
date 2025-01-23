<?php
require 'header.php';
?>

<form style="text-align:center;" id="questionForm" action="conn/create2.php" method="post">
<h1>Create Question</h1>
<input type="submit" value="Submit"><br><br>
    <div class="container">
        <div class="left-column-2">
            <label for="type">Type:</label>
            <select id="type" name="type" onchange="showWater()">
            <?php $vraag->fetchTypes();?>
            </select>
            <p>Chosen: <b id="chosenType">2q3</b></p>
            
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br><br>
            
            <label for="points">Points:</label><br>
            <input type="number" id="points" name="points"><br><br>
            
            <label for="time">Time:</label><br>
            <input type="number" id="time" name="time"><br><br>
            
            <label for="difficulty">Difficulty:</label><br>
            <input type="number" id="difficulty" name="difficulty" min="1" max="6"><br><br>
            
            <label for="image">Image:</label><br>
            <input type="text" id="image" name="image"><br><br>
            
            <label for="question_text">Question Text:</label><br>
            <textarea type="text" id="question_text" name="question_text" rows="4" cols="22"></textarea><br><br>
            
            <label for="feedback">Feedback:</label><br>
            <input type="text" id="feedback" name="feedback"></input><br><br>
            
            <label for="hint">Hint:</label><br>
            <input id="hint" name="hint"></input><br><br>
            
            <label for="pool">Pool:</label>
            <select id="pool" name="pool">
            <?php $vraag->fetchPools(); ?>
            </select><br><br>
            
            <label>Tags:</label><br>
            <?php $vraag->fetchTags(); ?>
            <br>
            
            <label>Courses:</label><br>
            <?php $vraag->fetchCourses(); ?>
            <br>
            
            <label>Chapters:</label><br>
            <?php $vraag->fetchChapters(); ?>
            <br>
            
            <label>Categories:</label><br>
            <?php $vraag->fetchCategories(); ?>
            <br>
            
            <label>Exams:</label><br>
            <?php $vraag->fetchExams(); ?>
            <br>
        </div>
        <div class="right-column-2" id="SHOWMCMS" style="display: none;">
            <label for="numberoptions">Option Amount (1-9):</label><br>
            <input placeholder="1" type="number" id="numberoptions" name="numberoptions" min="1" max="9" maxlength="1"><br><br>
            
            <label for="optionunique">Option Unique (1 or multiple):</label><br>
            <select id="optionunique" name="optionunique">
                <option value="1">True</option>
                <option value="0">False</option>
            </select><br><br>
            
            <div id="additionalOptions"></div>
        </div>
        <div class="right-column-2" id="SHOWTF" style="display: none;">
            <label for="trueText">True:</label><br>
            <input type="text" id="trueText" name="trueText" value="True"><br><br>
            
            <label for="trueFeedback">True Feedback:</label><br>
            <textarea id="trueFeedback" name="trueFeedback" rows="2" cols="22"></textarea><br><br>
            
            <label for="falseText">False:</label><br>
            <input type="text" id="falseText" name="falseText" value="False"><br><br>
            
            <label for="falseFeedback">False Feedback:</label><br>
            <textarea id="falseFeedback" name="falseFeedback" rows="2" cols="22"></textarea><br><br>
        </div>
        <div class="right-column-2" id="SHOWWR" style="display: none;">
            <label for="initialText">Initial Text:</label><br>
            <textarea type="text" id="initialText" name="initialText"></textarea><br><br>
            
            <label for="answerKey">Answer Key:</label><br>
            <input type="text" id="answerKey" name="answerKey"><br><br>
            
            <label for="answerType">Answer Type:</label><br>
            <input id="answerType" name="answerType"></input><br><br>
        </div>
    </div>
<input type="submit" value="Submit">
</form>

<script>
function showWater() {
    var type = document.getElementById("type").value;
    var postres = document.getElementById("chosenType");
    var mcmsDiv = document.getElementById("SHOWMCMS");
    var tfDiv = document.getElementById("SHOWTF");
    var wrDiv = document.getElementById("SHOWWR");
    
    if (type == "MC" || type == "MS") {
        mcmsDiv.style.display = "block";
        tfDiv.style.display = "none";
        wrDiv.style.display = "none";
        postres.innerHTML = type == "MC" ? "Multiple Choice" : "Multiple Selection";
    } else if (type == "TF") {
        mcmsDiv.style.display = "none";
        tfDiv.style.display = "block";
        wrDiv.style.display = "none";
        postres.innerHTML = "True or False";
    } else if (type == "WR") {
        mcmsDiv.style.display = "none";
        tfDiv.style.display = "none";
        wrDiv.style.display = "block";
        postres.innerHTML = "Written Response";
    } else {
        mcmsDiv.style.display = "none";
        tfDiv.style.display = "none";
        wrDiv.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    showWater();
    
    var typeSelect = document.getElementById("type");
    typeSelect.addEventListener("change", showWater);
});

function generateOptionFields() {
    var numOptions = document.getElementById("numberoptions").value;
    var optionsDiv = document.getElementById("additionalOptions");
    optionsDiv.innerHTML = ""; // Clear previous fields
    
    for (var i = 1; i <= numOptions; i++) {
        var optionLabel = document.createElement("label");
        optionLabel.textContent = "Option " + i + ":";
        
        var optionInput = document.createElement("textarea");
        optionInput.name = "option" + i;
        optionInput.style.height = "30px";
    
        document.body.appendChild(optionLabel);
        document.body.appendChild(optionInput);
        
        var optionPointsLabel = document.createElement("label");
        optionPointsLabel.textContent = "Points:";
        
        var optionPointsInput = document.createElement("input");
        optionPointsInput.type = "number";
        optionPointsInput.name = "optionPoints" + i;
        
        var optionFeedbackLabel = document.createElement("label");
        optionFeedbackLabel.textContent = "Feedback:";
        
        var optionFeedbackInput = document.createElement("input");
        optionFeedbackInput.type = "text";
        optionFeedbackInput.name = "optionFeedback" + i;
        
        var optionRequiredLabel = document.createElement("label");
        optionRequiredLabel.textContent = "Required:";
        
        var optionRequiredInput = document.createElement("input");
        optionRequiredInput.type = "checkbox";
        optionRequiredInput.name = "optionRequired" + i;
        
        var optionExpressionLabel = document.createElement("label");
        optionExpressionLabel.textContent = "Expression:";
        
        var optionExpressionInput = document.createElement("input");
        optionExpressionInput.type = "checkbox";
        optionExpressionInput.name = "optionExpression" + i;
        
        optionsDiv.appendChild(optionLabel);
        optionsDiv.appendChild(optionInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionPointsLabel);
        optionsDiv.appendChild(optionPointsInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionFeedbackLabel);
        optionsDiv.appendChild(optionFeedbackInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionRequiredLabel);
        optionsDiv.appendChild(optionRequiredInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionExpressionLabel);
        optionsDiv.appendChild(optionExpressionInput);
        optionsDiv.appendChild(document.createElement("br"));
        optionsDiv.appendChild(document.createElement("br"));
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Generate fields when the page loads
    generateOptionFields();
    
    var numberOptionsInput = document.getElementById("numberoptions");
    numberOptionsInput.addEventListener("change", generateOptionFields);
});

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
</script>
<?php require 'footer.php'; ?>
