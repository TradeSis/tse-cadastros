<?php

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."pessoas";
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=1) {
            $arquivo = fopen(defineCaminhoLog()."cadastros_".date("dmY").".log","a");
        }
    }
    
}
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL==1) {
        fwrite($arquivo,$identificacao."\n");
    }
    if ($LOG_NIVEL>=2) {
        fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");
    }
}
//LOG

$pessoas = array();


  $progr = new chamaprogress();
  
  // PASSANDO idEmpresa PARA PROGRESS
  if (isset($jsonEntrada['idEmpresa'])) {
      $progr->setempresa($jsonEntrada['idEmpresa']);
  }
  

  $retorno = $progr->executarprogress("cadastros/app/1/pessoas",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");

  $pessoas = json_decode($retorno,true);
  if (isset($pessoas["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $pessoas = $pessoas["conteudoSaida"][0];
  } else {
    
     if (!isset($pessoas["pessoas"][1]) && ($jsonEntrada['idPessoa'] != null)) {  // Verifica se tem mais de 1 registro
      $pessoas = $pessoas["pessoas"][0]; // Retorno sem array
    } else {
      $pessoas = $pessoas["pessoas"];  
    }

  }


$jsonSaida = $pessoas;


//LOG
if (isset($LOG_NIVEL)) {
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
