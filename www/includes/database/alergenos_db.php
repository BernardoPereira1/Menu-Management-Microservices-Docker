<?php
$host = 'db_alergenos'; // Ou o IP do servidor se estiver fora
$username = 'user';  // O nome de utilizador do MySQL
$password = 'password';      // A senha do MySQL (vazia se for a configuração padrão)
$alergenos_db = 'alergenos_db'; // Nome da base de dados

// Conectar ao MySQL
$conn = new mysqli($host, $username, $password, $alergenos_db);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sqlAlergenos = "SELECT * FROM Alergenos";
$resultAlergenos = $conn->query($sqlAlergenos);

// Eliminar Alergeno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_alergeno'])) {
    $sql = "DELETE FROM Alergenos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['delete_alergeno']);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}

// Adicionar Alergeno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alergeno'])) {
    $novaDesignacao = trim($_POST['alergeno']);
    if (!empty($novaDesignacao)) {
        $sql = "INSERT INTO Alergenos (alergeno) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $novaDesignacao);
        $stmt->execute();
        header("Location: admin.php"); // Atualiza a página
        exit;
    }
}

// Atualizar Alergeno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_alergeno_id']) && isset($_POST['edit_alergeno'])) {
    $id = $_POST['edit_alergeno_id'];
    $alergeno = $_POST['edit_alergeno'];

    if (!empty($alergeno) && is_numeric($id)) {
        $sql = "UPDATE Alergenos SET alergeno = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $alergeno, $id);
        $stmt->execute();
    }

    header("Location: admin.php");
    exit;
}

?>
