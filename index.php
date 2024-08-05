<?php
include_once __DIR__ . "/../config.php";
include_once "header.php";

if (
    !isset($_SESSION['nomeAplicativo']) || 
    $_SESSION['nomeAplicativo'] !== 'Cadastros' || 
    !isset($_SESSION['nivelMenu']) || 
    $_SESSION['nivelMenu'] === null
) {
    $_SESSION['nomeAplicativo'] = 'Cadastros';
    include_once ROOT . "/sistema/database/loginAplicativo.php";

    $nivelMenuLogin = buscaLoginAplicativo($_SESSION['idLogin'], $_SESSION['nomeAplicativo']);
    $_SESSION['nivelMenu'] = $nivelMenuLogin['nivelMenu'];
}

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <title>Cadastros</title>

</head>

<body>
    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>

    <div class="d-flex">

        <?php include_once  ROOT . "/sistema/painel.php"; ?>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0 ts-bgAplicativos">
                    <ul class="nav a" id="myTabs">


                        <?php
                        $tab = '';

                        if (isset($_GET['tab'])) {
                            $tab = $_GET['tab'];
                        }
                        ?>
                        <?php if ($_SESSION['nivelMenu'] >= 2) {
                            if ($tab == '') {
                                $tab = 'clientes';
                            } ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link 
                                <?php if ($tab == "clientes") {echo " active ";} ?>" 
                                href="?tab=clientes" role="tab">Clientes</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "produtos") {echo " active ";} ?>"
                                href="?tab=produtos" role="tab">Produtos</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "marcas") {echo " active ";} ?>" 
                                href="?tab=marcas" role="tab">Marcas</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "servicos") {echo " active ";} ?>" 
                                href="?tab=servicos" role="tab">Serviços</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "pessoas") {echo " active ";} ?>" 
                                href="?tab=pessoas" role="tab">Pessoas</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "grupoproduto") {echo " active ";} ?>" 
                                href="?tab=grupoproduto" role="tab">Grupo Produto</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "estab") {echo " active ";} ?>" 
                                href="?tab=estab" role="tab">Estabelecimentos</a>
                            </li>
                        <?php }
                        if ($_SESSION['nivelMenu'] >= 4) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "configuracao") {echo " active ";} ?>" 
                                href="?tab=configuracao" role="tab" data-toggle="tooltip" data-placement="top" title="Configurações"><i class="bi bi-gear"></i> Configurações</a>
                            </li>
                        <?php }?>
                    </ul>

                </div>
                <!--Essa coluna só vai aparecer em dispositivo mobile-->
                <div class="col-7 col-md-9 d-md-block d-lg-none ts-bgAplicativos">
                    <!--atraves do GET testa o valor para selecionar um option no select-->
                    <?php if (isset($_GET['tab'])) {
                        $getTab = $_GET['tab'];
                    } else {
                        $getTab = '';
                    } ?>
                    <select class="form-select mt-2 ts-selectSubMenuAplicativos" id="subtabCadastros">

                        <?php if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/?tab=clientes" 
                        <?php if ($getTab == "clientes") {echo " selected ";} ?>>Clientes</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/?tab=produtos" 
                        <?php if ($getTab == "produtos") {echo " selected ";} ?>>Produtos</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/?tab=marcas" 
                        <?php if ($getTab == "marcas") {echo " selected ";} ?>>Marcas</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/?tab=servicos" 
                        <?php if ($getTab == "servicos") {echo " selected ";} ?>>Serviços</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/?tab=pessoas" 
                        <?php if ($getTab == "pessoas") {echo " selected ";} ?>>Pessoas</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/admin/?tab=grupoproduto" 
                        <?php if ($getTab == "grupoproduto") {echo " selected ";} ?>>Grupo Produto</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 2) { ?>
                        <option value="<?php echo URLROOT ?>/admin/?tab=estab" 
                        <?php if ($getTab == "estab") {echo " selected ";} ?>>Estabelecimentos</option>
                        <?php }

                        if ($_SESSION['nivelMenu'] >= 4) { ?>
                        <option value="<?php echo URLROOT ?>/cadastros/?tab=configuracao" 
                        <?php if ($getTab == "configuracao") {echo " selected ";} ?>>Configurações</option>
                        <?php } ?>
                    </select>
                </div>

                <?php include_once  ROOT . "/sistema/novoperfil.php"; ?>

            </div>



            <?php
            $src = "";

            if ($tab == "clientes") {
                $src = "cadastros/clientes.php";
            }
            if ($tab == "produtos") {
                $src = "cadastros/produtos.php";
            }
            if ($tab == "marcas") {
                $src = "cadastros/marcas.php";
            }
            if ($tab == "servicos") {
                $src = "cadastros/servicos.php";
            }
            if ($tab == "pessoas") {
                $src = "cadastros/pessoas.php";
            }
            if ($tab == "grupoproduto") {
                $src = "geral/grupoproduto.php";
            }
            if ($tab == "estab") {
                $src = "cadastros/estab.php";
            }
            if ($tab == "configuracao") {
                $src = "configuracao/";
                if (isset($_GET['stab'])) {
                    $src = $src . "?stab=" . $_GET['stab'];
                }
            }

            // src direcionado para Admin
            if($src == "geral/grupoproduto.php"){ ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe" src="<?php echo URLROOT ?>/admin/<?php echo $src ?>"></iframe>
                </div>
            
            <?php } else if ($src !== "") {
                //echo URLROOT ."/cadastros/". $src;
            ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe" src="<?php echo URLROOT ?>/cadastros/<?php echo $src ?>"></iframe>
                </div>
            <?php
            }

            ?>
        </div><!-- div container -->
    </div><!-- div class="d-flex" -->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script src="<?php echo URLROOT ?>/sistema/js/mobileSelectTabs.js"></script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>