<?php
// Configurações do Banco de Dados
$host = "";
$dbname = "";
$username = "";
$password = "";

// Definir o cabeçalho para JSON
header("Content-Type: application/json");

try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Buscar os Úlimos 10 registros
    //$stmt = $pdo->query("SELECT id, number, DATE_FORMAT(data, '%d/%m/%Y %H:%i:%s') AS data FROM esp01 ORDER BY id DESC LIMIT 10");
    $stmt = $pdo->query("SELECT id, number, DATE_FORMAT(data, '%Y-%m-%d %H:%i:%s') AS data FROM esp01 ORDER BY id DESC LIMIT 10");

    $data = $stmt->fetchAll();

    // Retornar os dados em JSON
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["status" => "Erro", "message" => "Erro no banco de dados"]);
}
