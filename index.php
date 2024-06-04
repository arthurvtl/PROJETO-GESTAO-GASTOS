<?php
    // Inclui o arquivo de configuração com as definições e a conexão com o banco de dados
    require_once './config.php';

    // Verifica se o usuário está logado, se não estiver, redireciona para a página de login
    if(!$_SESSION['login']){
        $_SESSION['warning'] = ''; // Define uma mensagem de aviso como vazia
        header('location: '.$base.'/login.php'); // Redireciona para a página de login
        exit; // Encerra a execução do script
    }

    // Inclui o arquivo de cabeçalho da parte visual da página
    require_once './partials/header.php';

    // Obtém o ID do item a partir da URL, se houver
    $id = filter_input(INPUT_GET, 'id');

    // Inicializa um array para armazenar os dados do item, se encontrado
    $dataID = [];

    // Se um ID foi fornecido, busca o item correspondente no banco de dados
    if($id){
        $sqlID = $pdo->prepare("SELECT * FROM item WHERE id = :id");
        $sqlID->bindValue(":id", $id);
        $sqlID->execute();
        $dataID = $sqlID->fetch(PDO::FETCH_ASSOC); // Armazena os dados do item em um array associativo
    }

    // Prepara uma consulta SQL para buscar todos os itens do usuário logado
    $sql = $pdo->prepare("SELECT * FROM item WHERE id_user = :id_user");
    $sql->bindValue(":id_user", $_SESSION['login']['id']);
    $sql->execute();
    $date = $sql->fetchAll(PDO::FETCH_ASSOC); // Armazena todos os itens em um array associativo

    // Prepara uma consulta SQL para buscar todos os itens do tipo 'Entrada' do usuário logado
    $sqlEntrada = $pdo->prepare("SELECT * FROM item WHERE tipo = :tipo AND id_user = :id_user");
    $sqlEntrada->bindValue(":tipo", 'Entrada');
    $sqlEntrada->bindValue(":id_user", $_SESSION['login']['id']);
    $sqlEntrada->execute();
    $dateEntrada = $sqlEntrada->fetchAll(PDO::FETCH_ASSOC); // Armazena os itens de 'Entrada' em um array associativo

    // Prepara uma consulta SQL para buscar todos os itens do tipo 'Saída' do usuário logado
    $sqlSDaida = $pdo->prepare("SELECT * FROM item WHERE tipo = :tipo AND id_user = :id_user");
    $sqlSDaida->bindValue(":tipo", 'Saída');
    $sqlSDaida->bindValue(":id_user", $_SESSION['login']['id']);
    $sqlSDaida->execute();
    $dateSaida = $sqlSDaida->fetchAll(PDO::FETCH_ASSOC); // Armazena os itens de 'Saída' em um array associativo

    // Inicializa as variáveis para calcular o total de 'Entrada', 'Saída' e o saldo total
    $entrada = 0.00;
    $saida = 0;
    $total = 0;

    // Calcula o total de 'Entrada' somando os valores de todos os itens de 'Entrada'
    for($d = 0; $d < count($dateEntrada); $d++){
        $entrada += str_replace(',', '',$dateEntrada[$d]['valor']); // Remove vírgulas e soma ao total
    }

    // Calcula o total de 'Saída' subtraindo os valores de todos os itens de 'Saída'
    for($s = 0; $s < count($dateSaida); $s++){
        $saida -= str_replace(',', '',$dateSaida[$s]['valor']); // Remove vírgulas e subtrai do total
    }
    // Calcula o saldo total (não é necessário um loop aqui, pode ser um ponto de melhoria)
    for($d = 0; $d < count($date); $d++){
        $total = $entrada + $saida; // Atualiza o saldo total
    }

    
?>

<!-- Início do conteúdo principal -->
<main class="main">
    <!-- Cabeçalho da área principal -->
    <div class="headerMain">
        <!-- Caixa de exibição do total de Entradas -->
        <div class="box1">
            <div class="headerBox">
                Entrada <i class='bx bx-up-arrow-circle bx-sm' style="color: var(--Green);"></i>
            </div>
            <!-- Exibe o valor total das Entradas formatado -->
            <p>R$ <?=number_format($entrada, 2, ',', '.')?></p>
        </div>
        <!-- Caixa de exibição do total de Saídas -->
        <div class="box1">
            <div class="headerBox">
                Saída <i class='bx bx-down-arrow-circle bx-sm'  style="color: var(--Red);"></i>
            </div>
            <!-- Exibe o valor total das Saídas formatado -->
            <p>R$ <?=number_format($saida, 2, ',', '.')?></p>
        </div>
        <!-- Caixa de exibição do saldo Total, com cor variando conforme o saldo ser positivo ou negativo -->
        <div class="box2" style="background: <?=$total >= 0 ? 'var(--Green)' : 'var(--Red)'?>;">
            <div class="headerBox">
                Total <i class='bx bx-money-withdraw bx-sm'></i>
            </div>
            <!-- Exibe o saldo Total formatado -->
            <p>R$ <?=number_format($total, 2, ',', '.')?></p>
        </div>
    </div>

    <!-- Área do corpo principal, onde os itens são listados -->
    <div class="bodyArea">
        <!-- Cabeçalho da lista de itens -->
        <div class="headerBody">
            <div class="headerTitle">Titulo</div>
            <div class="headerTitle">Categoria</div>
            <div class="headerTitle">Data</div>
            <div class="headerTitle">Valor</div>
            <div class="headerTitle">Editar/Excluir</div>
        </div>

        <!-- Loop PHP para listar cada item -->
        <?php for($d = 0; $d < count($date); $d++) : ?>
            <div class="ItemBody">
                <!-- Exibe o título do item -->
                <div class="bodyTitle"><?=$date[$d]['titulo']?></div>
                <!-- Exibe o tipo do item (Entrada ou Saída) -->
                <div class="bodyTitle"><?=$date[$d]['tipo']?></div>
                <!-- Exibe a data do item formatada -->
                <div class="bodyTitle"><?=date('d/m/Y', strtotime($date[$d]['data']))?></div>
                <!-- Exibe o valor do item formatado -->
                <div class="bodyTitle"><?=number_format(str_replace(',', '',$date[$d]['valor']), 2, ',', '.')?></div>
                <!-- Links para editar e excluir o item -->
                <div class="bodyTitle"><a href="<?=$base?>?id=<?=$date[$d]['id']?>"><i class=" fa-solid fa-pen-to-square"></i></a><a href="./delete_item_action.php?id=<?=$date[$d]['id']?>"><i class="fa-solid fa-trash"></i></a></div>
            </div>

            <hr>

        <?php endfor ?>
        
    </div>

    <!-- Modal para adicionar um novo item -->
    <div id="ModalArea" class="ModalArea">
        <!-- Botão para fechar o modal -->
        <div class="closeModal">x</div>
        <!-- Fundo escuro do modal -->
        <div class="ModalBack"></div>
        <!-- Formulário do modal para adicionar um novo item -->
        <form class="ModalFront" method="post" action="./add_item_action.php" >
            <!-- Campo para inserir o título do novo item -->
            <div class="label-float">
                <input type="text" autofocus name="titulo" required placeholder=" "/>
                <label>Titulo</label>
            </div>
            <!-- Seleção do tipo do novo item e campo para inserir a data -->
            <div class="rowInput">
                <div class="label-float-select">
                    <select name="tipo">
                        <option value="Entrada">Entrada</option>
                        <option value="Saída">Saída</option>
                    </select>
                </div>
                <div class="label-float">
                    <input id="date" type="text" name="data" required placeholder=" "/>
                    <label>Data</label>
                </div>
            </div>
            <!-- Campo para inserir o valor do novo item -->
            <div class="label-float">
                <input inputmode="numeric" class="<?=$dataID ? '' : 'number' ?>" value="0,00" name="valor" required placeholder=" "/>
                <label>Valor</label>
            </div>

            <!-- Botão para adicionar o novo item -->

            <button class="addButton" type="submit">Adicionar+</button>
        </form>
    </div>

    <!-- Modal para editar um item existente -->
    <div id="ModalAreaEdit" class="ModalAreaEdit" style="display: <?=count($dataID) > 0 ? 'flex' : 'none' ?>;">
        <!-- Link para fechar o modal de edição -->
        <a href="<?=$base?>"><div class="closeModalEdit">x</div></a>
        <!-- Fundo escuro do modal de edição -->
        <a class="modalBackArea" href="<?=$base?>"><div class="ModalBackEdit"></div></a>
        <!-- Formulário do modal para editar um item existente -->
        <form class="ModalFrontEdit" method="post" action="./edit_item_action.php" >
            <!-- Campo oculto para armazenar o ID do item a ser editado -->
            <input type="hidden" name="id" value="<?=$id?>" >
            <!-- Campo para inserir o novo título do item -->
            <div class="label-float">
                <input value="<?=$dataID['titulo']?>" type="text" autofocus name="novo_titulo" required placeholder=" "/>
                <label>Novo título</label>
            </div>


            <!-- Seleção do novo tipo do item e campo para inserir a nova data -->
            <div class="rowInput">
                <div class="label-float-select">
                    <select name="novo_tipo">
                        <option value="Entrada">Entrada</option>
                        <option value="Saída">Saída</option>
                    </select>
                </div>


                <div class="label-float">
                    <input value="<?=date('d/m/Y', strtotime($dataID['data']))?>" id="newDate" type="text" name="newData" required placeholder=" "/>
                    <label>Nova data</label>
                </div>
            </div>
            
            
            <!-- Campo para inserir o novo valor do item -->
            <div class="label-float">
                <input inputmode="numeric" class="<?=$dataID > 0 ? 'number' : '' ?>" value="<?=str_replace(',', '',$dataID['valor'])?>" name="newValor" required placeholder=" "/>
                <label>Novo valor</label>
            </div>

            <!-- Botão para salvar as alterações do item -->
            <button class="addButton" type="submit">Salvar <i class="fa-solid fa-floppy-disk"></i></button>
        </form>
    </div>
</main>



<script src="./simple-mask-money.js"></script> <!-- Inclui o script para máscara de dinheiro -->
<script src="https://unpkg.com/imask"></script> <!-- Inclui o script para máscara de input -->
<script>
    // Configura a máscara para o campo de data
    IMask(
        document.getElementById("date"),
        {mask:'00/00/0000'}
    );
    
    // Configura a máscara para o campo de valor numérico
    let input = SimpleMaskMoney.setMask('.number',{
        prefix: '',
        suffix: '',
        fixed: true,
        fractionDigits: 2,
        decimalSeparator: '.',
        thousandsSeparator: ',',
        emptyOrInvalid: () => {
        return this.SimpleMaskMoney.args.fixed
            ? `0${this.SimpleMaskMoney.args.decimalSeparator}00`
            : `_${this.SimpleMaskMoney.args.decimalSeparator}__`;
        }
    });

    // Seleciona os elementos do modal para adicionar um novo item
    let Modal = document.getElementById("ModalArea");
    let Back = document.querySelector(".ModalBack");
    let closeButton = document.querySelector(".closeModal")
    let openModal = document.querySelector(".openModal");

    // Adiciona evento de clique para fechar o modal
    Back.addEventListener("click", ()=>{
        Modal.style.display = 'none';
    });
    closeButton.addEventListener("click", ()=>{
        Modal.style.display = 'none';
    });
    // Adiciona evento de clique para abrir o modal
    openModal.addEventListener("click", ()=>{
        Modal.style.display = 'flex';
    });

</script>

<?php

    require_once './partials/footer.php';

?>