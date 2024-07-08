<?php
// Lucas 06102023 padrao novo
// helio 01022023 criado option null para empresa
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../header.php');
include_once '../database/clientes.php';

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
                <h2 class="ts-tituloPrincipal">Cadastrar Usuário</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="../configuracao/?tab=configuracao&stab=usuario" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/usuario.php?operacao=inserir" method="post">
            <div class="row">
                <div class="col-sm-4">
                    <label class='form-label ts-label'>Nome do Usuário</label>
                    <input type="text" name="nomeUsuario" class="form-control ts-input" required autocomplete="off">
                </div>
                <div class="col-sm-5">
                    <label class='form-label ts-label'>E-mail</label>
                    <input type="email" name="email" class="form-control ts-input" required autocomplete="off">
                </div>
                <div class="col-sm-3">
                    <label class="form-label ts-label">Cliente</label>
                    <select class="form-select ts-input" name="idCliente">
                        <option value="null">Interno</option>
                        <?php
                        foreach ($clientes as $cliente) {
                        ?>
                            <option value="<?php echo $cliente['idCliente'] ?>"><?php echo $cliente['nomeCliente'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
            </div>
        </form>
    </div>



    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        function validaSenha(input) {
            if (input.value != document.getElementById('txtSenha').value) {
                input.setCustomValidity('Repita a senha corretamente');
            } else {
                input.setCustomValidity('');
            }
        }
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>