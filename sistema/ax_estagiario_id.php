<?php
	

	require "classes/ExecVerificaSessionClass.php";

	require "classes/Comunicadora.php";

	include("classes/Crud.php");

	include("classes/CPessoa.php");	
	
	$c = new comunicadora();

	$crud = new Crud(); 
	
	$cpessoa = new CPessoa(); 

	//readPessoaLine
	//$c: conexao;
	//$crud: ;
	//$colunas: ;
	//$tabela: ;
	//$tipoMetodo:  0 - returns set;
	//$tipoMetodo:  1 - returns total row;
	//$tipoMetodo:  2 - returns line - usage: $var_array[<index_array>];
	//$tipoMetodo:  3 - returns instrucao sql;
	//$filtro:  DEFAULT: $filtro="". Instrucao sql livre para concatenar no final de $intrucao;
	//$viewsql: 0 - oculta sql; 1 - exibe sql
	//IN(1 - FISICA, 2 - JURIDICA)
	
	$json = "";

	//TODO: TRANSFERIR PARA UMA ROTINA
	//utilizado por autocompletar de cad_pessoa.php
	//XXX: DEPENDENDO DA CODIFICACAO DO NAVEGADOR
	//OU DO CABECALHO HEADER NO PHP 
	//OS NOMES DE EMPRESA NAO RECUPERANDO ID
	//DE NOMES ACENTUADOS. MEDIDA USAR OU NAO 
	//uf8_decode
	
		$nmp = strip_tags($_GET['nmp']); 
	
		$nmp = utf8_decode(trim($nmp)); 
		echo $nmp;exit;
		$qpes = $cpessoa->readPessoa($c, $crud, $colunas="id, matricula as descricao, cadastro", $tabela="pessoa",$tipoMetodo=2, $filtro="matricula = '$nmp'", $viewsql=0);

	 	$pessoa_id = $qpes['id']; 

	 	$json = "<input type='hidden' id='_pessoa_id' name='_pessoa_id' value='$pessoa_id' />";


	//.utilizados por autocompletar de cad_estagio.php
	echo $json;	

?>

