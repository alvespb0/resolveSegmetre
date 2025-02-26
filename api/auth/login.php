<?php
require '../config/database.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["error" => "Campos obrigatórios"]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

$conn = getConnection();

// Verifica se é operador ou usuário
$stmt = $conn->prepare("SELECT id, password_hash, 'operator' as type FROM operators WHERE email = ?
                        UNION
                        SELECT id, password_hash, 'user' as type FROM users WHERE email = ?");
$stmt->bind_param("ss", $email, $email);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result && password_verify($password, $result['password_hash'])) {
    $token = bin2hex(random_bytes(32)); // Token simples
    echo json_encode(["token" => $token, "type" => $result['type']]);
} else {
    echo json_encode(["error" => "Credenciais inválidas"]);
}

$stmt->close();
$conn->close();
?>
