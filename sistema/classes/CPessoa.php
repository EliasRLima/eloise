<?php
/*      CPessoa.php
 *		Controlador para utilizar as funcoes crud
 *		
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 *		Definicoes de controle para uso das primitivas de SQL para Create(Insert), Read (Select), Update e Delete
 */
//Exemplos
//obter tipo situacao
//obter servidor
//obter estagiario
//obter login


//echo $ins->create($c,$tabela="servidor",$colunas="pessoa_id, matricula, tipo_servidor",$campo=$_REQUEST,$opcao=1,$maxinputs=3,$retorno=0,$viewsql=0); 

//echo $ins->update($c,$tabela="servidor",$colunas=array("pessoa_id","matricula"),$campo=$_REQUEST,$filtro="where pessoa_id=".$_REQUEST['nome'],$opcao=1,$inputini=0, $inputfim=2,$retorno=0,$viewsql=0); 

//echo $ins->read($c,$tabela="servidor",$colunas=array("pessoa_id","matricula"),$campo=$_REQUEST,$filtro="where pessoa_id=".$_REQUEST['nome'],$opcao=1,$inputini=0, $inputfim=2,$retorno=0,$viewsql=1); 

//.Exemplos


error_reporting(0);
	class CPessoa {

		//readPessoa
		//$c: conexao;
		//$crud: ;
		//$colunas: ;
		//$tabela: ;
		//$tipoMetodo:  0 - returns set;
		//$tipoMetodo:  1 - returns total row;
		//$tipoMetodo:  2 - returns line - usage: $var_array[<index>];
		//$tipoMetodo:  3 - returns instrucao sql;
		//$filtro:  DEFAULT: $filtro="". Instrucao sql livre para concatenar no final de $intrucao;
		//$viewsql: 0 - oculta sql; 1 - exibe sql
		public function readPessoa($c, $crud, $colunas, $tabela, $tipoMetodo, $filtro, $viewsql){

			//TODO: PARAMETRIZAR AS TUPLAS
			$instrucao  = "SELECT ";
			$instrucao .= " ".$colunas." ";			
			$instrucao .= " FROM";
			$instrucao .= " ".$tabela;			
			if ($filtro!="") $instrucao .= " WHERE";						
			$instrucao .= " ".$filtro." ";  
			

			//./mandar consultas para os controladores

			//abstrato raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
			//$c: conexao;
			//$metodo:  0 - returns enviar;
			//$metodo:  1 - returns row;
			//$metodo:  2 - returns fetch;
			//$metodo:  2 - returns instrucao sql;
			//$retorno: 0 - doesn't return sql result method; 1 - returns sql result method
			//in order to fetch method $retorno always must be 1;
			//$viewsql: 0 - oculta sql; 1 - exibe sql
			$q = $crud->raw_sql($c, $instrucao, $metodo=$tipoMetodo, $retorno=1,$viewsql=$viewsql);

			return $q;



		}


	}	



	
	


?>
