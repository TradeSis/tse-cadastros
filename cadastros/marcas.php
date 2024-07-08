<?php
// Lucas 06102023 padrao novo
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/marcas.php');

$marcas = buscaMarcas();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link rel="stylesheet" href="../css/emoji.css">
</head>


<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row align-items-center"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3 text-start">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Marcas</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="marcas_inserir.php" role="button" class="btn btn-success"><i class="bi bi-plus-square"></i>&nbsp Novo</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th style="width:10%">Ativa</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th style="width:10%">Especializada</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($marcas as $marca) {
                ?>
                    <tr>
                        <td class="ativoEmoji_<?php echo $marca['ativoMarca'] ?>">
                            <p><i class="emojiAtivo bi bi-emoji-smile-fill"></i><i class="emojiNaoAtivo bi bi-emoji-frown-fill"></i></i></p>
                        </td>
                        <td><img src="<?php echo $marca['imgMarca'] ?>" width="60px" height="60px" alt=""></td>
                        <td><?php echo $marca['nomeMarca'] ?></td>
                        <td class="ativo_<?php echo $marca['lojasEspecializadas'] ?>">
                            <p></p>
                        </td>
                        <td>
                            <a class="btn btn-info btn-sm" href="<?php echo URLROOT ?>/marcas/<?php echo $marca['slug'] ?>" target="_blank" role="button"><i class="bi bi-eye"></i></a>
                            <a class="btn btn-warning btn-sm" href="marcas_alterar.php?idMarca=<?php echo $marca['idMarca'] ?>" role="button"><i class="bi bi-pencil-square"></i></a>
                            <a class="btn btn-danger btn-sm" href="marcas_excluir.php?idMarca=<?php echo $marca['idMarca'] ?>" role="button"><i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>