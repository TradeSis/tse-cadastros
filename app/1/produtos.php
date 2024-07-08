<?php
//$BANCO = "MYSQL";
$BANCO = "PROGRESS";

if ($BANCO == "MYSQL")
    $conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset ($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "produtos";
    if (isset ($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "cadastros_" . date("dmY") . ".log", "a");
        }
    }

}
if (isset ($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG

$produtos = array();

if ($BANCO == "MYSQL") {

    $sql = "SELECT * , '' AS dataAtualizacaoTributariaFormatada FROM produtos ";

    if (isset ($jsonEntrada["idProduto"])) {
        $sql = $sql . " where produtos.idProduto = " . $jsonEntrada["idProduto"];
        $where = " and ";
    }
    $where = " where ";
    if (isset ($jsonEntrada["buscaProduto"])) {
        $sql = $sql . $where . " produtos.nomeProduto like " . "'%" . $jsonEntrada["buscaProduto"] . "%'
    OR produtos.eanProduto like " . "'%" . $jsonEntrada["buscaProduto"] . "%' ";
        $where = " and ";
    }

    //LOG
    if (isset ($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    $rows = 0;
    $buscar = mysqli_query($conexao, $sql);
    while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
        $idGeralProduto = $row['idGeralProduto'];

        $sql2 = "SELECT geralprodutos.* FROM geralprodutos WHERE geralprodutos.idGeralProduto = $idGeralProduto";
        $buscar2 = mysqli_query($conexaogeral, $sql2);

        while ($row2 = mysqli_fetch_array($buscar2, MYSQLI_ASSOC)) {
            $mergedRow = array_merge($row, $row2);
            array_push($produtos, $mergedRow);

            $dataAtualizacaoTributariaFormatada = null;
            if (isset ($produtos[$rows]["dataAtualizacaoTributaria"])) {
                $dataAtualizacaoTributariaFormatada = date('d/m/Y H:i', strtotime($produtos[$rows]["dataAtualizacaoTributaria"]));
            }

            $produtos[$rows]["dataAtualizacaoTributariaFormatada"] = $dataAtualizacaoTributariaFormatada;

            $rows = $rows + 1;
        }
    }

    if (isset ($jsonEntrada["idProduto"]) && $rows == 1) {
        $produtos = $produtos[0];
    }
}

if ($BANCO == "PROGRESS") {

    $progr = new chamaprogress();

    // PASSANDO idEmpresa PARA PROGRESS
  
    if (isset($jsonEntrada['idEmpresa'])) {
        $progr->setempresa($jsonEntrada['idEmpresa']);
    }

    $retorno = $progr->executarprogress("cadastros/app/1/produtos", json_encode($jsonEntrada));
    fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
    $produtos = json_decode($retorno, true);
    if (isset ($produtos["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
        $produtos = $produtos["conteudoSaida"][0];
    } else {

        if (!isset ($produtos["produtos"][1]) && ((isset ($jsonEntrada["idProduto"])) && $jsonEntrada['idProduto'] != null)) {  // Verifica se tem mais de 1 registro
            $produtos = $produtos["produtos"][0]; // Retorno sem array
        } else {
            $produtos = $produtos["produtos"];
        }

    }

}

$jsonSaida = $produtos;


//LOG
if (isset ($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

fclose($arquivo);


?>

<?php
// Inicio


?>