<?php

include_once 'controller.php';

$controller = new FileSanitiser\Controller();
$controller->run();

$options = $controller->options;
$processedFilenames = $controller->filenames;
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
    <header class="header">
        <div class="container">
            <div class="core-style">
                <h1 class="page-title">Filename Sanitiser</h1>
            </div>
        </div>
    </header>
    <body>
        <main class="main">
            <div class="container">
                <div class="core-style">
                    <form method="POST" class="form">
                        <div class="form-group block">
                            <label for="filenames">Enter filenames you want to clean up, there should only be one filename per line.</label>
                            <textarea class="form-control" id="filenames" name="filenames"><?= isset($_POST['filenames']) ? trim($_POST['filenames']) : '' ?></textarea>
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
                
                        <button class="btn" type="submit" aria-label="Submit filenames for clean-up">Clean up</button>

                        <?php if (is_array($processedFilenames) && !empty($processedFilenames)) { ?>
                            <button class="btn" type="button" id="clear-form" aria-label="Clear entered data and results">Clear form</button>
                        <?php } ?>
                    </form>
            
                    <?php if (is_array($processedFilenames) && !empty($processedFilenames)) { ?>
                        <h2>Your sanitised filenames:</h2>
                        <ul>
                            <?php foreach ($processedFilenames as $filename) { ?>
                                <li><?=$filename?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </main>
    </body>
</html>