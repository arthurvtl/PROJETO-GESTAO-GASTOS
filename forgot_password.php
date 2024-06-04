<?php
    // Inclui o arquivo de configuração e o cabeçalho específico para a página de login
    require_once './config.php';
    require_once './partials/headerLogin.php';
?>

<section class="loginSection">
    <div class="loginArea">
        <!-- Formulário para trocar a senha, enviando os dados via método POST para refresh_password_action.php -->
        <form method="POST" action="./refresh_password_action.php">
            <!-- Título da página -->
            <h1>Trocar senha</h1>
            <!-- Exibição de mensagem de aviso, se houver -->
            <p class="warning">
                <?php 
                    if($_SESSION['warning']){
                        echo $_SESSION['warning'];
                        $_SESSION['warning'] = '';
                    }
                ?>
            </p>
            
            <!-- Campo de entrada para o nome -->
            <div class="label-float-login">
                <input type="text" autofocus name="nome" required placeholder=" "/>
                <label>Nome</label>
            </div>

            <!-- Campo de entrada para o email -->
            <div class="label-float-login">
                <input type="email" name="email" required placeholder=" "/>
                <label>Email</label>
            </div>

            <!-- Campo de entrada para a data de nascimento, com máscara -->
            <div class="label-float-login">
                <input id="confirm_nascimento" type="text" name="nascimento" required placeholder=" "/>
                <label>Data de nascimento</label>
            </div>

            <!-- Linha divisória -->

            <hr>

            <!-- Campo de entrada para a nova senha -->
            <div class="label-float-login">
                <input type="password" name="senha" required placeholder=" "/>
                <label>Nova senha</label>
            </div>

            <!-- Campo de entrada para confirmar a nova senha -->
            <div class="label-float-login">
                <input type="password" name="confirmar_senha" required placeholder=" "/>
                <label>Confirmar nova senha</label>
            </div>

            <!-- Botão para enviar o formulário de atualização -->
            <button type="submit" class="buttonLogin">Atualizar</button>

            <!-- Link para voltar à página de login -->
            <p class="signup">Lembrou da senha? <a href="<?=$base?>/login.php">Entrar</a></p>
        </form>
    </div>
</section>

<!-- Script para configurar a máscara para o campo de data de nascimento -->
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById("confirm_nascimento"),
        {mask:'00/00/0000'}
    );

    // Define o título da página
    document.title = "Yenom - Recuperar senha";
</script>

<?php 
    // Inclui o rodapé da página
    require_once './partials/footer.php'; 
?>
