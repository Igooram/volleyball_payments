<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "volleyball_payments";

// Receber dados do POST
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];

// Lógica para verificar o pagamento (exemplo simplificado)
$payment_verified = false;
// Aqui você deve implementar a lógica real de verificação de pagamento por QR Code ou Pix
// Se o pagamento for verificado com sucesso, defina $payment_verified como true

if ($payment_verified) {
    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir pagamento
    $stmt = $conn->prepare("INSERT INTO payments (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false);
    }

    echo json_encode($response);

    $stmt->close();
    $conn->close();
} else {
    // Se o pagamento não for verificado, retorne uma resposta de erro
    echo json_encode(array("error" => "Pagamento não verificado."));
}
?>
