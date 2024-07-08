<?php
//Lucas 17102023 novo padrao
include_once(__DIR__ . '/../header.php');
?>
<!doctype html>
<html lang="pt-BR">

<head>

  <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

  <div class="container-fluid">
    <div class="row pt-2">
      <div class="col-md-2 mb-3">
        <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
          <?php
          $stab = 'usuario';
          if (isset($_GET['stab'])) {
            $stab = $_GET['stab'];
          }
          //echo "<HR>stab=" . $stab;
          ?>
          <li class="nav-item ">
            <a class="nav-link ts-tabConfig <?php if ($stab == "usuario") {
                                              echo " active ";
                                            } ?>" href="?tab=configuracao&stab=usuario" role="tab">Usuários</a>
          </li>



        </ul>
      </div>
      <div class="col-md-10">
        <?php
        $ssrc = "";

        if ($stab == "usuario") {
          $ssrc = "usuario.php";
        }
        if ($stab == "clientes") {
          $ssrc = "clientes.php";
        }


        if ($ssrc !== "") {
          //echo $ssrc;
          include($ssrc);
        }

        ?>

      </div>
    </div>

  </div>

  <!-- LOCAL PARA COLOCAR OS JS -->

  <?php include_once ROOT . "/vendor/footer_js.php"; ?>

  <!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>