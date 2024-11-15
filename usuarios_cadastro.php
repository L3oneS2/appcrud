<?php
include 'usuarios_controller.php';
include 'header.php';

//Pega todos os usuários para preencher os dados da tabela
$users = getUsers();

//Variável que guarda o ID do usuário que será editado
$userToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e sé há um ID para edição de usuário
if (isset($_GET['edit'])) {
    $userToEdit = getUser($_GET['edit']);
}
?>
<body>
    <script src="js/main.js"></script>
    <h2>Cadastro de Usuários</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">
        
        <div class="form-group input">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" class="form-control" name="nome" value="<?php echo $userToEdit['nome'] ?? ''; ?>" required><br><br>
        </div>

        <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" class="form-control" name="telefone" value="<?php echo $userToEdit['telefone'] ?? ''; ?>" required><br><br>
        </div>

        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" class="form-control" name="email" value="<?php echo $userToEdit['email'] ?? ''; ?>" required><br><br>
        </div>

        <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" id="senha" name="senha" required><br><br>
        </div>
        <button type="submit" class="btn btn-dark" name="save">Salvar</button>
        <button type="submit" class="btn btn-dark" name="update">Atualizar</button>
        <button type="button" class="btn btn-dark" onclick="clearForm()">Novo</button>
    </form>

    <h2>Usuários Cadastrados</h2>
    <table class= "table" border="1">
        <tr class= "table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <!--Faz um loop FOR no resultset de usuários e preenche a tabela-->
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['nome']; ?></td>
                <td><?php echo $user['telefone']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <a href="?edit=<?php echo $user['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php include 'footer.php';?>
   
</body>
</html>