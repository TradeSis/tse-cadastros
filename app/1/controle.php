<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo == "GET") {

  switch ($funcao) {

    case "marcas":
      include 'marcas.php';
      break;

    case "marcas_slug":
      include 'marcas_slug.php';
      break;

    case "servicos":
      include 'servicos.php';
      break;

    case "servicos_slug":
      include 'servicos_slug.php';
      break;

    case "servicos_card":
      include 'servicos_card.php';
      break;

    case "produtos":
      include 'produtos.php';
      break;

    case "produtos_card":
      include 'produtos_card.php';
      break;

    case "produtos_listaSemCatalogo":
      include 'produtos_listaSemCatalogo.php';
      break;

    case "usuario":
      include 'usuario.php';
      break;

    case "clientes":
      include 'clientes.php';
      break;

    case "atendente":
      include 'atendente.php';
      break;

    case "pessoas":
      include 'pessoas.php';
      break;

    case "cidades":
      include 'cidades.php';
      break;
    
    case "cnpj":
      include 'cnpj.php';
      break;

    case "cep":
      include 'cep.php';
      break;

    case "cnpj_verifica":
      include 'cnpj_verifica.php';
      break;

    case "eanProduto_verifica":
      include 'eanProduto_verifica.php';
      break;  


    case "pessoas_processar":
      include 'pessoas_processar.php';
      break;

    case "estab":
      include 'estab.php';
      break;

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "PUT") {
  switch ($funcao) {

    case "marcas":
      include 'marcas_inserir.php';
      break;

    case "produtos":
      include 'produtos_inserir.php';
      break;

    case "servicos":
      include 'servicos_inserir.php';
      break;

    case "usuario":
      include 'usuario_inserir.php';
      break;

    case "clientes":
      include 'clientes_inserir.php';
      break;

    case "pessoas":
      include 'pessoas_inserir.php';
      break;

    case "grupoproduto":
      include 'grupoproduto_inserir.php';
      break;

    case "estab":
      include 'estab_inserir.php';
      break;
      
    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "POST") {

  switch ($funcao) {

    case "marcas":
      include 'marcas_alterar.php';
      break;

    case "produtos":
      include 'produtos_alterar.php';
      break;

    case "servicos":
      include 'servicos_alterar.php';
      break;

    case "usuario":
      include 'usuario_alterar.php';
      break;

    case "clientes":
      include 'clientes_alterar.php';
      break;

    case "pessoas":
      include 'pessoas_alterar.php';
      break;

    case "estab":
      include 'estab_alterar.php';
      break;

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "DELETE") {
  switch ($funcao) {

    case "marcas":
      include 'marcas_excluir.php';
      break;

    case "produtos":
      include 'produtos_excluir.php';
      break;

    case "servicos":
      include 'servicos_excluir.php';
      break;

    case "usuario":
      include 'usuario_excluir.php';
      break;

    case "clientes":
      include 'clientes_excluir.php';
      break;

    case "pessoas":
      include 'pessoas_excluir.php';
      break;

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}
