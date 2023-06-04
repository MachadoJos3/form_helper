# FORM HELPER

Biblioteca PHP instalada via composer para validação de formulários

## Instalação

Use o comando 

```bash
composer require machado/form_validator
```

## Usando a biblioteca

```python
<?php

require __DIR__ . "../../vendor/autoload.php";

use FormHelper\FormHelper;

$form = new FormHelper;
# Crinado um formulario que permite uso de token CSRF
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
```

### Developers
* [José Machado] - Desenvolvedor back-end!
## License

[MIT](https://choosealicense.com/licenses/mit/)

[//]:#
[José Machado]: <mailto:machadodev03@gmail.com>