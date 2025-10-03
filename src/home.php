<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h2>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h2>
    <p>Essa é a página inicial do sistema.</p>
    <a href="logout.php">Sair</a>
</body>
</html>
