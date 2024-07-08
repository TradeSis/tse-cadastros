<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "marcas";
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

$marcas = array();

$sql = "SELECT * FROM marcas ";
if (isset($jsonEntrada["idMarca"])) {
  $sql = $sql . " where marcas.idMarca = " . $jsonEntrada["idMarca"];
}
$where = " where ";
if (isset($jsonEntrada["estado"])) {
  $sql = $sql . $where . " marcas.estado = " .  "'" . $jsonEntrada["estado"] . "' and ativoMarca = 1";
  $where = " and ";
} elseif (isset($jsonEntrada["lojasEspecializadas"])) {
  $sql = $sql . $where . " marcas.ativoMarca = 1 and marcas.lojasEspecializadas = " . $jsonEntrada["lojasEspecializadas"];
  $where = " and ";
} elseif (isset($jsonEntrada["ativoMarca"])) { //parceiras
  $sql = $sql . $where . " marcas.ativoMarca = 1";
  $where = " and ";
}


//echo $sql;

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
  array_push($marcas, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idMarca"]) && $rows == 1) {
  $marcas = $marcas[0];
}
$jsonSaida = $marcas;

//echo "-SAIDA->".json_encode(jsonSaida)."\n";

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG