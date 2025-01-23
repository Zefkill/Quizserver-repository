<?php
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["zip_file"])) {
    $zipFilename = $_FILES["zip_file"]["tmp_name"];
    $zip = new ZipArchive();
    if ($zip->open($zipFilename) === TRUE) {
        $tempDir = tempnam(sys_get_temp_dir(), 'txtfiles');
        unlink($tempDir);
        mkdir($tempDir);
        $zip->extractTo($tempDir);
        
        $files = scandir($tempDir);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                $filePath = $tempDir . '/' . $file;
                $fileContent = file_get_contents($filePath);
                
                preg_match_all('/:(.*?):\s*([\s\S]*?)(?=\s*:\w+:\s*|$)/', $fileContent, $matches, PREG_SET_ORDER);
                $postData = [];
                foreach ($matches as $match) {
                    $key = trim($match[1]);
                    $value = trim($match[2]);
                    
                    if (in_array($key, ['Option', 'OptionPoints', 'OptionFeedback', 'OptionRequired', 'OptionExpression'])) {
                        if (!isset($postData[$key])) {
                            $postData[$key] = [];
                        }
                        $postData[$key][] = $value;
                    } else {
                        $postData[$key] = $value;
                    }
                }
                
                $allKeys = ['ID', 'Type', 'Title', 'Points', 'Time', 'Difficulty', 'Image', 'QuestionText', 'Feedback', 'Hint', 'Difficulty', 'Pool', 'NumberOptions', 'Option', 'OptionPoints', 'OptionFeedback', 'OptionRequired', 'OptionExpression', 'OptionUnique', 'Courses', 'Chapters', 'Tags', 'Categories', 'upload_zip'];
                
                foreach ($allKeys as $key) {
                    if (!isset($postData[$key])) {
                        $postData[$key] = '';
                    }
                }
                
                $_POST = $postData;
                
                $_POST['upload_zip'] = 'Upload ZIP';
                include 'conn/import.php';
            }
        }
        $zip->close();
        array_map('unlink', glob("$tempDir/*"));
        rmdir($tempDir);
    } else {
        echo "Failed to open zip archive";
    }
    exit;
}


function exportData($selectedQuestions = null) {
    global $conn;
    
    $tempDir = tempnam(sys_get_temp_dir(), 'export');
    unlink($tempDir);
    mkdir($tempDir);
    
    $vraagQuery = $conn->query("SELECT * FROM vraag");
    $vragen = $vraagQuery->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($vragen as $vraag) {
        if ($selectedQuestions && !in_array($vraag['ID'], $selectedQuestions)) {
            continue;
        }
        
        $vraagID = $vraag['ID'];
        $vraagTitle = $vraag['Title'];
        $filename = $tempDir . "/$vraagTitle.txt";
        $file = fopen($filename, 'w');
        
        fwrite($file, ":ID:\n{$vraag['ID']}\n");
        fwrite($file, ":Type:\n{$vraag['Type']}\n");
        fwrite($file, ":Title:\n{$vraag['Title']}\n");
        fwrite($file, ":Points:\n{$vraag['Points']}\n");
        fwrite($file, ":Time:\n{$vraag['Time']}\n");
        fwrite($file, ":Difficulty:\n{$vraag['Difficulty']}\n");
        fwrite($file, ":Image:\n{$vraag['Image']}\n");
        fwrite($file, ":QuestionText:\n{$vraag['QuestionText']}\n");
        fwrite($file, ":Feedback:\n{$vraag['Feedback']}\n");
        fwrite($file, ":Hint:\n{$vraag['Hint']}\n");
        fwrite($file, ":Pool:\n{$vraag['Pool']}\n");
        
        if ($vraag['Type'] == 'MC' || $vraag['Type'] == 'MS') {
            $mcmsQuery = $conn->prepare("SELECT * FROM vraagmcms WHERE VraagID = ?");
            $mcmsQuery->execute([$vraagID]);
            $vraagmcms = $mcmsQuery->fetch(PDO::FETCH_ASSOC);
            if ($vraagmcms) {
                fwrite($file, ":NumberOptions:\n{$vraagmcms['NumberOptions']}\n");
                fwrite($file, ":OptionUnique:\n{$vraagmcms['OptionUnique']}\n");
                
                $optionmcmsQuery = $conn->prepare("SELECT * FROM optionmcms WHERE OptionID = ?");
                $optionmcmsQuery->execute([$vraagID]);
                $optionmcms = $optionmcmsQuery->fetchAll(PDO::FETCH_ASSOC);
                foreach ($optionmcms as $option) {
                    fwrite($file, ":Option:\n{$option['Option']}\n");
                    fwrite($file, ":OptionPoints:\n{$option['OptionPoints']}\n");
                    fwrite($file, ":OptionFeedback:\n{$option['OptionFeedback']}\n");
                    fwrite($file, ":OptionRequired:\n{$option['OptionRequired']}\n");
                    fwrite($file, ":OptionExpression:\n{$option['OptionExpression']}\n");
                }
            }
        }
        
        if ($vraag['Type'] == 'TF') {
            $tfQuery = $conn->prepare("SELECT * FROM vraagtf WHERE VraagID = ?");
            $tfQuery->execute([$vraagID]);
            $vraagtf = $tfQuery->fetch(PDO::FETCH_ASSOC);
            if ($vraagtf) {
                fwrite($file, ":TRUE:\n{$vraagtf['True']}\n");
                fwrite($file, ":TrueFeedback:\n{$vraagtf['TrueFeedback']}\n");
                fwrite($file, ":FALSE:\n{$vraagtf['False']}\n");
                fwrite($file, ":FalseFeedback:\n{$vraagtf['FalseFeedback']}\n");
            }
        }
        
        if ($vraag['Type'] == 'WR') {
            $wrQuery = $conn->prepare("SELECT * FROM vraagwr WHERE VraagID = ?");
            $wrQuery->execute([$vraagID]);
            $vraagwr = $wrQuery->fetch(PDO::FETCH_ASSOC);
            if ($vraagwr) {
                fwrite($file, ":InitialText:\n{$vraagwr['InitialText']}\n");
                fwrite($file, ":AnswerKey:\n{$vraagwr['AnswerKey']}\n");
                fwrite($file, ":AnswerType:\n{$vraagwr['AnswerType']}\n");
            }
        }
        
        fwrite($file, ":Courses:\n{$vraag['Courses']}\n");
        fwrite($file, ":Chapters:\n{$vraag['Chapters']}\n");
        fwrite($file, ":Tags:\n{$vraag['Tags']}\n");
        fwrite($file, ":Categories:\n{$vraag['Categories']}\n");
        
        fclose($file);
    }
    
    $zip = new ZipArchive();
    $zipFilename = $tempDir . '/exported_data.zip';
    if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) {
        $files = scandir($tempDir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $zip->addFile("$tempDir/$file", $file);
            }
        }
        $zip->close();
    }
    
    foreach (scandir($tempDir) as $file) {
        if ($file != '.' && $file != '..' && $file != 'exported_data.zip') {
            unlink("$tempDir/$file");
        }
    }
    
    return $zipFilename;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["export_selected"])) {
        $selectedQuestions = $_POST['selected_questions'] ?? [];
        $customZipName = trim($_POST['zip_name_selected'] ?? '');
        $zipName = !empty($customZipName) ? "{$customZipName}_" . date('Y-m-d') : 'ExportSelected_' . date('Y-m-d');
        
        $exportedFile = exportData($selectedQuestions, $zipName);
        
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '.zip"');
        header('Content-Length: ' . filesize($exportedFile));
        
        ob_clean();
        flush();
        readfile($exportedFile);
        
        unlink($exportedFile);
        exit;
    }
    /* 
    elseif (isset($_POST["export"])) {
        $zipName = isset($_POST['zip_name_export']) && !empty($_POST['zip_name_export']) ? $_POST['zip_name_export'] : 'ExportZip_' . date('Y-m-d');
        $exportedFile = exportData(null, $zipName);
        
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '.zip"');
        header('Content-Length: ' . filesize($exportedFile));
        
        ob_clean();
        flush();
        readfile($exportedFile);
        
        unlink($exportedFile);
        exit;
    }
    */
}
?>
<div style="text-align:center;">
    <h1>Import .txt Files in ZIP</h1>
    <form method="post" enctype="multipart/form-data">
        <div style="text-align:center;">
            <input type="file" name="zip_file" accept=".zip" style="display:inline-block;">
        </div>
        <input type="submit" name="upload_zip" value="Upload ZIP">
    </form>

    <!-- 
    <h1>Export Data</h1>
    <form method="post">
        <label for="zip_name_export">Zip File Name:</label>
        <input type="text" id="zip_name_export" name="zip_name_export" placeholder="Enter zip file name">
        <input type="submit" name="export" value="Export All Data">
    </form>
     -->
    
    <h1>Export Selected Questions</h1>
    <p>If none are selected, all will be exported.</p>
    <div style="width:100%;">
        <form method="post">
            <label for="zip_name_selected">Zip File Name:</label>
            <input type="text" id="zip_name_selected" name="zip_name_selected" placeholder="Enter zip file name">
            <input type="hidden" name="export_selected" value="1">
            <input type="submit" value="Export Selected">
            <br><br>
            <?php
            $vraag->getSelectableVragen();
            ?>
        </form>
    </div>
</div>

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
</script>

<?php 
require 'footer.php';
?>