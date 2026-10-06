<?php

function totalAgendamentos($lista)
{
    return count($lista);
}

function contarPessoas($lista)
{
    $nomes = [];

    foreach ($lista as $item) {
        $nomes[$item["paciente"]] = true;
    }

    return count($nomes);
}

function contarAreas($lista)
{
    $areas = [];

    foreach ($lista as $item) {

        $area = $item["especialidade"];

        if (isset($areas[$area])) {
            $areas[$area]++;
        } else {
            $areas[$area] = 1;
        }
    }

    return $areas;
}

function ordenarPorHorario($lista)
{
    usort($lista, function ($primeiro, $segundo) {
        return strcmp($primeiro["horario"], $segundo["horario"]);
    });

    return $lista;
}

function buscarPessoa($lista, $nome)
{
    $encontrados = [];

    foreach ($lista as $item) {

        if (strtolower($item["paciente"]) == strtolower($nome)) {
            $encontrados[] = $item;
        }
    }

    return $encontrados;
}

function verificarConflitos($lista)
{
    $horariosUsados = [];
    $conflitos = [];

    foreach ($lista as $item) {

        $chave = $item["data"] . " " . $item["horario"];

        if (isset($horariosUsados[$chave])) {
            $conflitos[] = $chave;
        } else {
            $horariosUsados[$chave] = true;
        }
    }

    return $conflitos;
}

function descobrirExtremos($lista)
{
    $lista = ordenarPorHorario($lista);

    return [
        "inicio" => $lista[0],
        "fim" => $lista[count($lista) - 1]
    ];
}

function analisarAgenda($lista)
{
    $agendaOrganizada = ordenarPorHorario($lista);
    $extremos = descobrirExtremos($lista);

    return [
        "total" => totalAgendamentos($lista),
        "pessoas" => contarPessoas($lista),
        "especialidades" => contarAreas($lista),
        "primeiro" => $extremos["inicio"],
        "ultimo" => $extremos["fim"],
        "ordenada" => $agendaOrganizada,
        "conflitos" => verificarConflitos($lista)
    ];
}

$consultas = [

    [
        "paciente" => "Lucas",
        "especialidade" => "Pediatria",
        "data" => "2026-10-10",
        "horario" => "08:00"
    ],

    [
        "paciente" => "Mariana",
        "especialidade" => "Ortopedia",
        "data" => "2026-10-10",
        "horario" => "09:00"
    ],

    [
        "paciente" => "Lucas",
        "especialidade" => "Pediatria",
        "data" => "2026-10-10",
        "horario" => "10:00"
    ]
];

$dados = analisarAgenda($consultas);

echo "Total de consultas: "
    . $dados["total"] . "<br>";

echo "Pacientes diferentes: "
    . $dados["pessoas"] . "<br><br>";

echo "Consultas por especialidade:<br>";

foreach ($dados["especialidades"] as $area => $quantidade) {
    echo $area . ": " . $quantidade . "<br>";
}

echo "<br>";

echo "Primeiro atendimento: "
    . $dados["primeiro"]["paciente"]
    . " - "
    . $dados["primeiro"]["horario"]
    . "<br>";

echo "Último atendimento: "
    . $dados["ultimo"]["paciente"]
    . " - "
    . $dados["ultimo"]["horario"]
    . "<br><br>";

echo "Agenda ordenada:<br>";

foreach ($dados["ordenada"] as $item) {

    echo $item["horario"]
        . " - "
        . $item["paciente"]
        . " - "
        . $item["especialidade"]
        . "<br>";
}

echo "<br>";

if (count($dados["conflitos"]) > 0) {

    echo "Horários duplicados:<br>";

    foreach ($dados["conflitos"] as $horario) {
        echo $horario . "<br>";
    }

} else {

    echo "Não existem horários duplicados.";
}

?>