<?php

namespace FormHelper;

/** FormHelper Biblioteca com funções de validção de formulario e verificação de dados*/
class FormHelper
{
    /**
     * Válida o tamanho mínimo e máximo de caracteres da string e os caracteres aceitos 
     *
     * @param string $string
     * @param string $min_length
     * @param string $max_length
     * @return boolean
     */
    public function validateStringLengthAndChars(string $string, string $min_length = '', string $max_length = ''): bool
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
            foreach (str_split($string) as $char) {
                if (!in_array($char, $allowed_chars)) {
                    return false;
                }
            }
        }
        return true;
    }
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
}
