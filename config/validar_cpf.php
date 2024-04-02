<?php
if (isset($_POST['buscar_dados']) && !empty($_POST['buscar_dados'])) {
    $opcao = $_POST['buscar_dados'];
    if ($opcao == "cpf_dec") {
        $cpf_dec = $_POST['valorescolhido'];
        $cpf_formatando = sprintf('%011s', $cpf_dec);
        $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);

        function validarCPF($cpf)
        {
            // Remove caracteres não numéricos
            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            // Verifica se o CPF tem 11 dígitos
            if (strlen($cpf) != 11) {
                die('CPF inválido. O CPF deve conter 11 dígitos.');
            }

            // Verifica se todos os dígitos são iguais, o que invalida o CPF
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                echo "<script>
                alert('CPF inválido, Todos os digitos são iguais.');
                setTimeout(function() {
                    window.history.back(); // Volta para a página anterior
                }, 500);
                </script>";
                die();
            }

            // Calcula os dígitos verificadores
            for ($i = 9; $i < 11; $i++) {
                $digito = 0;
                for ($j = 0; $j < $i; $j++) {
                    $digito += $cpf[$j] * (($i + 1) - $j);
                }
                $digito = (($digito % 11) < 2) ? 0 : 11 - ($digito % 11);
                if ($cpf[$i] != $digito) {
                    echo "<script>
                    alert('CPF inválido.');
                    setTimeout(function() {
                        window.history.back(); // Volta para a página anterior
                    }, 500);
                    </script>";
                        die();
                }
            }
        }

        // Chama a função validarCPF com o CPF obtido do formulário
        $message = validarCPF($cpf_formatado);
    }
}
