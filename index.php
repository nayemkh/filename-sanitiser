<?php

include_once 'controller.php';

$controller = new FileSanitiser\Controller();
$controller->run();
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
            <button type="submit">Clean up</button>
        </form>
    </body>
</html>