<?php

    // Inclui o arquivo de configuração
    require_once './config.php';

    // Inclui o cabeçalho da página de login
    require_once './partials/headerLogin.php';

?>

<section class="loginSection">
    <div class="loginArea">
        <!-- Formulário de cadastro que envia dados para 'signup_action.php' via método POST -->
        <form method="POST" action="./signup_action.php">
            <h1>Cadastrar <i class='bx bxs-lock'></i></h1>
            <!-- Exibe a mensagem de aviso armazenada na sessão, se houver -->
            <p class="warning"><?=$_SESSION['warning']?></p>

            <!-- Campo de entrada para o nome do usuário -->
            <div class="label-float-login">
                <input type="text" autofocus name="nome" required placeholder=" "/>
                <label>Nome</label>
            </div>

            <!-- Campo de entrada para o email do usuário -->
            <div class="label-float-login">
                <input type="email" autofocus name="email" required placeholder=" "/>
                <label>Email</label>
            </div>

            <!-- Campo de entrada para a data de nascimento do usuário -->
            <div class="label-float-login">
                <input type="text" id="nascimento" name="nascimento" required placeholder=" "/>
                <label>Data de nascimento</label>
            </div>

            <!-- Campo de entrada para a senha do usuário -->
            <div class="label-float-login">
                <input type="password" name="senha" required placeholder=" "/>
                <label>Senha</label>
            </div>

            <!-- Campo de entrada para confirmar a senha do usuário -->
            <div class="label-float-login">
                <input type="password" name="confirma_senha" required placeholder=" "/>
                <label>Confirmar senha</label>
            </div>            

            <!-- Botão para submeter o formulário de cadastro -->
            <button type="submit" class="buttonLogin">Cadastrar</button>

            <!-- Link para a página de login caso o usuário já tenha uma conta -->
            <p class="signup">Já tem uma conta? <a href="<?=$base?>/login.php">Entre</a></p>

        </form>
    </div>
</section>

<!-- Inclusão da biblioteca de máscaras de input IMask via CDN -->
<script src="https://unpkg.com/imask"></script>
<script>
    // Aplica a máscara de data no campo de nascimento
    IMask(
        document.getElementById("nascimento"),
        {mask:'00/00/0000'}
    );

    // Define o título da página
    document.title = "Yenom - Cadastro";
</script>

<!-- Inclui o rodapé da página -->
<?php require_once './partials/footer.php'; ?>
