<?php

class Vraag {
    protected $ID;
    protected $Type;
    protected $Title;
    protected $Points;
    protected $Time;
    protected $Difficulty;
    protected $Image;
    protected $QuestionText;
    protected $Feedback;
    protected $Hint;
    protected $Pool;
    protected $Tags;
    protected $Course;
    protected $Chapter;
    protected $Category;
    protected $NumberOptions;
    protected $OptionUnique;
    protected $OptionTitle;
    protected $OptionPoints;
    protected $OptionFeedback;
    protected $OptionRequired;
    protected $OptionExpression;
    
    public function __construct($ID = null, $Type = null, $Title = null, $Points = null, $Time = null, $Difficulty = null, $Image = null, $QuestionText = null, $Feedback = null, $Hint = null, $Pool = null, $Tags = null, $Course = null, $Chapter = null, $Category = null, $NumberOptions = null, $OptionUnique = null, $OptionTitle = null, $OptionPoints = null, $OptionFeedback = null, $OptionRequired = null, $OptionExpression = null)
    {
        $this->ID = $ID;
        $this->Type = $Type;
        $this->Title = $Title;
        $this->Points = $Points;
        $this->Time = $Time;
        $this->Difficulty = $Difficulty;
        $this->Image = $Image;
        $this->QuestionText = $QuestionText;
        $this->Feedback = $Feedback;
        $this->Hint = $Hint;
        $this->Pool = $Pool;
        $this->Tags = $Tags;
        $this->Course = $Course;
        $this->Chapter = $Chapter;
        $this->Category = $Category;
        $this->NumberOptions = $NumberOptions;
        $this->OptionUnique = $OptionUnique;
        $this->OptionTitle = $OptionTitle;
        $this->OptionPoints = $OptionPoints;
        $this->OptionFeedback = $OptionFeedback;
        $this->OptionRequired = $OptionRequired;
        $this->OptionExpression = $OptionExpression;
    }
    
    public function getID() {
        return $this->ID;
    }
    
    public function getType() {
        return $this->Type;
    }
    
    public function setType($Type) {
        $this->Type = $Type;
    }
    
    public function getTitle() {
        return $this->Title;
    }
    
    public function setTitle($Title) {
        $this->Title = $Title;
    }
    
    public function getPoints() {
        return $this->Points;
    }
    
    public function setPoints($Points) {
        $this->Points = $Points;
    }
    
    public function getTime() {
        return $this->Time;
    }
    
    public function setTime($Time) {
        $this->Time = $Time;
    }
    
    public function getDifficulty() {
        return $this->Difficulty;
    }
    
    public function setDifficulty($Difficulty) {
        $this->Difficulty = $Difficulty;
    }
    
    public function getImage() {
        return $this->Image;
    }
    
    public function setImage($Image) {
        $this->Image = $Image;
    }
    
    public function getQuestionText() {
        return $this->QuestionText;
    }
    
    public function setQuestionText($QuestionText) {
        $this->QuestionText = $QuestionText;
    }
    
    public function getFeedback() {
        return $this->Feedback;
    }
    
    public function setFeedback($Feedback) {
        $this->Feedback = $Feedback;
    }
    
    public function getHint() {
        return $this->Hint;
    }
    
    public function setHint($Hint) {
        $this->Hint = $Hint;
    }
    
    public function getPool() {
        return $this->Pool;
    }
    
    public function setPool($Pool) {
        $this->Pool = $Pool;
    }
    
    public function getTags() {
        return $this->Tags;
    }
    
    public function setTags($Tags) {
        $this->Tags = $Tags;
    }
    
    public function getCourse() {
        return $this->Course;
    }
    
    public function setCourse($Course) {
        $this->Course = $Course;
    }
    
    public function getChapter() {
        return $this->Chapter;
    }
    
    public function setChapter($Chapter) {
        $this->Chapter = $Chapter;
    }
    
    public function getCategory() {
        return $this->Category;
    }
    
    public function setCategory($Category) {
        $this->Category = $Category;
    }
    
    public function getNumberOptions() {
        return $this->NumberOptions;
    }
    
    public function setNumberOptions($NumberOptions) {
        $this->NumberOptions = $NumberOptions;
    }
    
    public function getOptionUnique() {
        return $this->OptionUnique;
    }
    
    public function setOptionUnique($OptionUnique) {
        $this->OptionUnique = $OptionUnique;
    }
    
    public function getOptionTitle() {
        return $this->OptionTitle;
    }
    
    public function setOptionTitle($OptionTitle) {
        $this->OptionTitle = $OptionTitle;
    }
    
    public function getOptionPoints() {
        return $this->OptionPoints;
    }
    
    public function setOptionPoints($OptionPoints) {
        $this->OptionPoints = $OptionPoints;
    }
    
    public function getOptionFeedback() {
        return $this->OptionFeedback;
    }
    
    public function setOptionFeedback($OptionFeedback) {
        $this->OptionFeedback = $OptionFeedback;
    }
    
    public function getOptionRequired() {
        return $this->OptionRequired;
    }
    
    public function setOptionRequired($OptionRequired) {
        $this->OptionRequired = $OptionRequired;
    }
    
    public function getOptionExpression() {
        return $this->OptionExpression;
    }
    
    public function setOptionExpression($OptionExpression) {
        $this->OptionExpression = $OptionExpression;
    }
    
    public static function fetchTypes() {
        require 'connect.php';
        $types = [];
        $stmt = $conn->query("SELECT DISTINCT type FROM types
        ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $types[] = $row['type'];
        }
        foreach ($types as $type) {
            echo "<option value='$type'>$type</option>";
        }
    }
    
    public static function fetchPools() {
        require 'connect.php';
        $pools = [];
        $stmt = $conn->query("SELECT name FROM pool ORDER BY name ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pools[] = $row['name'];
        }
        foreach ($pools as $pool) {
            echo "<option value='$pool'>$pool</option>";
        }
    }
    
    public static function fetchPoolsWithSelection($selectedPool) {
        require 'connect.php';
        $pools = [];
        $stmt = $conn->query("SELECT name FROM pool");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pools[] = $row['name'];
        }
        foreach ($pools as $pool) {
            $selected = ($pool === $selectedPool) ? "selected" : "";
            echo "<option value='$pool' $selected>$pool</option>";
        }
    }
    
    
    public static function fetchTags() {
        require 'connect.php';
        
        $entries = $conn->query("SELECT * FROM tags ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='checkbox-container'>";
        foreach ($entries as $entry) {
            echo "<label><input type='checkbox' name='tags[]' value='" . htmlspecialchars($entry['name']) . "'>" . htmlspecialchars($entry['name']) . "</label>";
        }
        echo "</div>";
        echo "</td></tr>";
    }
    
    public static function fetchCourses() {
        require 'connect.php';
        
        $entries = $conn->query("SELECT * FROM courses ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='checkbox-container'>";
        foreach ($entries as $entry) {
            echo "<label><input type='checkbox' name='courses[]' value='" . htmlspecialchars($entry['name']) . "'>" . htmlspecialchars($entry['name']) . "</label>";
        }
        echo "</div>";
        echo "</td></tr>";
    }
    
    public static function fetchChapters() {
        require 'connect.php';
        
        $entries = $conn->query("SELECT * FROM chapters ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='checkbox-container'>";
        foreach ($entries as $entry) {
            echo "<label><input type='checkbox' name='chapters[]' value='" . htmlspecialchars($entry['name']) . "'>" . htmlspecialchars($entry['name']) . "</label>";
        }
        echo "</div>";
        echo "</td></tr>";
    }
    
    public static function fetchCategories() {
        require 'connect.php';
        
        $entries = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='checkbox-container'>";
        foreach ($entries as $entry) {
            echo "<label><input type='checkbox' name='categories[]' value='" . htmlspecialchars($entry['name']) . "'>" . htmlspecialchars($entry['name']) . "</label>";
        }
        echo "</div>";
        echo "</td></tr>";
    }
    
    public static function fetchExams() {
        require 'connect.php';
        
        $entries = $conn->query("SELECT * FROM exams ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='checkbox-container'>";
        foreach ($entries as $entry) {
            echo "<label><input type='checkbox' name='exams[]' value='" . htmlspecialchars($entry['name']) . "'>" . htmlspecialchars($entry['name']) . "</label>";
        }
        echo "</div>";
        echo "</td></tr>";
    }
    
    public function createVraag($type, $title, $points, $time, $difficulty, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr, $examsStr) {
        require 'connect.php';
        
        $search = $conn->prepare("SELECT COUNT(*) FROM vraag WHERE Title = ?");
        $search->bindParam(1, $title);
        $search->execute();
        $count = $search->fetchColumn();
        
        if ($count > 0) {
            echo "<br>Title " . $title . " already exists!<br>";
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO vraag (Type, Title, Points, Time, Difficulty, Image, QuestionText, Feedback, Hint, Pool, Tags, Courses, Chapters, Categories)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->bindParam(1, $type);
            $stmt->bindParam(2, $title);
            $stmt->bindParam(3, $points);
            $stmt->bindParam(4, $time);
            $stmt->bindParam(5, $difficulty);
            $stmt->bindParam(6, $image);
            $stmt->bindParam(7, $questionText);
            $stmt->bindParam(8, $feedback);
            $stmt->bindParam(9, $hint);
            $stmt->bindParam(10, $pool);
            $stmt->bindParam(11, $tagsStr);
            $stmt->bindParam(12, $coursesStr);
            $stmt->bindParam(13, $chaptersStr);
            $stmt->bindParam(14, $categoriesStr);
            
            $stmt->execute();
            $stmt->closeCursor();
        }
    }
    
    public function insertOption($title, $numberOptions, $optionUnique) {
        require 'connect.php';
        
        $search = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
        $search->bindParam(1, $title);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);
        $vraagID = $result['ID'];
        
        $search = $conn->prepare("SELECT COUNT(*) FROM vraagmcms WHERE VraagID = ?");
        $search->bindParam(1, $vraagID);
        $search->execute();
        $count = $search->fetchColumn();
        
        if ($count > 0) {
            $stmt = $conn->prepare("
                UPDATE vraagmcms SET NumberOptions = ?, OptionUnique = ?
                WHERE VraagID = ?
            ");
            
            $stmt->bindParam(1, $numberOptions);
            $stmt->bindParam(2, $optionUnique);
            $stmt->bindParam(3, $vraagID);
            
            $stmt->execute();
            $stmt->closeCursor();
        } else {
            $stmt = $conn->prepare("INSERT INTO vraagmcms (VraagID, NumberOptions, OptionUnique) VALUES (?, ?, ?)");
            
            $stmt->bindParam(1, $vraagID);
            $stmt->bindParam(2, $numberOptions);
            $stmt->bindParam(3, $optionUnique);
            
            $stmt->execute();
            $stmt->closeCursor();
        }
    }
    
    public function insertOptionIndividual($title, $optionNumber, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression) {
        require 'connect.php';
        
        $search = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
        $search->bindParam(1, $title);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);
        $vraagID = $result['ID'];
        
        $insertStmt = $conn->prepare("
            INSERT INTO optionmcms (OptionID, OptionNumber, Option, OptionPoints, OptionFeedback, OptionRequired, OptionExpression)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $insertStmt->bindParam(1, $vraagID);
        $insertStmt->bindParam(2, $optionNumber);
        $insertStmt->bindParam(3, $optionTitle);
        $insertStmt->bindParam(4, $optionPoints);
        $insertStmt->bindParam(5, $optionFeedback);
        $insertStmt->bindParam(6, $optionRequired);
        $insertStmt->bindParam(7, $optionExpression);
        
        $insertStmt->execute();
        $insertStmt->closeCursor();
    }
    
    public function insertTFOptions($title, $trueOption, $trueFeedback, $falseOption, $falseFeedback) {
        require 'connect.php';
        
        $search = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
        $search->bindParam(1, $title);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);
        $vraagID = $result['ID'];
        
        $searchExisting = $conn->prepare("SELECT COUNT(*) FROM vraagtf WHERE VraagID = ?");
        $searchExisting->bindParam(1, $vraagID);
        $searchExisting->execute();
        $count = $searchExisting->fetchColumn();
        
        if ($count > 0) {
            $stmt = $conn->prepare("
                UPDATE vraagtf SET `True` = ?, TrueFeedback = ?, `False` = ?, FalseFeedback = ?
                WHERE VraagID = ?
            ");
            
            $stmt->bindParam(1, $trueOption);
            $stmt->bindParam(2, $trueFeedback);
            $stmt->bindParam(3, $falseOption);
            $stmt->bindParam(4, $falseFeedback);
            $stmt->bindParam(5, $vraagID);
            
            $stmt->execute();
            $stmt->closeCursor();
        } else {
            $stmt = $conn->prepare("INSERT INTO vraagtf (VraagID, `True`, TrueFeedback, `False`, FalseFeedback) VALUES (?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $vraagID);
            $stmt->bindParam(2, $trueOption);
            $stmt->bindParam(3, $trueFeedback);
            $stmt->bindParam(4, $falseOption);
            $stmt->bindParam(5, $falseFeedback);
            
            $stmt->execute();
            $stmt->closeCursor();
        }
    }
    
    public function insertWROptions($title, $initialText, $answerKey, $answerType) {
        require 'connect.php';
        
        $search = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
        $search->bindParam(1, $title);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);
        $vraagID = $result['ID'];
        
        $searchExisting = $conn->prepare("SELECT COUNT(*) FROM vraagwr WHERE VraagID = ?");
        $searchExisting->bindParam(1, $vraagID);
        $searchExisting->execute();
        $count = $searchExisting->fetchColumn();
        
        if ($count > 0) {
            $stmt = $conn->prepare("
                UPDATE vraagwr SET InitialText = ?, AnswerKey = ?, AnswerType = ?
                WHERE VraagID = ?
            ");
            
            $stmt->bindParam(1, $initialText);
            $stmt->bindParam(2, $answerKey);
            $stmt->bindParam(3, $answerType);
            $stmt->bindParam(4, $vraagID);
            
            $stmt->execute();
            $stmt->closeCursor();
        } else {
            $stmt = $conn->prepare("INSERT INTO vraagwr (VraagID, InitialText, AnswerKey, AnswerType) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $vraagID);
            $stmt->bindParam(2, $initialText);
            $stmt->bindParam(3, $answerKey);
            $stmt->bindParam(4, $answerType);
            
            $stmt->execute();
            $stmt->closeCursor();
        }
    }
    
    public function deleteVraag($input) {
        require "connect.php";
        
        $search = $conn->prepare("SELECT Type FROM vraag WHERE ID = ?");
        $search->bindParam(1, $input);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);
        $vraagType = $result['Type'];
        $vraagID = $input;

        // Backup the vraag record
        $backupStmt = $conn->prepare("INSERT INTO backedup SELECT * FROM vraag WHERE ID = ?");
        $backupStmt->bindParam(1, $vraagID);
        $backupStmt->execute();
        $backupStmt->closeCursor();

        if ($vraagType == "MC" || $vraagType == "MS") {
            echo "<br>MC/MS<br>";

            // Backup vraagmcms record
            $backupStmt = $conn->prepare("INSERT INTO backedupmcms SELECT * FROM vraagmcms WHERE VraagID = ?");
            $backupStmt->bindParam(1, $vraagID);
            $backupStmt->execute();
            $backupStmt->closeCursor();

            // Backup optionmcms record
            $backupStmt = $conn->prepare("INSERT INTO backedupmcms SELECT * FROM optionmcms WHERE OptionID = ?");
            $backupStmt->bindParam(1, $vraagID);
            $backupStmt->execute();
            $backupStmt->closeCursor();

        } elseif ($vraagType == "TF") {
            echo "<br>TF<br>";

            // Backup vraagtf record
            $backupStmt = $conn->prepare("INSERT INTO backeduptf SELECT * FROM vraagtf WHERE VraagID = ?");
            $backupStmt->bindParam(1, $vraagID);
            $backupStmt->execute();
            $backupStmt->closeCursor();

        } elseif ($vraagType == "WR") {
            echo "<br>WR<br>";

            // Backup vraagwr record
            $backupStmt = $conn->prepare("INSERT INTO backedupwr SELECT * FROM vraagwr WHERE VraagID = ?");
            $backupStmt->bindParam(1, $vraagID);
            $backupStmt->execute();
            $backupStmt->closeCursor();
    }

        // Proceed with deletion
        $deleteStmt = $conn->prepare("DELETE FROM vraag WHERE ID = ?");
        $deleteStmt->bindParam(1, $vraagID);
        $deleteStmt->execute();
        $deleteStmt->closeCursor();

        if ($vraagType == "MC" || $vraagType == "MS") {
            $deleteStmt = $conn->prepare("DELETE FROM vraagmcms WHERE VraagID = ?");
            $deleteStmt->bindParam(1, $vraagID);
            $deleteStmt->execute();
            $deleteStmt->closeCursor();

            $deleteStmt = $conn->prepare("DELETE FROM optionmcms WHERE OptionID = ?");
            $deleteStmt->bindParam(1, $vraagID);
            $deleteStmt->execute();
            $deleteStmt->closeCursor();

        } elseif ($vraagType == "TF") {
            $deleteStmt = $conn->prepare("DELETE FROM vraagtf WHERE VraagID = ?");
            $deleteStmt->bindParam(1, $vraagID);
            $deleteStmt->execute();
            $deleteStmt->closeCursor();

        } elseif ($vraagType == "WR") {
            $deleteStmt = $conn->prepare("DELETE FROM vraagwr WHERE VraagID = ?");
            $deleteStmt->bindParam(1, $vraagID);
            $deleteStmt->execute();
            $deleteStmt->closeCursor();
        }
    }
    
    public function deleteOptionIndividual($title) {
        require 'connect.php';
        
        $search = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
        $search->bindParam(1, $title);
        $search->execute();
        $result = $search->fetch(PDO::FETCH_ASSOC);
        $vraagID = $result['ID'];
        
        $deleteStmt = $conn->prepare("DELETE FROM optionmcms WHERE OptionID = ?");
        $deleteStmt->bindParam(1, $vraagID);
        $deleteStmt->execute();
        $deleteStmt->closeCursor();
    }
    
    public function deleteAll() {
        require 'connect.php';
        
        try {
            $conn->beginTransaction();
            
            $conn->exec("DELETE FROM vraag");
            $conn->exec("DELETE FROM vraagmcms");
            $conn->exec("DELETE FROM vraagtf");
            $conn->exec("DELETE FROM vraagwr");
            $conn->exec("DELETE FROM optionmcms");
            $conn->exec("DELETE FROM categories");
            $conn->exec("DELETE FROM chapters");
            $conn->exec("DELETE FROM courses");
            $conn->exec("DELETE FROM pool");
            $conn->exec("DELETE FROM tags");
            $conn->exec("DELETE FROM exams");
            
            $conn->commit();
        } catch (Exception $e) {
            echo "Failed to delete records: " . $e->getMessage();
        }
    }
    
    public function readVraag($input) {
        require "connect.php";
        
        $sql = $conn->prepare("SELECT * FROM vraag WHERE Title = ?");
        $sql->bindParam(1, $input);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        
        if ($result['Type'] == "MC") {
            $resultType = "Multiple Choice";
        } elseif ($result['Type'] == "MS") {
            $resultType = "Multiple Selection";
        } elseif ($result['Type'] == "TF") {
            $resultType = "True/False";
        } elseif ($result['Type'] == "WR") {
            $resultType = "Written Response";
        }
        
        if ($result) {
            ob_start();
            self::fetchPoolsWithSelection($result['Pool']);
            $poolsOptions = ob_get_clean();
            
            echo "
            <h1>
                <form action='search.php' method='post'>
                    <button style='background-color:green;'>Search</button>
                </form>
                <input type='submit' value='Update' onclick='submitForm()' style='background-color:yellow;'>
                <form action='conn/delete.php' method='post'>
                    <input type='hidden' name='input' value='" . htmlspecialchars($result['ID']) . "'>
                    <button type='submit' style='background-color:red;'>Delete</button>
                </form>
            </h1>
            ";
            echo "<form id='questionForm' action='conn/update.php' method='post'>";
            
            echo "<div class='container'>";
            echo "<div class='left-column'>";
            echo "<h3>Question Details</h3>";
            echo "<table class='table table-bordered'>";
            echo "<input type='hidden' name='type' value='" . htmlspecialchars($result['Type']) . "'></input>";
            echo "<tr style='background-color:#333333;color:white;'><th>ID</th><td><input readonly style='width:100%;background-color:#333333; border:none;' name='id' value='" . $result['ID'] . "'></input></td></tr>";
            echo "<tr><th>Type</th><td>" . $resultType . "</td></tr>";
            echo "<tr><th>Title</th><td><input style='width:100%;' name='title' value='" . htmlspecialchars($input) . "'></input></td></tr>";
            echo "<tr><th>Points</th><td><input type='number' style='width:100%;' name='points' value='" . htmlspecialchars($result['Points']) . "'></input></td></tr>";
            echo "<tr><th>Time</th><td><input type='number' style='width:100%;' name='time' value='" . htmlspecialchars($result['Time']) . "'></input></td></tr>";
            echo "<tr><th>Difficulty</th><td><input type='number' min='1' max='6' style='width:100%;' name='difficulty' value='" . htmlspecialchars($result['Difficulty']) . "'></input></td></tr>";
            echo "<tr><th>Image</th><td><input style='width:100%;' name='image' value='" . htmlspecialchars($result['Image']) . "'></input></td></tr>";
            echo "<tr><th>Question Text</th><td><textarea style='width:100%;' name='question_text' value='" . htmlspecialchars($result['QuestionText']) . "'>" . htmlspecialchars($result['QuestionText']) . "</textarea></td></tr>";
            echo "<tr><th>Feedback</th><td><textarea style='width:100%;' name='feedback' value='" . htmlspecialchars($result['Feedback']) . "'>" . htmlspecialchars($result['Feedback']) . "</textarea></td></tr>";
            echo "<tr><th>Hint</th><td><input style='width:100%;' name='hint' value='" . htmlspecialchars($result['Hint']) . "'></input></td></tr>";
            echo "<tr><th>Pool</th><td>
            <select id='pool' name='pool'>
            " . $poolsOptions . "
            </select>
            </td></tr>";
            
            $allTags = $conn->query("SELECT * FROM tags ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr><th>Tags</th><td>";
            echo "<div class='checkbox-container'>";
            foreach ($allTags as $tag) {
                $checked = in_array($tag['name'], explode(',', $result['Tags'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='tags[]' value='" . htmlspecialchars($tag['name']) . "' $checked>" . htmlspecialchars($tag['name']) . "</label>";
            }
            echo "</div>";
            echo "</td></tr>";
            
            $allCourses = $conn->query("SELECT * FROM courses ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr><th>Courses</th><td>";
            echo "<div class='checkbox-container'>";
            foreach ($allCourses as $course) {
                $checked = in_array($course['name'], explode(',', $result['Courses'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='courses[]' value='" . htmlspecialchars($course['name']) . "' $checked>" . htmlspecialchars($course['name']) . "</label>";
            }
            echo "</div>";
            echo "</td></tr>";
            
            $allChapters = $conn->query("SELECT * FROM chapters ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr><th>Chapters</th><td>";
            echo "<div class='checkbox-container'>";
            foreach ($allChapters as $chapter) {
                $checked = in_array($chapter['name'], explode(',', $result['Chapters'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='chapters[]' value='" . htmlspecialchars($chapter['name']) . "' $checked>" . htmlspecialchars($chapter['name']) . "</label>";
            }
            echo "</td></tr>";
            
            $allCategories = $conn->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr><th>Categories</th><td>";
            echo "<div class='checkbox-container'>";
            foreach ($allCategories as $category) {
                $checked = in_array($category['name'], explode(',', $result['Categories'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='categories[]' value='" . htmlspecialchars($category['name']) . "' $checked>" . htmlspecialchars($category['name']) . "</label>";
            }
            echo "</div>";
            echo "</td></tr>";
            
            $allExams = $conn->query("SELECT * FROM exams ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr><th>Exams</th><td>";
            echo "<div class='checkbox-container'>";
            foreach ($allExams as $exam) {
                $checked = in_array($exam['name'], explode(',', $result['Exams'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='exams[]' value='" . htmlspecialchars($exam['name']) . "' $checked>" . htmlspecialchars($exam['name']) . "</label>";
            }
            echo "</div>";
            echo "</td></tr>";
            
            echo "</table>";
            echo "</div>";
            
            if ($result['Type'] == 'MC' || $result['Type'] == 'MS') {
                $sqlMCMS = $conn->prepare("SELECT * FROM vraagmcms WHERE VraagID = ?");
                $sqlMCMS->bindParam(1, $result['ID']);
                $sqlMCMS->execute();
                
                $vraagmcmsResults = $sqlMCMS->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<div class='right-column'>";
                echo "<h3>MC/MS Details</h3>";
                if (count($vraagmcmsResults) > 0) {
                    echo "<table class='table table-bordered'>";
                    foreach ($vraagmcmsResults as $row) {
                        echo "<tr style='background-color:#333333;color:white;'><th>VraagID</th><td>" . htmlspecialchars($row['VraagID']) . "</td></tr>";
                        echo "<tr><th>Number Options</th><td>" . htmlspecialchars($row['NumberOptions']) . "</td></tr>";
                        
                        $optionUniqueValue = $row['OptionUnique'];
                        
                        echo "<tr><th>Option Unique</th><td>
                            <select name='optionunique'>";
                        
                        echo "<option value='1' " . ($optionUniqueValue == 1 ? 'selected' : '') . ">True</option>";
                        echo "<option value='0' " . ($optionUniqueValue == 0 ? 'selected' : '') . ">False</option>";
                        
                        echo "</select></td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No answer options found for this question.</p>";
                }
                
                $sqlOptionMCMS = $conn->prepare("SELECT * FROM optionmcms WHERE OptionID = ?");
                $sqlOptionMCMS->bindParam(1, $result['ID']);
                $sqlOptionMCMS->execute();
                $optionmcmsResults = $sqlOptionMCMS->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<h3>MC/MS Options Details</h3>";
                if (count($optionmcmsResults) > 0) {
                    echo "<table class='table table-bordered'>";
                    foreach ($optionmcmsResults as $index => $row) {
                        echo "<input type='hidden' name='options[$index][optionNumber]' value='" . htmlspecialchars($row['OptionNumber']) . "'>";
                        
                        echo "<tr style='background-color:#333333;color:white;'><th>OptionID</th><td>" . htmlspecialchars($row['OptionID']) . "</td></tr>";
                        echo "<tr><th>OptionNumber</th><td>" . htmlspecialchars($row['OptionNumber']) . "</td></tr>";
                        echo "<tr><th>Option</th><td><textarea name='options[$index][option]' rows='1' style='width:100%;'>" . htmlspecialchars($row['Option']) . "</textarea></td></tr>";
                        echo "<tr><th>OptionPoints</th><td><input type='text' name='options[$index][optionPoints]' value='" . htmlspecialchars($row['OptionPoints']) . "'></td></tr>";
                        echo "<tr><th>OptionFeedback</th><td><input type='text' name='options[$index][optionFeedback]' value='" . htmlspecialchars($row['OptionFeedback']) . "'></td></tr>";
                        echo "<tr><th>OptionRequired</th><td><input type='checkbox' name='options[$index][optionRequired]' " . ($row['OptionRequired'] == 1 ? 'checked' : '') . "></td></tr>";
                        echo "<tr><th>OptionExpression</th><td><input type='checkbox' name='options[$index][optionExpression]' " . ($row['OptionExpression'] == 1 ? 'checked' : '') . "></td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No answer options found for this question.</p>";
                }
                echo "</div>";
                echo "</div>";
                echo "</form>";
            } elseif ($result['Type'] == 'TF') {
                $sqlTF = $conn->prepare("SELECT * FROM vraagtf WHERE VraagID = ?");
                $sqlTF->bindParam(1, $result['ID']);
                $sqlTF->execute();
                $vraagtfResult = $sqlTF->fetch(PDO::FETCH_ASSOC);
                
                echo "<div class='right-column'>";
                echo "<h3>TF Details</h3>";
                echo "<input type='hidden' name='vraag_id' value='" . htmlspecialchars($vraagtfResult['VraagID']) . "'>";
                echo "<table class='table table-bordered'>";
                echo "<tr style='background-color:#333333;color:white;'><th>VraagID</th><td>" . htmlspecialchars($vraagtfResult['VraagID']) . "</td></tr>";
                echo "<tr><th>True</th><td><input type='text' name='true_text' value='" . htmlspecialchars($vraagtfResult['True']) . "'></td></tr>";
                echo "<tr><th>TrueFeedback</th><td><input type='text' name='true_feedback' value='" . htmlspecialchars($vraagtfResult['TrueFeedback']) . "'></td></tr>";
                echo "<tr><th>False</th><td><input type='text' name='false_text' value='" . htmlspecialchars($vraagtfResult['False']) . "'></td></tr>";
                echo "<tr><th>FalseFeedback</th><td><input type='text' name='false_feedback' value='" . htmlspecialchars($vraagtfResult['FalseFeedback']) . "'></td></tr>";
                echo "</table>";
                echo "</div>";
                echo "</form>";
            } elseif ($result['Type'] == 'WR') {
                $sqlTF = $conn->prepare("SELECT * FROM vraagwr WHERE VraagID = ?");
                $sqlTF->bindParam(1, $result['ID']);
                $sqlTF->execute();
                $vraagwrResult = $sqlTF->fetch(PDO::FETCH_ASSOC);
                
                echo "<div class='right-column'>";
                echo "<h3>WR Details</h3>";
                echo "<input type='hidden' name='vraag_id' value='" . htmlspecialchars($vraagwrResult['VraagID']) . "'>";
                echo "<table class='table table-bordered'>";
                echo "<tr style='background-color:#333333;color:white;'><th>VraagID</th><td>" . htmlspecialchars($vraagwrResult['VraagID']) . "</td></tr>";
                echo "<tr><th>Initial Text</th><td><input type='text' name='initialText' value='" . htmlspecialchars($vraagwrResult['InitialText']) . "'></td></tr>";
                echo "<tr><th>Answer Key</th><td><input type='text' name='answerKey' value='" . htmlspecialchars($vraagwrResult['AnswerKey']) . "'></td></tr>";
                echo "<tr><th>Answer Type</th><td><input type='text' name='answerType' value='" . htmlspecialchars($vraagwrResult['AnswerType']) . "'></td></tr>";
                echo "</table>";
                echo "</div>";
                echo "</form>";
            }
        } else {
            echo "<p>No question found with the title: " . htmlspecialchars($input) . "</p>";
        }
    }
    
    public function updateVraag($id, $title, $points, $time, $difficulty, $image, $questionText, $feedback, $hint, $pool, $tags, $courses, $chapters, $categories, $exams) {
        require 'connect.php';
        
        $stmt = $conn->prepare("
            UPDATE vraag
            SET Title = ?, Points = ?, Time = ?, Difficulty = ?, Image = ?, QuestionText = ?, Feedback = ?, Hint = ?, Pool = ?, Tags = ?, Courses = ?, Chapters = ?, Categories = ?, Exams = ?
            WHERE ID = ?
        ");
        
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $points);
        $stmt->bindParam(3, $time);
        $stmt->bindParam(4, $difficulty);
        $stmt->bindParam(5, $image);
        $stmt->bindParam(6, $questionText);
        $stmt->bindParam(7, $feedback);
        $stmt->bindParam(8, $hint);
        $stmt->bindParam(9, $pool);
        $stmt->bindParam(10, $tags);
        $stmt->bindParam(11, $courses);
        $stmt->bindParam(12, $chapters);
        $stmt->bindParam(13, $categories);
        $stmt->bindParam(14, $exams);
        $stmt->bindParam(15, $id);
        
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function updateVraagMCMS($id, $optionUnique) {
        require 'connect.php';
        
        $stmt = $conn->prepare("
            UPDATE vraagmcms
            SET OptionUnique = ?
            WHERE VraagID = ?
        ");
        
        $stmt->bindParam(1, $optionUnique);
        $stmt->bindParam(2, $id);
        echo "<br>Received Option Unique: " . $optionUnique;
        
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function updateOptionsMCMS($id, $optionNumber, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression) {
        require 'connect.php';
        
        $stmt = $conn->prepare("
            UPDATE optionmcms
            SET Option = ?, OptionPoints = ?, OptionFeedback = ?, OptionRequired = ?, OptionExpression = ?
            WHERE OptionID = ? AND OptionNumber = ?
        ");
        
        $stmt->bindParam(1, $optionTitle);
        $stmt->bindParam(2, $optionPoints);
        $stmt->bindParam(3, $optionFeedback);
        $stmt->bindParam(4, $optionRequired);
        $stmt->bindParam(5, $optionExpression);
        $stmt->bindParam(6, $id);
        $stmt->bindParam(7, $optionNumber);
        
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function updateOptionMCMS($id, $optionUnique) {
        require 'connect.php';
        
        $stmt = $conn->prepare("
            UPDATE vraagmcms
            SET OptionUnique = ?
            WHERE VraagID = ?
        ");
        
        $stmt->bindParam(1, $optionUnique);
        $stmt->bindParam(2, $id);
        echo "<br>Received Option Unique: " . $optionUnique;
        
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function updateVraagTF($id, $true_text, $true_feedback, $false_text, $false_feedback) {
        require 'connect.php';
        
        $stmt = $conn->prepare("
            UPDATE vraagtf
            SET `True` = ?, TrueFeedback = ?, `False` = ?, FalseFeedback = ?
            WHERE VraagID = ?
        ");
        
        $stmt->bindParam(1, $true_text);
        echo $true_text . "<br>";
        $stmt->bindParam(2, $true_feedback);
        echo $true_feedback . "<br>";
        $stmt->bindParam(3, $false_text);
        echo $false_text . "<br>";
        $stmt->bindParam(4, $false_feedback);
        echo $false_feedback . "<br>";
        $stmt->bindParam(5, $id);
        echo $id . "<br>";
        
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function updateVraagWR($id, $initialText, $answerKey, $answerType) {
        require 'connect.php';
        
        $stmt = $conn->prepare("
            UPDATE vraagwr SET InitialText = ?, AnswerKey = ?, AnswerType = ?
            WHERE VraagID = ?
        ");
        
        $stmt->bindParam(1, $initialText);
        $stmt->bindParam(2, $answerKey);
        $stmt->bindParam(3, $answerType);
        $stmt->bindParam(4, $id);
        
        $stmt->execute();
        $stmt->closeCursor();
    }
    
    public function allGroupChecker($function, $group, $name) {
        require "connect.php";
        
        if ($function == "create") {
            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM $group WHERE name = ?");
            $stmt_check->bindParam(1, $name);
            $stmt_check->execute();
            $count = $stmt_check->fetchColumn();
            $stmt_check->closeCursor();
            if ($count > 0) {
                echo "Error: Name '$name' already exists in '$group' table.";
                return;
            }
            $stmt = $conn->prepare("INSERT INTO $group (name) VALUES (?)");
            $stmt->bindParam(1, $name);
            $stmt->execute();
            echo "New entry '$name' added to '$group' table.";
        } elseif ($function == "delete") {
            $stmt = $conn->prepare("DELETE FROM $group WHERE name = ?");
            $stmt->bindParam(1, $name);
            $stmt->execute();
            echo "Entry '$name' deleted from '$group' table.";
        } elseif ($function == "show") {
            $stmt = $conn->prepare("SELECT * FROM $group");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            if (empty($result)) {
                echo "No entries found in '$group' table.";
            } else {
                echo "<h2>Entries in '$group' table:</h2>";
                echo "<table style='width: 100%;' border='1'>";
                echo "<tr><th>ID</th><th>Name</th></tr>";
                foreach ($result as $row) {
                    echo "<tr><td>" . htmlspecialchars($row['ID']) . "</td><td>" . htmlspecialchars($row['name']) . "</td></tr>";
                }
                echo "</table>";
            }
        }
    }
    
    public function showAllGroups() {
        require "connect.php";
        
        $groups = ['pool', 'tags', 'courses', 'chapters', 'categories', 'exams'];
        
        $results = [];
        foreach ($groups as $group) {
            $stmt = $conn->prepare("SELECT * FROM $group ORDER BY name ASC");
            $stmt->execute();
            $results[$group] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        }
        
        echo "<div style='width:100%;' class='container'>";
        foreach ($groups as $group) {
            echo '<div style="text-align:center;">
            <h3>' . ucfirst($group) . '</h3>
            <table class="nested-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Change</th>
                </tr>';
            foreach ($results[$group] as $row) {
                echo "<tr>
                    <form action='' method='post'>
                        <td>" . htmlspecialchars($row['ID']) . "</td>
                        <td><input style='width:100%;' name='name' value='" . htmlspecialchars($row['name']) . "'></input></td>
                        <td style='text-align:center;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row['ID']) . "'>
                            <input type='hidden' name='group' value='" . htmlspecialchars($group) . "'>
                            <input type='hidden' name='oldname' value='" . htmlspecialchars($row['name']) . "'>
                            <input type='submit' name='update' value='Update'>
                            <input type='submit' name='delete' value='Delete' style='background-color: red'>
                        </td>
                    </form>
                </tr>";
            }
            echo '</table>
        </div>';
        }
        echo '</div>';
    }
    
    public function deleteEntry($id, $group, $oldname) {
        require "connect.php";
        
        $column = ucfirst(strtolower($group));
        
        try {
            $stmt = $conn->prepare("DELETE FROM $group WHERE ID = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $stmt->closeCursor();
            
            echo "Entry name '$oldname' with ID '$id' deleted from '$group' table.<br><br>";
            
            $stmt = $conn->prepare("SELECT * FROM vraag");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($results as $result) {
                if (isset($result[$column])) {
                    if ($column === "Pool") {
                        $trimmed = str_replace($oldname, '', $result[$column]);
                    } else {
                        $remove = $oldname . ',';
                        $trimmed = str_replace($remove, '', $result[$column]);
                    }
                    
                    $stmt = $conn->prepare("
                        UPDATE vraag
                        SET $column = ?
                        WHERE ID = ?
                    ");
                    $stmt->bindParam(1, $trimmed);
                    $stmt->bindParam(2, $result['ID']);
                    $stmt->execute();
                    $stmt->closeCursor();
                } else {
                    echo "<br>Warning: Column '$column' does not exist in the row with ID " . $result['ID'] . ".";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    public function updateEntry($id, $oldname, $name, $group) {
        require "connect.php";
        
        $column = ucfirst(strtolower($group));
        
        try {
            $stmt = $conn->prepare("UPDATE $group SET name = ? WHERE ID = ?");
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $id);
            $stmt->execute();
            $stmt->closeCursor();
            
            echo "Entry with ID '$id' updated in '$group' table; '$oldname' now '$name'.";
            
            $stmt = $conn->prepare("SELECT * FROM vraag");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($results as $result) {
                if (isset($result[$column]) && strpos($result[$column], $oldname) !== false) {
                    echo "<br>Group to update: " . $column;
                    echo "<br>Old name: " . $oldname;
                    echo "<br>New entry: " . $name;
                    echo "<br>Received result group: " . $result[$column];
                    
                    $updatedGroup = str_replace($oldname, $name, $result[$column]);
                    
                    echo "<br>Updated group: " . $updatedGroup . "<br>";
                    
                    $stmt = $conn->prepare("UPDATE vraag SET $column = ? WHERE ID = ?");
                    $stmt->bindParam(1, $updatedGroup);
                    $stmt->bindParam(2, $result['ID']);
                    $stmt->execute();
                    $stmt->closeCursor();
                } else {
                    if (!isset($result[$column])) {
                        echo "<br>Warning: Column '$column' does not exist in the row with ID " . $result['ID'] . ".";
                    }
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function showAllVragen() {
        require "connect.php";
        
        $results = [];
        $stmt = $conn->prepare("SELECT * FROM vraag");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        echo "<h3>Question Details</h3>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<thead style='background-color:#333333;color:white;'>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Points</th>
                    <th>Time</th>
                    <th>Difficulty</th>
                    <th>Image</th>
                    <th>Question Text</th>
                    <th>Feedback</th>
                    <th>Hint</th>
                    <th>Pool</th>
                    <th>Tags</th>
                    <th>Courses</th>
                    <th>Chapters</th>
                    <th>Categories</th>
                    <th>Exams</th>
                </tr>
            </thead>";
        foreach ($results as $result) {
            echo "<tbody>";
            echo "<tr>";
            echo "<td>" . $result["ID"] . "</td>";
            echo "<td>" . $result["Type"] . "</td>";
            echo "<td>" . $result["Title"] . "</td>";
            echo "<td>" . $result["Points"] . "</td>";
            echo "<td>" . $result["Time"] . "</td>";
            echo "<td>" . $result["Difficulty"] . "</td>";
            echo "<td>" . $result["Image"] . "</td>";
            echo "<td style='padding: 0; margin: 0;'><textarea readonly style='width: 100%; height: 100%; box-sizing: border-box;'>" . $result["QuestionText"] . "</textarea></td>";
            echo "<td style='padding: 0; margin: 0;'><textarea readonly style='width: 100%; height: 100%; box-sizing: border-box;'>" . $result["Feedback"] . "</textarea></td>";
            echo "<td>" . $result["Hint"] . "</td>";
            echo "<td>" . $result["Pool"] . "</td>";
            echo "<td>" . $result["Tags"] . "</td>";
            echo "<td>" . $result["Courses"] . "</td>";
            echo "<td>" . $result["Chapters"] . "</td>";
            echo "<td>" . $result["Categories"] . "</td>";
            echo "<td>" . $result["Exams"] . "</td>";
            echo "</tr>";
            echo "</tbody>";
        }
    }
    
    public function getSelectableVragen() {
        require "connect.php";
        
        $stmt = $conn->prepare("SELECT * FROM vraag");
        $stmt->execute();
        $vragen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        echo '<table>
            <tr>
                <th><input type="checkbox" onclick="toggleSelectAll(this)"></th>
                <th>ID</th>
                <th>Title</th>
                <th>Question Text</th>
                <th>Feedback</th>
                <th>Pool</th>
                <th>Tags</th>
                <th>Courses</th>
                <th>Chapters</th>
                <th>Categories</th>
                <th>Exams</th>
            </tr>
            <tr>
                <td></td>
                <td><input id="search_id" style="width:100%;" maxlength="3" type="text" name="search_id" oninput="search()"></td>
                <td><input id="search_title" style="width:100%;" type="text" name="search_title" oninput="search()"></td>
                <td><input id="search_question" style="width:100%;" type="text" name="search_question" oninput="search()"></td>
                <td><input id="search_feedback" style="width:100%;" type="text" name="search_feedback" oninput="search()"></td>
                <td><input id="search_pool" style="width:100%;" type="text" name="search_pool" oninput="search()"></td>
                <td><input id="search_tags" style="width:100%;" type="text" name="search_tags" oninput="search()"></td>
                <td><input id="search_courses" style="width:100%;" type="text" name="search_courses" oninput="search()"></td>
                <td><input id="search_chapters" style="width:100%;" type="text" name="search_chapters" oninput="search()"></td>
                <td><input id="search_categories" style="width:100%;" type="text" name="search_categories" oninput="search()"></td>
                <td><input id="search_exams" style="width:100%;" type="text" name="search_exams" oninput="search()"></td>
            </tr>';
        
        foreach ($vragen as $vraag) {
            echo '<tr class="vraagRow">
                <td><input type="checkbox" name="selected_questions[]" value="' . $vraag['ID'] . '"></td>
                <td class="id">' . $vraag['ID'] . '</td>
                <td class="title">' . $vraag['Title'] . '</td>
                <td class="question"><textarea readonly style="width: 100%; height: 100%;">' . $vraag['QuestionText'] . '</textarea></td>
                <td class="feedback"><textarea readonly style="width: 100%; height: 100%;">' . $vraag['Feedback'] . '</textarea></td>
                <td class="pool">' . $vraag['Pool'] . '</td>
                <td class="tags">' . $vraag['Tags'] . '</td>
                <td class="courses">' . $vraag['Courses'] . '</td>
                <td class="chapters">' . $vraag['Chapters'] . '</td>
                <td class="categories">' . $vraag['Categories'] . '</td>
                <td class="exams">' . $vraag['Exams'] . '</td>
            </tr>';
        }
        
        echo '</table>';
    }
    
    public function showSelectVragen() {
        require "connect.php";
        
        $stmt = $conn->prepare("SELECT * FROM vraag");
        $stmt->execute();
        $vragen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        echo '<table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Question Text</th>
                <th>Feedback</th>
                <th>Pool</th>
                <th>Tags</th>
                <th>Courses</th>
                <th>Chapters</th>
                <th>Categories</th>
                <th>Exams</th>
            </tr>
            <tr>
                <td><input id="search_id" style="width:100%;" maxlength="3" type="text" name="search_id" oninput="search()"></td>
                <td><input id="search_title" style="width:100%;" type="text" name="search_title" oninput="search()"></td>
                <td><input id="search_question" style="width:100%;" type="text" name="search_question" oninput="search()"></td>
                <td><input id="search_feedback" style="width:100%;" type="text" name="search_feedback" oninput="search()"></td>
                <td><input id="search_pool" style="width:100%;" type="text" name="search_pool" oninput="search()"></td>
                <td><input id="search_tags" style="width:100%;" type="text" name="search_tags" oninput="search()"></td>
                <td><input id="search_courses" style="width:100%;" type="text" name="search_courses" oninput="search()"></td>
                <td><input id="search_chapters" style="width:100%;" type="text" name="search_chapters" oninput="search()"></td>
                <td><input id="search_categories" style="width:100%;" type="text" name="search_categories" oninput="search()"></td>
                <td><input id="search_exams" style="width:100%;" type="text" name="search_exams" oninput="search()"></td>
            </tr>';
        
        foreach ($vragen as $vraag) {
            echo '<tr class="vraagRow">
                <td class="id">' . $vraag['ID'] . '</td>
                <td class="title">' . $vraag['Title'] . '</td>
                <td class="question"><textarea readonly style="width: 100%; height: 100%;">' . $vraag['QuestionText'] . '</textarea></td>
                <td class="feedback"><textarea readonly style="width: 100%; height: 100%;">' . $vraag['Feedback'] . '</textarea></td>
                <td class="pool">' . $vraag['Pool'] . '</td>
                <td class="tags">' . $vraag['Tags'] . '</td>
                <td class="courses">' . $vraag['Courses'] . '</td>
                <td class="chapters">' . $vraag['Chapters'] . '</td>
                <td class="categories">' . $vraag['Categories'] . '</td>
                <td class="exams">' . $vraag['Exams'] . '</td>
            </tr>';
        }
        
        echo '</table>';
    }
    
    


}?>

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