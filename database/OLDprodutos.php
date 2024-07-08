<?php
include_once __DIR__ . "/../conexao.php";


function buscarProdutos($idProduto = null, $idMarca = null)
{

	$produtos = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idProduto' => $idProduto,
		'idMarca' => $idMarca,
		'idEmpresa' => $idEmpresa
	);

	$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'GET');
	return $produtos;
}

function buscaCardProdutos($idProduto = null)
{

	$produtos = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}
	
	$apiEntrada = array(
		'idProduto' => $idProduto,
		'idEmpresa' => $idEmpresa

	);

	$produtos = chamaAPI(null, '/cadastros/produtos_card', json_encode($apiEntrada), 'GET');
	return $produtos;
}

function buscaListaProdutosSemCatalogo($idProduto = null)
{

	$produtos = array();

	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
		$idEmpresa = $_SESSION['idEmpresa'];
	}

	$apiEntrada = array(
		'idProduto' => $idProduto,
		'idEmpresa' => $idEmpresa
	);

	$produtos = chamaAPI(null, '/cadastros/produtos_listaSemCatalogo', json_encode($apiEntrada), 'GET');
	return $produtos;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$imgProduto = $_FILES['imgProdutoInserir'];

		if ($imgProduto !== null) {
			preg_match("/\.(png|jpg|jpeg|txt|xlsx|pdf|csv|doc|docx|zip){1}$/i", $imgProduto["name"], $ext);

			if ($ext == true) {
				$pasta = ROOT . "/img/";

				$novoNomeAnexo = $_POST['refProduto'] . "_" . $imgProduto["name"];
				$path = 'http://' . $_SERVER["HTTP_HOST"] . '/img/' . $novoNomeAnexo;
				move_uploaded_file($imgProduto['tmp_name'], $pasta . $novoNomeAnexo);


			} else {
				$novoNomeAnexo = " ";
			}

		} 
		$varmsg = strip_tags($_POST['descricaoProduto']);

		$apiEntrada = array(
			'idPessoaEmitente' => $_POST['idPessoaEmitente'], 
			'refProduto' => $_POST['refProduto'], 
			'nomeProduto' => $_POST['nomeProduto'],
            'valorCompra' => $_POST['valorCompra'],
			'precoProduto' => $_POST['precoProduto'],
            'codigoNcm' => $_POST['codigoNcm'],
            'codigoCest' => $_POST['codigoCest'],
			'imgProduto' => $path,
			'idMarca' => $_POST['idMarca'],
			'ativoProduto' => $_POST['ativoProduto'],
			'propagandaProduto' => $_POST['propagandaProduto'],
			'descricaoProduto' => $varmsg,
			'idEmpresa' => $_SESSION['idEmpresa']

		);

		

		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'PUT');
		return $produtos;
	}

	$operacao = $_GET['operacao'];

	if ($operacao == "alterar") {

		$imgProduto = $_FILES['imgProdutoAlterar'];

		if ($imgProduto !== null) {
			preg_match("/\.(png|jpg|jpeg|txt|xlsx|pdf|csv|doc|docx|zip){1}$/i", $imgProduto["name"], $ext);

			if ($ext == true) {
				$pasta = ROOT . "/img/";

				$novoNomeAnexo = $_POST['refProduto'] . "_" . $imgProduto["name"];
				$path = 'http://' . $_SERVER["HTTP_HOST"] . '/img/' . $novoNomeAnexo;
				move_uploaded_file($imgProduto['tmp_name'], $pasta . $novoNomeAnexo);


			} else {
				$novoNomeAnexo = " ";
			}

		} 
		$varmsg = strip_tags($_POST['descricaoProduto']);
	

		$apiEntrada = array(
			'idProduto' => $_POST['idProduto'],
			'idPessoaEmitente' => $_POST['idPessoaEmitente'], 
			'refProduto' => $_POST['refProduto'], 
			'nomeProduto' => $_POST['nomeProduto'],
            'valorCompra' => $_POST['valorCompra'],
			'precoProduto' => $_POST['precoProduto'],
            'codigoNcm' => $_POST['codigoNcm'],
            'codigoCest' => $_POST['codigoCest'],
			'imgProduto' => $path,
			'idMarca' => $_POST['idMarca'],
			'ativoProduto' => $_POST['ativoProduto'],
			'propagandaProduto' => $_POST['propagandaProduto'],
			'descricaoProduto' => $varmsg,
			'idEmpresa' => $_SESSION['idEmpresa']

		);

		
		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'POST');
		return $produtos;
	}




	if ($operacao == "excluir") {

		$apiEntrada = array(
			'idProduto' => $_POST['idProduto'],
			'idEmpresa' => $_SESSION['idEmpresa']
		);
		if (!empty($_POST['imgProduto'])) {
			$pasta = ROOT . "/img/";
			$imagem = $pasta . $_POST['imgProduto'];

			if (file_exists($imagem)) {
				unlink($imagem);
			}
		}

		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'DELETE');
	}

	if ($operacao == "buscar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idProduto' => $_POST['idProduto']
		);
		$produto = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'GET');

		echo json_encode($produto);
		return $produto;
	}

	header('Location: ../cadastros/produtos.php');
}
