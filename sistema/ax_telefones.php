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

	$id = strip_tags($_GET['id']); //echo $id;
	
	$id = trim($id);
	
	$json = "['Nenhum resultado encontrado!']";


	$qpes = $cpessoa->readPessoa($c, $crud, $colunas="id, telefones as descricao", $tabela="pessoa",$tipoMetodo=2, $filtro="id = $id", $viewsql=0);

 	echo "<ul id='tels-gravados' style='list-style-type:none;'>";
	
	$telefones = json_decode($qpes['descricao']);
	

	foreach ($telefones as $t) {

 		$t = substr(str_replace("=>", "", $t),1);

 		echo  "<li>";
 		echo  "<hr/>";
 		echo "<input class='' name='telefones[]' id='telefones' value='$t' placeholder='Telefones' size='40' maxlength='255' type='text' />";
 		echo "<a href='#' class='remover_campo'>";
                                
 		echo "<i class='ace-icon fa fa-times square red'></i>";
		echo "</a>";
 		echo "</li>";
		
	}


 	echo "</ul>";


?>

