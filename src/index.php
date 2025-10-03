<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

    // Exemplo bem simples
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: home.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <form method="POST">
        <label>Usuário:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Senha:</label>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
