<?php
// filepath: c:\xampp\htdocs\Plantilla\dist\pages\existe_usuario.php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$response = [];

if (isset($data['email'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'login'); // Cambia 'login' por tu base de datos
    if ($mysqli->connect_errno) {
        $response['exists'] = false;
        echo json_encode($response);
        exit;
    }
    $email = $mysqli->real_escape_string($data['email']);
    $sql = "SELECT id FROM usuarios WHERE email='$email' LIMIT 1";
    $result = $mysqli->query($sql);
    $response['exists'] = ($result && $result->num_rows > 0);
    $mysqli->close();
} else {
    $response['exists'] = false;
}

if (isset($data['usuario'])) {
    $mysqli = new mysqli('localhost', 'root', '', 'login');
    if ($mysqli->connect_errno) {
        $response['usuarioExiste'] = false;
        echo json_encode($response);
        exit;
    }
    $usuario = $mysqli->real_escape_string($data['usuario']);
    $sql = "SELECT id FROM usuarios WHERE usuario='$usuario' LIMIT 1";
    $result = $mysqli->query($sql);
    $response['usuarioExiste'] = ($result && $result->num_rows > 0);
    $mysqli->close();
}

echo json_encode($response);
?>