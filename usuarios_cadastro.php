<?php
include 'usuarios_controller.php';
include 'header.php';

// Pega todos os usuários para preencher os dados da tabela
$users = getUsers();

// Variável que guarda o ID do usuário que será editado
$userToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
if (isset($_GET['edit'])) {
    $userId = intval($_GET['edit']); // Sanitiza o ID
    $userToEdit = getUser ($userId);
}

// Verifica se o formulário foi enviado para salvar ou atualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])) {
        // Código para salvar um novo usuário
        // Certifique-se de sanitizar e validar os dados do formulário
    } elseif (isset($_POST['update'])) {
        // Código para atualizar um usuário existente
        // Certifique-se de sanitizar e validar os dados do formulário
    }
}
?>
<body>
    <script src="js/main.js"></script>
    <h2>Cadastro de Usuários</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($userToEdit['id'] ?? '', ENT_QUOTES); ?>">
        
        <div class="form-group input">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" class="form-control" name="nome" value="<?php echo htmlspecialchars($userToEdit['nome'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" class="form-control" name="telefone" value="<?php echo htmlspecialchars($userToEdit['telefone'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($userToEdit['email'] ?? '', ENT_QUOTES); ?>" required><br><br>
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" required placeholder="Digite a senha"><br><br>
        </div>
        <button type="submit" class="btn btn-dark" name="save">Salvar</button>
        <button type="submit" class="btn btn-dark" name="update">Atualizar</button>
        <button type="button" class="btn btn-dark" onclick="clearForm()">Novo</button>
    </form>

    <h2>Usuários Cadastrados</h2>
    <table class="table" border="1">
        <tr class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <!-- Faz um loop FOR no resultset de usuários e preenche a tabela -->
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['nome']); ?></td>
                <td><?php echo htmlspecialchars($user['telefone']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="?edit=<?php echo $user['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include 'footer.php'; ?>
</body>
</html>