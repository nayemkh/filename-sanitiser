<?php

include_once 'controller.php';

$controller = new FileSanitiser\Controller();
$controller->run();

$options = $controller->options;
$processedFilenames = $controller->filenames;
$messages = $controller->messages;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Filename Sanitiser</title>

        <link rel="stylesheet" href="/scss/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
        <script src="/js/app.js"></script>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <div class="core-style">
                    <h1 class="page-title">Filename Sanitiser</h1>
                </div>
            </div>
        </header>
        <main class="main">
            <div class="form-area">
                <div class="container">
                    <div class="core-style">
                        <?php if (is_array($messages) & !empty($messages)) { ?>
                            <ul class="messages" role="status">
                                <?php foreach ($messages as $message) { ?>
                                    <li><?=$message?></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <form method="POST" class="form">
                            <div class="form-group block">
                                <label for="filenames">Enter filenames you want to clean up, there should only be one filename per line.</label>
                                <textarea class="form-control" id="filenames" name="filenames" required><?= isset($_POST['filenames']) ? trim($_POST['filenames']) : '' ?></textarea>
                            </div>
                
                            <?php if (is_array($options) && !empty($options)) { ?>
                                <div class="form-group">
                                    <fieldset>
                                        <legend>Options</legend>   
                                        <?php foreach ($options as $key => $option) {
                                            $optionID = str_replace('_', '-', $key);
                                            $checkedHTML = isset($_POST[$optionID]) && $_POST[$optionID] === '1' ? 'checked' : '' ?>
                                            <div class="checkbox-group">
                                                <input type="checkbox" id="<?=$optionID?>" value="1" name="<?=$optionID?>" <?=$checkedHTML?>>
                                                <label for="<?=$optionID?>"><?=$option?></label>
                                            </div>
                                            <?php if ($key === 'capitalise_word') { ?>
                                                <div class="form-group block ignore-words">
                                                    <label for="ignore-words">Ignore specific words from capitalisation (comma separated):</label>
                                                    <input class="form-control" type="text" name="ignore-words" id="ignore-words" value="<?= isset($_POST['ignore-words']) ? trim($_POST['ignore-words']) : '' ?>">
                                                </div>
                                            <?php } ?>
                                        <?php } ?>             
                                    </fieldset>
                                </div>
                            <?php } ?>
                    
                            <div class="form-action">
                                <button class="btn" type="submit" aria-label="Submit filenames for clean-up">Clean up</button>
        
                                <?php if (is_array($processedFilenames) && !empty($processedFilenames)) { ?>
                                    <button class="btn" type="button" id="clear-form" aria-label="Clear entered data and results">Clear form</button>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (is_array($processedFilenames) && !empty($processedFilenames)) {
                $filenameCount = count($processedFilenames);
                $filenameText = $filenameCount > 1 ? 'filenames:' : 'filename:';
                $resultsHeading = 'You have sanitised ' . $filenameCount . ' ' . $filenameText; ?>
                <div class="results">
                    <div class="container">
                        <div class="core-style">
                            <h2 class="results-heading"><?=$resultsHeading?></h2>
                            <ul>
                                <?php foreach ($processedFilenames as $filename) { ?>
                                    <li><?=$filename?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </main>
    </body>
</html>