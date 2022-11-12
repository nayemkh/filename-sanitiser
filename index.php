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
    </head>
    <body>
        <h1>Clean up your filenames!</h1>
        <form method="POST">
            <label for="filenames">Enter filenames you want to clean up - one filename per line</label>
            <textarea id="filenames" name="filenames"></textarea>

            <?php if (is_array($options) && !empty($options)) { ?>
                <fieldset>
                    <legend>Options</legend>   
                    <?php foreach ($options as $key => $option) { ?>
                        <label for="<?=$key?>"><?=$option?></label>
                        <input type="checkbox" id="<?=$key?>" value="1" name="<?=$key?>">
                    <?php } ?>             
                </fieldset>
            <?php } ?>
    
            <button type="submit">Clean up</button>
        </form>

        <?php if (is_array($processedFilenames) && !empty($processedFilenames)) { ?>
            <h2>Your sanitised filenames:</h2>
            <ul>
                <?php foreach ($processedFilenames as $filename) { ?>
                    <li><?=$filename?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </body>
</html>