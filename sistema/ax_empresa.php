<?php
	

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
	$json = "['Nenhum resultado encontrado!']";

	$qpes = $cpessoa->readPessoa($c, $crud, $colunas="id, nome as descricao, cadastro", $tabela="pessoa", $tipoMetodo=0, $filtro="tipo_papel in (2)", $viewsql=0);
	while($l = $c->extrair($qpes))

	 	$ar[] = utf8_encode($l['descricao']);							

	 $json = $ar;

	
	echo json_encode($json).";";	

?>