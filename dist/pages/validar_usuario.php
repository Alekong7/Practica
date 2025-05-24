<?php
// filepath: c:\xampp\htdocs\Plantilla\dist\pages\validar_usuario.php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['usuario'], $data['password'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'login'); // Cambia 'midb' por tu base de datos
    if ($mysqli->connect_errno) {
        echo json_encode(['success' => false, 'error' => 'DB connection error']);
        exit;
    }
    $usuario = $mysqli->real_escape_string($data['usuario']);
    $password = $data['password'];
    $sql = "SELECT password FROM usuarios WHERE usuario='$usuario' LIMIT 1";
    $result = $mysqli->query($sql);
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
    $mysqli->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>