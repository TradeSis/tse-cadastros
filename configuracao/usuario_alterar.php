<?php
// Lucas 06102023 padrao novo
// Lucas 29032023 - alterado link do botão voltar, para redirecionar para o index.php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../header.php');
include_once('../database/usuario.php');
include_once('../database/clientes.php');

$idUsuario = $_GET['idUsuario'];
$usuario = buscaUsuarios($idUsuario);
$clientes = buscaClientes();
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
                <h2 class="ts-tituloPrincipal">Alterar Usuário</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/usuario.php?operacao=alterar" method="post">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label class="labelForm">Nome</label>
                        <input type="text" class="form-control" name="nomeUsuario" value="<?php echo $usuario['nomeUsuario'] ?>">
                        <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label class="labelForm">E-mail</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $usuario['email'] ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label class='control-label' for='inputNormal'>Nivel</label>
                        <select class="form-control" name="statusUsuario">
                            <option <?php if ($usuario['statusUsuario'] == "0") {
                                        echo "selected";
                                    } ?> value="0">Inativo</option>
                            <option <?php if ($usuario['statusUsuario'] == "1") {
                                        echo "selected";
                                    } ?> value="1">Ativo</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label class='control-label' for='inputNormal'>Cliente</label>
                        <select class="form-control" name="idCliente">
                            <option value="null">Interno</option>
                            <?php
                            foreach ($clientes as $cliente) {
                            ?>
                                <option <?php if ($cliente['idCliente'] == $usuario['idCliente']) {
                                            echo "selected";
                                        } ?> value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>