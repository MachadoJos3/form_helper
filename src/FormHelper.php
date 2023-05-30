<?php

namespace FormHelper;

/** FormHelper Biblioteca com funções de validção de formulario e verificação de dados*/
class FormHelper
{
    /**
     * ####################
     * ###   STRINGS   ###
     * ####################
     */

    /**
     * Válida o tamanho mínimo e máximo de caracteres da string e os caracteres aceitos 
     *
     * @param string $string
     * @param string $min_length
     * @param string $max_length
     * @return boolean
     */

    public function validateStringLengthAndChars(string $string, string $min_length = '', string $max_length = '', array $allowed_chars = []): bool
    {
        $string = trim($string);
        if (is_string($string)) {
            if ($min_length && strlen($string) < $min_length) {
                return false;
            }

            if ($max_length && strlen($string) > $max_length) {
                return false;
            }
        }

        if (!empty($allowed_chars)) {
            foreach ($allowed_chars as $char) {
                if (strpos($string, $char) === false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * ####################
     * ###   MÁSCARAS   ###
     * ####################
     */

    /**Adiciona mascara para para cpf e cnpj
     *  @param string | int $string
     *  @return string
     */
    public static function maskCpfCnpj(string | int $documento): string
    {
        $documento = preg_replace('/[^0-9]/', '', $documento);
        if (strlen($documento) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $documento);
        } else if (strlen($documento) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $documento);
        } else {
            return $documento;
        }
    }
    /**Adiciona uma mascara ao numero de telefone não formatado caso o número passado seja sem o nono dígito ele é adicionado
     * @param string | int $string
     * @return string
     */
    public static function maskPhoneNumber(string | int $phone_number): string
    {
        $phone_number = preg_replace('/[^0-9]/', '', $phone_number);
        if (strlen($phone_number) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) 9 $2-$3', $phone_number);
        } else if (strlen($phone_number) === 11) {
            return preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2 $3-$4', $phone_number);
        } else {
            return $phone_number;
        }
    }

    /**
     * ################################
     * ###     ATAQUES/SEGURANÇA    ###
     * ###############################
     */

    /**
     * Função que previne ataques XSS. Deve ser usada ao exibir dados de formulários e bancos de dados.
     *
     * @param string $string A string a ser limpa e protegida contra ataques XSS.
     * @return string A string limpa e segura contra ataques XSS.
     */
    public function basicCleanXSS(string $string)
    {
        $output = strip_tags($string);
        //ENT_QUOTES é uma constante que significa que tanto as aspas duplas quanto as simples devem ser convertidas em entidades HTML
        $output = htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $output;
    }

    /**
     * Gera um token CSRF para formulários.
     * O token CSRF deve ser validado no lado do servidor para proteção contra ataques CSRF.
     *
     * @return string O token CSRF gerado.
     */
    public static function gerarCsrf()
    {
        // Gera um código CSRF
        $csrf_token = bin2hex(random_bytes(32));

        // Armazena o código CSRF em uma variável de sessão
        session_start();
        $_SESSION['csrf_token'] = $csrf_token;
        session_write_close();

        return $csrf_token;
    }

    /**
     * #######################
     * ###      EMAIL      ###
     * #######################
     */
    public function validateEmail($email, $allowed_chars = [])
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!empty($allowed_chars)) {
            foreach ($allowed_chars as $char) {
                if (strpos($email, $char) === false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Gera um formulário HTML com suporte a proteção CSRF.
     *
     * @param string $action O URL de destino do formulário.
     * @param array $attributes Atributos adicionais para o formulário (opcional).
     * @param string $content O conteúdo HTML do formulário (opcional).
     * @param bool $csrfToken Define se deve ser gerado e incluído um token CSRF no formulário (padrão: false).
     * @return string O código HTML do formulário gerado.
     */
    public static function form($action = '', $attributes = [], $content = '', $csrf_token = false)
    {
        $token = '';

        if (empty($attributes)) {
            $attributes = [
                'name'              => '',
                'method'            => 'POST',
                'enctype'           => 'multipart/form-data',
                'autocomplete'      => 'off',
            ];
        }
        if ($csrf_token) {
            $token = self::gerarCsrf();
        }

        $form = <<<FORM
    <form name="{$attributes['name']}" action="$action" method="{$attributes['method']}" enctype="{$attributes['enctype']}" autocomplete="{$attributes['autocomplete']}">
        <input type="hidden" name="csrf_token" value="$token">
        $content
    </form>
    FORM;

        return $form;
    }
}
