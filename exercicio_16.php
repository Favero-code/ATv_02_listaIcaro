<?php

function verificarMaiusculas($chave)
{
    $total = 0;

    for ($posicao = 0; $posicao < strlen($chave); $posicao++) {
        if (ctype_upper($chave[$posicao])) {
            $total++;
        }
    }

    return $total;
}

function verificarMinusculas($chave)
{
    $total = 0;

    for ($posicao = 0; $posicao < strlen($chave); $posicao++) {
        if (ctype_lower($chave[$posicao])) {
            $total++;
        }
    }

    return $total;
}

function verificarNumeros($chave)
{
    $total = 0;

    for ($posicao = 0; $posicao < strlen($chave); $posicao++) {
        if (ctype_digit($chave[$posicao])) {
            $total++;
        }
    }

    return $total;
}

function verificarSimbolos($chave)
{
    $total = 0;

    for ($posicao = 0; $posicao < strlen($chave); $posicao++) {
        if (!ctype_alnum($chave[$posicao])) {
            $total++;
        }
    }

    return $total;
}

function definirSeguranca($chave)
{
    $pontos = 0;

    if (strlen($chave) >= 8) {
        $pontos++;
    }

    if (verificarMaiusculas($chave) > 0) {
        $pontos++;
    }

    if (verificarMinusculas($chave) > 0) {
        $pontos++;
    }

    if (verificarNumeros($chave) > 0) {
        $pontos++;
    }

    if (verificarSimbolos($chave) > 0) {
        $pontos++;
    }

    if ($pontos <= 2) {
        return "Fraca";
    } elseif ($pontos == 3) {
        return "Média";
    } elseif ($pontos == 4) {
        return "Forte";
    } else {
        return "Muito Forte";
    }
}

function obterDadosSenha($chave)
{
    return [
        "senha" => $chave,
        "maiusculas" => verificarMaiusculas($chave),
        "minusculas" => verificarMinusculas($chave),
        "numeros" => verificarNumeros($chave),
        "simbolos" => verificarSimbolos($chave),
        "tamanho" => strlen($chave),
        "nivel" => definirSeguranca($chave)
    ];
}

?>

<form method="POST" action="">
    Digite a senha:
    <input type="password" name="senha">
    <input type="submit" value="Analisar">
</form>

<?php

if (isset($_POST["senha"])) {

    $senhaDigitada = $_POST["senha"];
    $dadosSenha = obterDadosSenha($senhaDigitada);

    echo "Senha: " . $dadosSenha["senha"] . "<br>";
    echo "Quantidade de letras maiúsculas: " . $dadosSenha["maiusculas"] . "<br>";
    echo "Quantidade de letras minúsculas: " . $dadosSenha["minusculas"] . "<br>";
    echo "Quantidade de números: " . $dadosSenha["numeros"] . "<br>";
    echo "Quantidade de caracteres especiais: " . $dadosSenha["simbolos"] . "<br>";
    echo "Tamanho da senha: " . $dadosSenha["tamanho"] . "<br>";
    echo "Nível de segurança: " . $dadosSenha["nivel"] . "<br>";
}

?>