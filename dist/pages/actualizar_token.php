<?php
// filepath: c:\xampp\htdocs\Plantilla\dist\pages\actualizar_token.php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['usuario'], $data['token'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'login'); // Cambia 'login' por tu base de datos
    if ($mysqli->connect_errno) {
        echo json_encode(['success' => false, 'error' => 'DB connection error']);
        exit;
    }
    $usuario = $mysqli->real_escape_string($data['usuario']);
    $token = $mysqli->real_escape_string($data['token']);
    $sql = "UPDATE usuarios SET last_token='$token' WHERE usuario='$usuario'";
    if ($mysqli->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'DB update error']);
    }
    $mysqli->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>