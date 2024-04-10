<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "volleyball_payments";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verificar se o pagamento foi registrado
if ($_GET['paid'] == 'true') {
    // Consulta SQL para buscar os pagamentos
    $sql = "SELECT * FROM payments ORDER BY timestamp DESC";
    $result = $conn->query($sql);

    $payments = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $payments[] = array(
                'name' => $row['name'],
                'timestamp' => $row['timestamp']
            );
        }
    }

    echo json_encode($payments);
} else {
    echo json_encode(array());
}

$conn->close();
?>
