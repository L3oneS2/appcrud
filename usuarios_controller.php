<?php
// Verifica se a sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

function saveUser($nome, $telefone, $email, $senha) {
    global $conn;
    
    // Hash da senha antes de salvar
    $hashedPassword = password_hash($senha, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (?, ?, ?, ?)");
    
    // Verificação se o prepare foi bem-sucedido
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("ssss", $nome, $telefone, $email, $hashedPassword);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Erro ao salvar usuário: " . $stmt->error;
        return false;
    }
}

function getUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM usuarios");
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Erro ao buscar usuários: " . $conn->error;
        return [];
    }
}

function getUser($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUser($id, $nome, $telefone, $email, $senha) {
    global $conn;
    
    // Hash da senha antes de atualizar
    $hashedPassword = password_hash($senha, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, telefone = ?, email = ?, senha = ? WHERE id = ?");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("ssssi", $nome, $telefone, $email, $hashedPassword, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Erro ao atualizar usuário: " . $stmt->error;
        return false;
    }
}

function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Erro ao excluir usuário: " . $stmt->error;
        return false;
    }
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        saveUser($_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['senha']);
    } elseif (isset($_POST['update'])) {
        updateUser($_POST['id'], $_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['senha']);
    }
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteUser($_GET['delete']);
}
?>
