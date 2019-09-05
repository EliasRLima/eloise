<?php
	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryd = "SELECT nome from pessoa where tipo_papel in (3) and matricula like '".$_POST['name']."';";
	$resultado = @mysqli_query($link,$queryd);
	$num_linhas = @mysqli_num_rows($resultado);
	$linha = @mysqli_fetch_assoc($resultado);
	if($num_linhas>0){
		echo $linha['nome'];
	}
	else{
		echo "Nenhum nome com essa matricula";
	}
?>