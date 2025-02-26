<?php
require '../config/database.php';

header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['password']) || !isset($data['type'])) {
    echo json_encode(["error" => "Campos obrigatórios: name, email, password, type"]);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$type = $data['type']; // 'operator' ou 'user'

$conn = new \MySQLi($host, $username, "", $dbname); // Corrigir a ordem dos parâmetros

if ($type === 'operator') {
    $stmt = $conn->prepare("INSERT INTO operators (name, email, password_hash) VALUES (?, ?, ?)");
} elseif ($type === 'user' && isset($data['company_id'])) {
    $company_id = $data['company_id'];
    $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, company_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $password, $company_id);
} else {
    echo json_encode(["error" => "Tipo inválido ou falta company_id"]);
    exit;
}

$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    echo json_encode(["message" => "Cadastro realizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao cadastrar usuário"]);
}

$stmt->close();
$conn->close();

?>