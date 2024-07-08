<?php
// Lucas 06102023 padrao novo
include_once('../header.php');
include_once('../database/servicos.php');

$idServico = $_GET['idServico'];
$servico = buscaServicos($idServico);
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body>

    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Excluir Serviço</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="servicos.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/servicos.php?operacao=excluir" method="post" enctype="multipart/form-data">

            <div class="row mt-3">
                <div class="col-sm-12">
                    <input type="text" name="nomeServico" class="form-control ts-input" value="<?php echo $servico['nomeServico'] ?>" disabled>
                    <input type="hidden" class="form-control ts-input" name="idServico" value="<?php echo $servico['idServico'] ?>">
                    <input type="hidden" class="form-control ts-input" name="imgServico" value="<?php echo $servico['imgServico'] ?>">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" id="botao" class="btn btn-sm btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
            </div>
        </form>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>