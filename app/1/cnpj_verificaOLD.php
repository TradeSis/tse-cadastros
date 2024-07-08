<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "cnpj_verifica";
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

$conexao = conectaMysql(null);


    $cpfCnpj = $jsonEntrada["cpfCnpj"];
 
    $sql_consulta = "SELECT * FROM geralpessoas WHERE cpfCnpj = $cpfCnpj";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    $cpfCnpj = isset($row_consulta["cpfCnpj"]) && $row_consulta["cpfCnpj"] !== "" ? "'" . $row_consulta["cpfCnpj"] . "'" : "null";

    if($cpfCnpj == 'null'){
      $jsonSaida = 'LIBERADO';
    }else{
      $jsonSaida = 'CPF ou CNPJ já cadastrado!';
    }


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG
