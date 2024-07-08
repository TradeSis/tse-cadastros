<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "pessoas";
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
$conexaogeral = conectaMysql(null);
$pessoas = array();

$sql = "SELECT pessoas.* FROM pessoas";
if (isset($jsonEntrada["idPessoa"])) {
  $sql = $sql . " where pessoas.idPessoa = " . $jsonEntrada["idPessoa"];
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
    $cpfCnpj = $row['cpfCnpj'];

    $sql2 = "SELECT geralpessoas.* FROM geralpessoas WHERE geralpessoas.cpfCnpj = $cpfCnpj";
    $buscar2 = mysqli_query($conexaogeral, $sql2);

    while ($row2 = mysqli_fetch_array($buscar2, MYSQLI_ASSOC)) {
        $mergedRow = array_merge($row, $row2);
        array_push($pessoas, $mergedRow);
        $rows = $rows + 1;
    }
}

if (isset($jsonEntrada["idPessoa"]) && $rows == 1) {
  $pessoas = $pessoas[0];
}
$jsonSaida = $pessoas;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG
