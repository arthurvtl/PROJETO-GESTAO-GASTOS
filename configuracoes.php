<?php
    // Inclui o arquivo de configuração
    require_once './config.php';
    // Inclui o cabeçalho da página
    require_once './partials/header.php';

?>

<section class="loginSection">
    <div class="loginArea">
        <!-- Formulário para atualizar as configurações do usuário -->
        <form method="POST" action="<?=$base?>/update_user_action.php">
            <h1>Configurações</h1>
            <!-- Exibe mensagens de aviso, se houver -->
            <p class="warning">
                <?php if($_SESSION['warning']){
                    echo $_SESSION['warning'];
                    $_SESSION['warning'] = '';
                }
                ?>
            </p>

            <!-- Campo oculto para armazenar o ID do usuário -->
            <input type="hidden" value="<?=$_SESSION['login']['id']?>" name="id" />
            
            <!-- Campos para nome, email e data de nascimento -->
            <div class="label-float-login">
                <input type="text" value="<?=$_SESSION['login']['nome']?>" autofocus name="nome" required placeholder=" "/>
                <label>Nome</label>
            </div>

            <div class="label-float-login">
                <input type="email" value="<?=$_SESSION['login']['email']?>" name="email" required placeholder=" "/>
                <label>Email</label>
            </div>

            <div class="label-float-login">
                <input id="confirm_nascimento" value="<?=$_SESSION['login']['nascimento']?>" type="text" name="nascimento" required placeholder=" "/>
                <label>Data de nascimento</label>
            </div>

            <hr>

            <!-- Campos para nova senha e confirmação de nova senha -->
            <div class="label-float-login">
                <input type="password" name="senha" placeholder=" "/>
                <label>Nova senha</label>
            </div>

            <div class="label-float-login">
                <input type="password" name="confirmar_senha" placeholder=" "/>
                <label>confirmar nova senha</label>
            </div>

            <!-- Botão para atualizar as configurações -->
            <button type="submit" class="buttonLogin">Atualizar</button>
        </form>
        
        <!-- Botão para deletar a conta do usuário -->
        <button type="submit" class="deleteButton">Deletar conta</button>

        <!-- Modal para confirmar a exclusão da conta -->
        <div id="ModalAreaDelete" class="ModalAreaDelete">
            <div class="ModalBackDelete"></div>
            <form class="ModalFrontDelete" action="<?=$base?>/delete_user_action.php" method="POST" >
                <h2>Digite sua senha para confirmar</h2>
                <div class="label-float-login" style="width: 80%;">
                    <input required style="color: var(--Dark);" type="password" name="senhaDelete" placeholder=" "/>
                    <label>Senha</label>
                </div>
                <!-- Botões para confirmar ou cancelar a exclusão -->
                <div class="buttonsModalDelete">
                    <button type="button" class="cancelDelete btn btn-dark mr-2">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Script para criar a máscara no campo de data de nascimento -->
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById("confirm_nascimento"),
        {mask:'00/00/0000'}
    );

    // Event listeners para abrir e fechar o modal de exclusão da conta
    let openModalDelete = document.querySelector(".deleteButton");
    let buttonCancelDelete = document.querySelector(".cancelDelete")
    let backDelete = document.querySelector(".ModalBackDelete");

    openModalDelete.addEventListener("click", ()=>{
        document.getElementById("ModalAreaDelete").classList.toggle("show");
    });
    buttonCancelDelete.addEventListener("click", ()=>{
        document.getElementById("ModalAreaDelete").classList.toggle("show");
    });
    backDelete.addEventListener("click", ()=>{
        document.getElementById("ModalAreaDelete").classList.toggle("show");
    });

    // Define o título da página
    document.title = 'Yenom - configurações';

</script>

<?php 
    // Inclui o rodapé da página
    require_once './partials/footer.php'; 
?>
