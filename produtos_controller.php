<?php
// Verifica se a sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Função para salvar um produto
function saveProduct($nome, $descricao, $marca, $modelo, $valorunitario, $categoria) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorunitario, categoria) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Verificação se o prepare foi bem-sucedido
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("ssssds", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Erro ao salvar produto: " . $stmt->error;
        return false;
    }
}

// Função para buscar todos os produtos
function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Erro ao buscar produtos: " . $conn->error;
        return [];
    }
}

// Função para buscar um produto específico pelo ID
function getProduct($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Função para atualizar um produto
function updateProduct($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valor = ?, categoria = ? WHERE id = ?");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("ssssdsi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Erro ao atualizar produto: " . $stmt->error;
        return false;
    }
}

// Função para excluir um produto
function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Erro ao excluir produto: " . $stmt->error;
        return false;
    }
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        saveProduct($_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $_POST['valorunitario'], $_POST['categoria']);
    } elseif (isset($_POST['update'])) {
        updateProduct($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $_POST['valorunitario'], $_POST['categoria']);
    }
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteProduct($_GET['delete']);
}
?>
