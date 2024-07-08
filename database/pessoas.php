<?php
// gabriel 060623 15:06

include_once __DIR__ . "/../conexao.php";

function buscarPessoa($idPessoa=null)
{

	$pessoas = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idPessoa' => $idPessoa,
		'idEmpresa' => $idEmpresa
	);
	$pessoas = chamaAPI(null, '/cadastros/pessoas', json_encode($apiEntrada), 'GET');
	return $pessoas;
}
function buscarCidades($idCidade=null)
{
	$cidades = array();
	
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	

	$apiEntrada = array(
		'idCidade' => $idCidade,
		'idEmpresa' => $idEmpresa
	);
	
	$cidades = chamaAPI(null, '/cadastros/cidades', json_encode($apiEntrada), 'GET');

	return $cidades;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'cpfCnpj' => $_POST['cpfCnpj']
		);

		$pessoas = chamaAPI(null, '/cadastros/pessoas', json_encode($apiEntrada), 'PUT');
		return $pessoas;

	}

	if ($operacao=="alterar") {
		$email = isset($_POST["email"])  && $_POST["email"] !== "" && $_POST["email"] !== "null" ? $_POST["email"]  : null;
		$telefone = isset($_POST["telefone"])  && $_POST["telefone"] !== "" && $_POST["telefone"] !== "null" ? $_POST["telefone"]  : null;
		$cnae = isset($_POST["cnae"])  && $_POST["cnae"] !== "" && $_POST["cnae"] !== "null" ? $_POST["cnae"]  : null;

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idPessoa' => $_POST['idPessoa'],
			'cpfCnpj' => $_POST['cpfCnpj'],
			'email' => $email,
			'telefone' => $telefone,
			'cnae' => $cnae,
			'caracTrib' => $_POST['caracTrib'],

		);
		$pessoas = chamaAPI(null, '/cadastros/pessoas', json_encode($apiEntrada), 'POST');
		return $pessoas;

	}
	
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idPessoa' => $_POST['idPessoa'],
			'idEmpresa' => $_SESSION['idEmpresa']

		);
		$pessoas = chamaAPI(null, '/cadastros/pessoas', json_encode($apiEntrada), 'DELETE');
		return $pessoas;

	}

	if ($operacao == "buscar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idPessoa' => $_POST['idPessoa']
		);
		$pessoas = chamaAPI(null, '/cadastros/pessoas', json_encode($apiEntrada), 'GET');

		echo json_encode($pessoas);
		return $pessoas;
	}


	/* if ($operacao == "buscaCNPJ") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'cpfCnpj' => $_POST['cpfCnpj']
		);
		$cnpj = chamaAPI(null, '/cadastros/cnpj', json_encode($apiEntrada), 'GET');

		echo json_encode($cnpj);
		return $cnpj;
	}
	if ($operacao == "buscaCEP") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'cep' => $_POST['cep']
		);
		$cep = chamaAPI(null, '/cadastros/cep', json_encode($apiEntrada), 'GET');

		echo json_encode($cep);
		return $cep;
	}
	if ($operacao == "verificaCNPJ") {
		$apiEntrada = array(
			'cpfCnpj' => $_POST['cpfCnpj']
		);
		$pessoas = chamaAPI(null, '/cadastros/cnpj_verifica', json_encode($apiEntrada), 'GET');

		echo json_encode($pessoas);
		return $pessoas;
	} */

	if ($operacao == "filtrar") {

		$buscaPessoa = $_POST["buscaPessoa"];

		if ($buscaPessoa == "") {
			$buscaPessoa = null;
		}

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idPessoa' => null,
			'cpfCnpj' => $buscaPessoa
		);

		$pessoas = chamaAPI(null, '/cadastros/pessoas', json_encode($apiEntrada), 'GET');

		echo json_encode($pessoas);
		return $pessoas;
	}

	if ($operacao=="processar") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'cpfCnpj' => $_POST['cpfCnpj']
		);
		$pessoas = chamaAPI(null, '/cadastros/pessoas_processar', json_encode($apiEntrada), 'GET');
		
		echo json_encode($pessoas);
		return $pessoas;

	}
}

?>

