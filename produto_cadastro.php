<?php
include 'produtos_controller.php';
include 'header.php';

// Pega todos os produtos para preencher os dados da tabela
$products = getProducts();

// Variável que guarda o ID do produto que será editado
$productToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
if (isset($_GET['edit'])) {
    $productId = intval($_GET['edit']); // Sanitiza o ID
    $productToEdit = getProduct($productId);
}

// Verifica se o formulário foi enviado para salvar ou atualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        // Código para salvar um novo produto
        // Certifique-se de sanitizar e validar os dados do formulário
    } elseif (isset($_POST['update'])) {
        // Código para atualizar um produto existente
        // Certifique-se de sanitizar e validar os dados do formulário
    }
}
?>
<body>
    <script src="js/main.js"></script>
    <h2>Cadastro de Produtos</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($productToEdit['id'] ?? '', ENT_QUOTES); ?>">

        <div class="form-group input">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" class="form-control" name="nome" value="<?php echo htmlspecialchars($productToEdit['nome'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" class="form-control" name="descricao" required><?php echo htmlspecialchars($productToEdit['descricao'] ?? '', ENT_QUOTES); ?></textarea><br><br>
        </div>

        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" class="form-control" name="marca" value="<?php echo htmlspecialchars($productToEdit['marca'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" class="form-control" name="modelo" value="<?php echo htmlspecialchars($productToEdit['modelo'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="valorunitario">Valor Unitário:</label>
            <input type="number" id="valorunitario" class="form-control" name="valorunitario" step="0.01" value="<?php echo htmlspecialchars($productToEdit['valor'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" class="form-control" name="categoria" value="<?php echo htmlspecialchars($productToEdit['categoria'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>


        <button type="submit" class="btn btn-dark" name="save">Salvar</button>
        <button type="submit" class="btn btn-dark" name="update">Atualizar</button>
        <button type="button" class="btn btn-dark" onclick="clearForm()">Novo</button>
    </form>

    <h2>Produtos Cadastrados</h2>
    <table class="table" border="1">
        <tr class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Valor Unitário</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
        <!-- Faz um loop FOR no resultset de produtos e preenche a tabela -->
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['nome']); ?></td>
                <td><?php echo htmlspecialchars($product['descricao']); ?></td>
                <td><?php echo htmlspecialchars($product['marca']); ?></td>
                <td><?php echo htmlspecialchars($product['modelo']); ?></td>
                <td><?php echo htmlspecialchars($product['valor']); ?></td>
                <td><?php echo htmlspecialchars($product['categoria']); ?></td>
                <td>
                    <a href="?edit=<?php echo $product['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $product['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include 'footer.php'; ?>
</body>
</html>
