<?php
$host = 'db_ementas'; // Ou o IP do servidor se estiver fora
$username = 'user';  // O nome de utilizador do MySQL
$password = 'password';      // A senha do MySQL (vazia se for a configuração padrão)
$ementas_db = 'ementas_db'; // Nome da base de dados

// Conectar ao MySQL
$conn = new mysqli($host, $username, $password, $ementas_db);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para obter todos os pratos
$sqlPratos = "SELECT * FROM Prato";
$resultPratos = $conn->query($sqlPratos);

// Consulta SQL para obter as ementas com designação e alergenos do prato
$sqlEmentas = "SELECT Ementas.id, Ementas.data, Prato.designacao, Prato.alergeno_id 
               FROM Ementas
               INNER JOIN Prato ON Ementas.id_prato = Prato.id 
               ORDER BY Ementas.data";
$resultEmentas = $conn->query($sqlEmentas);

// Eliminar Prato
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_prato'])) {
    $sql = "DELETE FROM Prato WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['delete_prato']);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}

// Adicionar Prato
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_designacao'])) {
    $novaDesignacao = trim($_POST['new_designacao']);
    if (!empty($novaDesignacao)) {
        // Preparar o array de alergenos
        $alergenos = isset($_POST['alergenos']) ? $_POST['alergenos'] : null;
        $alergenos_json = $alergenos ? json_encode($alergenos) : null;
        
        $sql = "INSERT INTO Prato (designacao, alergeno_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $novaDesignacao, $alergenos_json);
        $stmt->execute();
        header("Location: admin.php"); // Atualiza a página
        exit;
    }
}

// Atualizar Prato
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_prato_id']) && isset($_POST['edit_designacao'])) {
    $id = $_POST['edit_prato_id'];
    $designacao = $_POST['edit_designacao'];
    $alergenos = isset($_POST['edit_alergenos']) ? json_decode($_POST['edit_alergenos'], true) : [];

    if (!empty($designacao) && is_numeric($id)) {
        $alergenos_json = json_encode($alergenos);
        $sql = "UPDATE Prato SET designacao = ?, alergeno_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $designacao, $alergenos_json, $id);
        $stmt->execute();
    }

    header("Location: admin.php");
    exit;
}

// Eliminar Ementa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ementa'])) {
    $sql = "DELETE FROM Ementas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_POST['delete_ementa']);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}

// Adicionar Ementa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data']) && isset($_POST['id_prato'])) {
    $data = $_POST['data'];
    $id_prato = $_POST['id_prato'];

    // Validação simples (opcional)
    if (!empty($data) && is_numeric($id_prato)) {
        $sql = "INSERT INTO Ementas (data, id_prato) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $data, $id_prato);
        $stmt->execute();
    }

    header("Location: admin.php");
    exit;
}

// Atualizar Ementa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_ementa_id']) && isset($_POST['edit_data']) && isset($_POST['edit_id_prato'])) {
    $id = $_POST['edit_ementa_id'];
    $data = $_POST['edit_data'];
    $id_prato = $_POST['edit_id_prato'];

    if (!empty($data) && !empty($id_prato) && is_numeric($id)) {
        $sql = "UPDATE Ementas SET data = ?, id_prato = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $data, $id_prato, $id);
        $stmt->execute();
    }

    header("Location: admin.php");
    exit;
}

// Função para autenticação
function authenticateUser($conn, $username, $password) {
    $sql = "SELECT password FROM Utilizador WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return password_verify($password, $row['password']);
    }
    return false;
}

?>
