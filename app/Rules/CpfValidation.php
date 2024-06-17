<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValidation implements ValidationRule
{
    /**
     * Validador customizado de cpf.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace("/[^0-9]/", "", $value);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            $fail("The :attribute is not a valid CPF."); //mensagem de erro
            return;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match("/(\d)\1{10}/", $cpf)) {
            $fail("The :attribute is not a valid CPF.");
            return;
        }

        // Calcula os dígitos verificadores para validação
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail("The :attribute is not a valid CPF.");
                return;
            }
        }
    }
}
