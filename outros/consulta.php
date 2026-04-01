<?php
header('Content-Type: application/json; charset=UTF-8');

// ================= CONFIG =================
$API_URL = "https://apela-api.tech/";
$USER_KEY = "ea1a016a1471433afa58754f647b6627";

// ================= VALIDACAO =================
if (!isset($_GET['cpf'])) {
    echo json_encode([
        "status" => 400,
        "erro" => "CPF não informado"
    ]);
    exit;
}

$cpf = preg_replace('/\D/', '', $_GET['cpf']);

if (strlen($cpf) !== 11) {
    echo json_encode([
        "status" => 400,
        "erro" => "CPF inválido"
    ]);
    exit;
}

// ================= CHAMADA API =================
$url = $API_URL . "?user=" . $USER_KEY . "&cpf=" . $cpf;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// ================= ERRO DE CONEXAO =================
if ($response === false || $httpCode !== 200) {
    echo json_encode([
        "status" => 500,
        "erro" => "Erro ao consultar base de dados"
    ]);
    exit;
}

$data = json_decode($response, true);

// ================= VALIDACAO DE DADOS =================
if (!isset($data['status']) || $data['status'] != 200) {
    echo json_encode([
        "status" => 404,
        "erro" => "CPF não localizado"
    ]);
    exit;
}

// ================= NORMALIZACAO (PADRAO FRONT) =================
$retorno = [
    "status" => 200,
    "dados" => [[
        "CPF" => $data["cpf"] ?? "",
        "NOME" => $data["nome"] ?? "",
        "NASC" => $data["nascimento"] ?? "",
        "NOME_MAE" => $data["mae"] ?? "",
        "SEXO" => strtoupper($data["sexo"] ?? "")
    ]]
];

echo json_encode($retorno, JSON_UNESCAPED_UNICODE);
exit;
