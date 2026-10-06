<?php

function calcularTamanho(string $frase)
{
    return strlen($frase);
}

function obterPalavras(string $frase): array
{
    $frase = trim($frase);
    $frase = preg_replace('/\s+/', ' ', $frase);

    return explode(' ', $frase);
}

function totalPalavras(string $frase)
{
    $lista = obterPalavras($frase);

    return count($lista);
}

function totalFrases(string $frase)
{
    $listaFrases = preg_split('/[.!?]+/', trim($frase));

    $listaFrases = array_filter($listaFrases, function ($item) {
        return trim($item) != '';
    });

    return count($listaFrases);
}

function palavraMaisLonga(array $lista): string
{
    $maiorTexto = '';

    foreach ($lista as $item) {

        if (strlen($item) > strlen($maiorTexto)) {
            $maiorTexto = $item;
        }
    }

    return $maiorTexto;
}

function palavraMaisCurta(array $lista): string
{
    $menorTexto = $lista[0];

    foreach ($lista as $item) {

        if (strlen($item) < strlen($menorTexto)) {
            $menorTexto = $item;
        }
    }

    return $menorTexto;
}