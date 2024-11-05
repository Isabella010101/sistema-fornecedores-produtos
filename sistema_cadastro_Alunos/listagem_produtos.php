<!-- 4ª Digitação (Aqui) -->
 <!-- 4ª Digitação (Aqui) -->
<?php include('valida_sessao.php'); ?>
<!-- Inclui o script para validar a sessão do usuário -->
<?php include('conexao.php'); ?>
<!-- Inclui o script de conexão com o banco de dados -->

<?php
// Verifica se foi passado um ID para exclusão via GET.
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET ['delete_id'];
    // Cria a query SQL para deletar o produto com o ID correspondente.
    $sql = "DELETE FROM produtos WHERE id='$delete_id'";
    // Executaa query e define a mensagem de sucesso ou erro.
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Produto excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir produto: " . $conn->error;
    }
}

// Consulta SQL para listar todos os produtos, incluindo o nome do fornecedor.
$produtos = $conn->query("
    SELECT p.id, p.nome, p.descricao, p.preco, p.imagem,
        f.nome AS fornecedor_nome
    FROM produtos p
    JOIN fornecedores f ON p.fornecedor_id = f.id
");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de produto</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Link para o arquivo de estilização CSS -->
</head>
<body>
    <div class="container">
        <h2>Listagem de produtos</h2>

        <!-- Exibe a mensagem de feedback (sucesso ou erro) após uma ação -->
        <?php
        if (isset($mensagem)) {
            echo "<p class='message " . ($conn->error ? "error" : "sucess")  .  "'>$mensagem</p?";
        }
        ?>

        <!-- Tabela de exibição dos produtos cadastrados  -->
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Fornecedor</th>
                <th>Imagem</th>
                <th>Ações</th>
            <tr>
       <!-- Loop para exibir cada produto retonado da consulta  -->
      <?php while ($row = $produtos->fetch_assoc()): ?>
        <tr>
                <th><?php echo $row['id'];?></th>
                <th><?php echo $row['nome'];?></th>
                <th><?php echo $row['descricao'];?></th>
                <th><?php echo $row['preco'];?></th>
                <th><?php echo $row['fornecedor_nome'];?></th>
                
            <!-- Links para editar ou excluir o produto  -->
            <td>
                <?php if ($row['imagem']): ?>
                    <img src="<?php echo $row['imagem']; ?>" alt="Imagem do produto" style="max-width: 100px;">
                <?php else: ?>
                    Sem Imagem
                <?php endif; ?>
                </td>

               <!-- Botão para voltar á página principal  --> 
               <td> 
                <a href="cadastro_produto.php?edit_id=<?php echo $row['id']; ?>">Editar</a>
                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
                </tr>
                <?php endwhile; ?>
                </table>
                
                <a href="index.php" class="black-buttom">Voltar</a>
                </div>    

                
</body>
</html>