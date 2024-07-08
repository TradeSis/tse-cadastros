<?php

//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "usuario";
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
$usuario = array();

$sql = "SELECT usuario.*, cliente.nomeCliente FROM usuario
        LEFT JOIN cliente on  cliente.idCliente = usuario.idCliente";
$where = " WHERE ";
if (isset($jsonEntrada["idUsuario"])) {
  $sql = $sql . $where . " usuario.idUsuario = " . $jsonEntrada["idUsuario"];
  $where = " AND ";
} 
if (isset($jsonEntrada["idLogin"])) {
  $sql = $sql . $where . " usuario.idLogin = " . $jsonEntrada["idLogin"];
  $where = " AND ";
}

//LOG
if(isset($LOG_NIVEL)) {
  if ($LOG_NIVEL>=3) {
      fwrite($arquivo,$identificacao."-SQL->".$sql."\n");
  }
}
//LOG

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($usuario, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idUsuario"]) && $rows==1) {
  $usuario = $usuario[0];
}

if (isset($jsonEntrada["idLogin"]) && $rows==1) {
  $usuario = $usuario[0];
}


$jsonSaida = $usuario;
//echo "-SAIDA->".json_encode($jsonSaida)."\n";


//LOG
if(isset($LOG_NIVEL)) {
  if ($LOG_NIVEL>=2) {
      fwrite($arquivo,$identificacao."-SAIDA->".json_encode($jsonSaida)."\n\n");
  }
}
//LOG
?>