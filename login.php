<?php
    // Inclui o arquivo de configuração, onde podem estar as configurações de conexão com o banco de dados ou constantes globais
    require_once './config.php';
    // Inclui o cabeçalho específico para a página de login, que pode conter a abertura do HTML, head, links de estilo, etc.
    require_once './partials/headerLogin.php';
?>

<section class="loginSection">
    <div class="loginArea">
        <!-- Formulário de login que envia os dados via método POST para login_action.php -->
        <form method="POST" action="./login_action.php">
            <h1>Entrar <i class='bx bxs-lock'></i></h1> <!-- Título da página de login com ícone de cadeado -->

            <!-- Exibição de mensagem de aviso, se houver. Utiliza a sessão para armazenar a mensagem. -->
            <p class="warning">
                <?php if($_SESSION['warning']){
                    echo $_SESSION['warning']; // Exibe a mensagem de aviso
                    $_SESSION['warning'] = ''; // Limpa a mensagem de aviso
                }
                ?>
            </p>
            
            <!-- Campo de entrada para o email com estilo flutuante -->
            <div class="label-float-login">
                <input type="email" autofocus name="email" required placeholder=" "/> <!-- Campo de email obrigatório -->
                <label>Email</label> <!-- Rótulo do campo de email -->
            </div>

            <!-- Campo de entrada para a senha com estilo flutuante -->
            <div class="label-float-login">
                <input type="password" name="senha" required placeholder=" "/> <!-- Campo de senha obrigatório -->
                <label>Senha</label> <!-- Rótulo do campo de senha -->
            </div>

            <!-- Link para a página de recuperação de senha -->
            <p class="forgotPsw"><a href="<?=$base?>/forgot_password.php"> Esqueceu sua senha?</a></p>

            <!-- Botão para enviar o formulário de login -->
            <button type="submit" class="buttonLogin">Entrar</button>

            <!-- Link para a página de cadastro -->
            <p class="signup">Não tem uma conta ainda? <a href="<?=$base?>/signup.php">Cadastre-se</a></p>
        </form>
    </div>
</section>

<!-- Script para definir o título da página -->
<script>document.title = "Yenom - Login";</script>

<!-- Inclui o rodapé da página -->
<?php require_once './partials/footer.php'; ?>
