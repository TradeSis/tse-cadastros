<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "produtos";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "cadastros_" . date("dmY") . ".log", "a");
    }
  }
}
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL == 1) {
    fwrite($arquivo, $identificacao . "\n");
  }
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
  }
}
//LOG

// JSONENTRADA deve sempre ter o idCliente
$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
  $idEmpresa = $jsonEntrada["idEmpresa"];
}

$conexao = conectaMysql($idEmpresa);
$conexaogeral = conectaMysql(null);

$produtos = array();

$sql = "SELECT * , '' AS dataAtualizacaoTributariaFormatada FROM produtos ";

if (isset($jsonEntrada["idProduto"])) {
  $sql = $sql . " where produtos.idProduto = " . $jsonEntrada["idProduto"];
  $where = " and ";
} 
$where = " where ";
if (isset($jsonEntrada["buscaProduto"])) {
  $sql = $sql . $where . " produtos.nomeProduto like " . "'%" . $jsonEntrada["buscaProduto"] . "%'
    OR produtos.eanProduto like " . "'%" . $jsonEntrada["buscaProduto"] . "%' " ;
  $where = " and ";
}

//LOG
if (isset($LOG_NIVEL)) {
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
          if(isset($produtos[$rows]["dataAtualizacaoTributaria"])){
            $dataAtualizacaoTributariaFormatada = date('d/m/Y H:i', strtotime($produtos[$rows]["dataAtualizacaoTributaria"]));
          }
      
        $produtos[$rows]["dataAtualizacaoTributariaFormatada"] = $dataAtualizacaoTributariaFormatada;
      
        $rows = $rows + 1;
    }
}

if (isset($jsonEntrada["idProduto"]) && $rows == 1) {
  $produtos = $produtos[0];
}
$jsonSaida = $produtos;

//echo "-SAIDA->".json_encode(jsonSaida)."\n";


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG
