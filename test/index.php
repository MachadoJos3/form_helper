<?php

require __DIR__ . "../../vendor/autoload.php";

use FormHelper\FormHelper;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$form = new FormHelper;
$form->validateStringLengthAndChars("teste teste@", 1, '', ['@']);
print_r(
    $form::maskPhoneNumber('4284356748')
);
// $data = $_POST;
// $form->formNotEmpty($data);
?>
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM - TEST</title>
</head>

<body>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name">
        <br />
        <label for="email">Email:</label>
        <input type="email" name="email">
        <br />
        <label for="pass">Password:</label>
        <input type="password" name="pass"><br />
        <hr />
        <input type="submit" value="Enviar">
    </form>
</body>

</html> -->