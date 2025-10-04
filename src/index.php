<?php
session_start();
include("conexao.php");

// --- LOGIN ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao']) && $_POST['acao'] === 'login') {
    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

    $query = "SELECT * FROM usuarios WHERE usuario = $1 AND senha = $2 LIMIT 1";
    $result = pg_query_params($conn, $query, [$usuario, $senha]);

    if ($result && pg_num_rows($result) > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: home.php");
        exit;
    } else {
        $erroLogin = "Usuário ou senha inválidos!";
    }
}

// --- CADASTRO ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao']) && $_POST['acao'] === 'cadastro') {
    $novoUsuario = $_POST['novo_usuario'];
    $novaSenha   = $_POST['nova_senha'];

    // Verifica se já existe
    $check = pg_query_params($conn, "SELECT 1 FROM usuarios WHERE usuario = $1", [$novoUsuario]);
    if (pg_num_rows($check) > 0) {
        $erroCadastro = "Esse usuário já existe!";
    } else {
        $insert = pg_query_params($conn, "INSERT INTO usuarios (usuario, senha) VALUES ($1, $2)", [$novoUsuario, $novaSenha]);
        if ($insert) {
            $msgCadastro = "Usuário cadastrado com sucesso!";
        } else {
            $erroCadastro = "Erro ao cadastrar usuário!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login / Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 320px;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        input {
            width: 100%;
            padding: 10px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #7d00fe;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover { background: #5b00bb; }
        .msg { margin: 10px 0; color: green; text-align: center; }
        .erro { margin: 10px 0; color: red; text-align: center; }
        .tab {
            text-align: center;
            margin-bottom: 20px;
        }
        .tab a {
            color: #7d00fe;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .tab a.active {
            border-bottom: 2px solid #7d00fe;
        }
    </style>
    <script>
        function trocarFormulario(tipo) {
            document.getElementById('formLogin').style.display = (tipo === 'login') ? 'block' : 'none';
            document.getElementById('formCadastro').style.display = (tipo === 'cadastro') ? 'block' : 'none';
            document.getElementById('tabLogin').classList.toggle('active', tipo === 'login');
            document.getElementById('tabCadastro').classList.toggle('active', tipo === 'cadastro');
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="tab">
            <a id="tabLogin" href="#" class="active" onclick="trocarFormulario('login')">Login</a>
            <a id="tabCadastro" href="#" onclick="trocarFormulario('cadastro')">Cadastro</a>
        </div>

        <!-- Formulário de Login -->
        <form id="formLogin" method="POST" style="display:block;">
            <h2>Entrar</h2>
            <?php if (!empty($erroLogin)) echo "<p class='erro'>$erroLogin</p>"; ?>
            <input type="hidden" name="acao" value="login">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>

        <!-- Formulário de Cadastro -->
        <form id="formCadastro" method="POST" style="display:none;">
            <h2>Cadastrar</h2>
            <?php
            if (!empty($erroCadastro)) echo "<p class='erro'>$erroCadastro</p>";
            if (!empty($msgCadastro)) echo "<p class='msg'>$msgCadastro</p>";
            ?>
            <input type="hidden" name="acao" value="cadastro">
            <input type="text" name="novo_usuario" placeholder="Novo usuário" required>
            <input type="password" name="nova_senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
