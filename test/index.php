<?php

require __DIR__ . "../../vendor/autoload.php";

use FormHelper\FormHelper;

$form = new FormHelper;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM - TEST</title>
</head>

<body>
    <?php print_r($form->basicCleanXSS($_POST['teste']) ?? "") ?>
    <?= $form::form(
        '',
        [],
        <<<CONTENT
    <h1>Teste</h1>
    <input type="text" name="teste" id="" placeholder="Teste">
    <input type="submit" name="enviar" placeholder="Enviar">
    CONTENT,
        true
    ); ?>
    <?php print_r($_SESSION) ?>

</body>

</html>