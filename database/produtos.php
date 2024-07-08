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

		/* $imgProduto = $_FILES['imgProdutoInserir'];

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
		$varmsg = strip_tags($_POST['descricaoProduto']); */

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'eanProduto' => $_POST['eanProduto'], 
			'nomeProduto' => $_POST['nomeProduto'], 
			'valorCompra' => $_POST['valorCompra'],
            'precoProduto' => $_POST['precoProduto'],
			'codigoNcm' => $_POST['codigoNcm'],
            'codigoCest' => $_POST['codigoCest'],
            'imgProduto' => $_POST['imgProduto'],
			'idMarca' => $_POST['idMarca'],
			'ativoProduto' => $_POST['ativoProduto'],
			'propagandaProduto' => $_POST['propagandaProduto'],
			'descricaoProduto' => $_POST['descricaoProduto'],
			'idPessoaFornecedor' => $_POST['idPessoaFornecedor'],
			'refProduto' => $_POST['refProduto'],
			'dataAtualizacaoTributaria' => $_POST['dataAtualizacaoTributaria'],
			'codImendes' => $_POST['codImendes'],
			'codigoGrupo' => $_POST['codigoGrupo'],
			'substICMSempresa' => $_POST['substICMSempresa'],
			'substICMSFornecedor' => $_POST['substICMSFornecedor'],
			'prodZFM' => $_POST['prodZFM'],
		);

		

		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'PUT');
		return $produtos;
	}

	$operacao = $_GET['operacao'];

	if ($operacao == "alterar") {

		/* $imgProduto = $_FILES['imgProdutoAlterar'];

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
		$varmsg = strip_tags($_POST['descricaoProduto']); */
	

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idProduto' => $_POST['idProduto'],
			'idGeralProduto' => $_POST['idGeralProduto'],
			'nomeProduto' => $_POST['nomeProduto'], 
			'valorCompra' => $_POST['valorCompra'],
			'codigoNcm' => $_POST['codigoNcm'],
            'codigoCest' => $_POST['codigoCest'],
            'idPessoaFornecedor' => $_POST['idPessoaFornecedor'],
			'refProduto' => $_POST['refProduto'],
			'substICMSempresa' => $_POST['substICMSempresa'],
			'substICMSFornecedor' => $_POST['substICMSFornecedor'],
			'prodZFM' => $_POST['prodZFM'],
		);

		
		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'POST');
		return $produtos;
	}




	if ($operacao == "excluir") {

		$apiEntrada = array(
			'idProduto' => $_POST['idProduto'],
			'idEmpresa' => $_SESSION['idEmpresa']
		);
		/* if (!empty($_POST['imgProduto'])) {
			$pasta = ROOT . "/img/";
			$imagem = $pasta . $_POST['imgProduto'];

			if (file_exists($imagem)) {
				unlink($imagem);
			}
		} */

		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'DELETE');
	}

	if ($operacao == "atualizar") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idProduto' => $_POST['idProduto']
		);
		$produtos = chamaAPI(null, '/impostos/imendes/saneamento', json_encode($apiEntrada), 'POST');

		echo json_encode($produtos);
		return $produtos;
	}

	if ($operacao == "verificaEanProduto") {
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'eanProduto' => $_POST['eanProduto']
		);
		$produtos = chamaAPI(null, '/cadastros/eanProduto_verifica', json_encode($apiEntrada), 'GET');

		echo json_encode($produtos);
		return $produtos;
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

	
	if ($operacao == "filtrar") {

		$buscaProduto = isset($_POST["buscaProduto"])  && $_POST["buscaProduto"] !== "" && $_POST["buscaProduto"] !== "null" ? $_POST["buscaProduto"]  : null;
		$FiltroAssociados = isset($_POST["FiltroAssociados"])  && $_POST["FiltroAssociados"] !== "" && $_POST["FiltroAssociados"] !== "null" ? $_POST["FiltroAssociados"]  : null;

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idProduto' => null,
			'buscaProduto' => $buscaProduto,
			'FiltroAssociados' => $FiltroAssociados
		);

		$produtos = chamaAPI(null, '/cadastros/produtos', json_encode($apiEntrada), 'GET');

		echo json_encode($produtos);
		return $produtos;
	}

	header('Location: ../cadastros/produtos.php');
}
