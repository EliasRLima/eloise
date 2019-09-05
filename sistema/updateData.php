<?php

require "classes/Normalizadora.php";

$nr = new Normalizadora();
//atualizar dados tratados e inseridos
$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				
				//query para buscar estagios
$query = "select data_nascimento,nome from sis";
$resultado = @mysqli_query($link,$query);
$num_rows_sis = @mysqli_num_rows($resultado);
$qs = @mysqli_fetch_assoc($resultado);
$aux = 0;
do{
	$queryupd = "update pessoa set data_nascimento = '".$nr->normalizarData($qs['data_nascimento'],16)."' where nome like '".$qs['nome']."' and id > 5634";
	//echo $queryupd;exit();
	@mysqli_query($link,$queryupd);
	$aux = $aux + 1;
}while ($qs = @mysqli_fetch_assoc($resultado));

echo "Atualizados: ".$aux." resultados";
?>

