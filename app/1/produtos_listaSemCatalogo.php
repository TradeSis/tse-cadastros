<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "produtos_listaSemCatalogo";
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

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
  $idEmpresa = $jsonEntrada["idEmpresa"];
}

$conexao = conectaMysql($idEmpresa);
$produtos = array();

$sql = "SELECT produtos.*, marcas.* FROM produtos 
        LEFT JOIN marcas on marcas.idMarca = produtos.idMarca ";

if (isset($jsonEntrada["idProduto"])) {
  $sql = $sql . " where produtos.idProduto = " . $jsonEntrada["idProduto"];
  $where = " and ";
} else {
  $where = " where ";
  if (isset($jsonEntrada["idMarca"])) {
    $sql = $sql . $where . " produtos.idMarca = " . $jsonEntrada["idMarca"];
    $where = " and ";
  }
}
$sql = $sql . $where . " produtos.ativoProduto = 1 LIMIT 9";

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
  array_push($produtos, $row);
  $rows = $rows + 1;
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
