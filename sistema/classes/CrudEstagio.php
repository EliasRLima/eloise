<?php
/*      CrudEstagio.php
 *		Extensao de Manipuladora.php
 *
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 *		Definicoes primitivas de SQL para Create(Insert), Read (Select), Update e Delete
 */

include("Manipuladora.php");

//Crud generico
//Cada tabela podera estender Create(Insert), Read (Select), Update e Delete deste Crud
//ou de Manipuladora caso haja sobrescrita (override)
class CrudEstagio extends Manipuladora{
	//abstrato
	//create($c, $tabela, $acolunas, $atuplas, $opcao, $maxinputs, $retorno, $viewsql)
	//$c: conexao;
	//$metodo: 0 - returns enviar;
	//$metodo: 1 - returns row;
	//$metodo: 2 - returns fetch;
	//$metodo: 2 - returns instrucao sql;
	//$viewsql:0 - oculta sql; 1 - exibe sql e para; 2 - returns sql
	//public function raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql) 
	public function create($c, $tabela, $acolunas, $atuplas, $opcao, $maxinputs, $retorno, $viewsql){

		$res  = 0;

		$laco = 1;
		
		$lacocol = 1;
		
		$instrucao = "insert into ";

		$instrucao .= $tabela;
		
		if($opcao=1){

			$instrucao .= " (";		

			//$instrucao .= $acolunas;		
			foreach ($acolunas as $input => $valor) {
			
				//strip_tags bloquea de xss
				
				
				if($lacocol<=$maxinputs){

					
					if(is_string(($input))){

						
						$instrucao .= addslashes(strip_tags($input)); 
						
						
					}else{


						$instrucao .= addslashes(strip_tags($input)); 

					}
					
					if($lacocol<=($maxinputs-1))	$instrucao .=","; 

					$lacocol++;
				}	
			}	

			$instrucao .= " )";		
		}

		$instrucao .= " values";		

		$instrucao .= " (";
		

		foreach ($atuplas as $input => $valor) {
			
			//strip_tags bloquea de xss
			
			if($laco<=$maxinputs){

				
				if(is_string(($valor))){

					$instrucao .="'"; 
					$instrucao .= addslashes(strip_tags($valor)); 
					$instrucao .="'"; 
					
				}else{


					$instrucao .= addslashes(strip_tags($valor)); 

				}
				
				if($laco<=($maxinputs-1))	$instrucao .=","; 

				$laco++;
			}	
		}	

		$instrucao .= " );";
		
		if($viewsql){
		
			echo $instrucao; exit(); 
		
		}elseif($viewsql==2){

			return $instrucao;

		}else{

			$res = $c->enviar($instrucao);  		

		} 			



		if($retorno)
			
			return $res; 


	}//fim create

	

	//concreto
	//create($c, $tabela, $acolunas, $atuplas, $opcao, $maxinputs, $retorno, $viewsql)
	//$c: conexao;
	//$metodo: 0 - returns enviar;
	//$metodo: 1 - returns row;
	//$metodo: 2 - returns fetch;
	//$metodo: 2 - returns instrucao sql;
	//$viewsql:0 - oculta sql; 1 - exibe sql e para; 2 - returns sql
	public function rawCreate($c, $tabela, $acolunas, $avalues, $filtro, $opcao, $retorno, $viewsql){
		
		$res   = 0;
		$acols = array();
		$avals = array();
		
		//filtros
		if($opcao=1){
			

		}

		

		foreach ($acolunas as $key => $val) 

				$acols[] = addslashes(strip_tags($val)); 
		
		
		foreach ($avalues as $key => $val) 

				$avals[] = addslashes(strip_tags($val)); 
		

		$colunas = implode("," , array_values($acols));
		
		$valores = "'".implode("', '" , array_values($avals))."'";
		
			
		$instrucao =  "INSERT INTO {$tabela} ({$colunas}) VALUES ({$valores})";

		if($filtro!=""){

			$instrucao .= " ";
			$instrucao .= $filtro;
			
		
		}
		
		$instrucao .= ";";
		
		if($viewsql==2){

			return $instrucao; //exit(); 
		
		}if($viewsql==3){

			echo $instrucao; //exit(); 
		
		}elseif($viewsql){
		
			echo $instrucao; exit(); 
		
		}else{

			$res = $c->enviar($instrucao);  		

		} 			


		if($retorno)
			
			return $res; 

	}//.create


	public function update($c, $tabela, $acolunas, $atuplas, $filtro, $opcao, $inputini, $inputfim, $retorno, $viewsql){

		$res   = 0;
		$laco  = 1;
		$index = 0;		
		$instrucao = "update ";
		$instrucao .= $tabela;
		
		//filtros
		if($opcao=1){
			

		}

		$instrucao .= " set ";		
		
		
		foreach ( $atuplas as $ptag => $vtag ) {
				
				if( $laco<=$inputfim ){

					
					//echo "=:".$ptag; exit;
					//echo "=:".$vtag; exit;

					if( is_string(($vtag)) ){

						$instrucao .= $acolunas[$index];
						$instrucao .= "=";
						$instrucao .="'"; 
						$instrucao .= addslashes(strip_tags($vtag)); 
						$instrucao .="'"; 
					
					}else{

						$instrucao .= $acolunas[$index];
						$instrucao .= "=";
						$instrucao .= addslashes(strip_tags($vtag)); 

					}
					
					if($laco<=($inputfim-1))	$instrucao .=","; 

					$laco++;
					$index++;

				}//fim if laco	

			}//fim foreach	

		if($filtro!=""){

			$instrucao .= " ";
			$instrucao .= $filtro;
			
		
		}
		
		$instrucao .= ";";
		
		if($viewsql==2){

			return $instrucao; //exit(); 
		
		}elseif($viewsql){
		
			echo $instrucao; exit(); 
		
		}else{

			$res = $c->enviar($instrucao);  		

		} 			



		if($retorno)
			
			return $res; 


	}

	

	//FIXME
	public function read($c, $tabela, $colunas, $tuplas, $opcao, $maxinputs, $retorno, $viewsql){

		$res   = 0;
		$laco  = 1;
		$index = 0;

		$instrucao = "select ";
		$instrucao .= $tabela;
		
		//filtros
		if($opcao=1){
			

		}

		
		foreach ( $atuplas as $input => $valor ) {
			
				
				if( $laco<=$inputfim ){

					
					if( is_string(($valor)) ){

						$instrucao .= $acolunas[$index];
						$instrucao .= "=";
						$instrucao .="'"; 
						$instrucao .= addslashes(strip_tags($valor)); 
						$instrucao .="'"; 
						
					}else{

						$instrucao .= $acolunas[$index];
						$instrucao .= "=";
						$instrucao .= addslashes(strip_tags($valor)); 

					}
					
					if($laco<=($inputfim-1))	$instrucao .=","; 

					$laco++;
					$index++;

				}//fim if laco	

			}//fim foreach	

		if($filtro!=""){

			$instrucao .= " ";
			$instrucao .= $filtro;
			
		
		}
		
		$instrucao .= ";";
		
		if($viewsql){
		
			echo $instrucao; exit(); 
		
		}else{

			$res = $c->enviar($instrucao);  		

		} 			



		if($retorno)
			
			return $res; 


	}

	public function readChaves($c, $tabela, $colunas, $values, $filtro, $viewsql){

		//$value ainda nao foi usado

		$instrucao = " SELECT ";
		$instrucao .= " ".$colunas." ";
		$instrucao .= " FROM";
		$instrucao .= " ".$tabela." ";

		if ($filtro!=""){

			$instrucao .=" WHERE ";
			$instrucao .= " ".$filtro." ";
			

		}
		//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
		//$c: conexao;
		//$metodo: 0 - returns enviar;
		//$metodo: 1 - returns row;
		//$metodo: 2 - returns fetch;
		//$metodo: 2 - returns instrucao sql;
		//$viewsql:0 - oculta sql; 1 - exibe sql
		$q = Self::raw_sql($c, $instrucao, $metodo=2, $retorno=1,$viewsql);


		if($q[$colunas]==$values) 
			
			return 1;

		else
			
			return 0;	 



	}

	//TODO: CRIAR ARRAYS PARAMETRIZADOR DAS COLUNAS E TABELAS
	public function createChaves($c, $tabela, $colunas, $values, $viewsql){
		
			$instrucao = "INSERT ";		
			$instrucao .= " INTO ";		
			$instrucao .= $tabela." (";
			
			$instrucao .= $colunas;
			
			//$instrucao .= $colunas="id,";
			//$instrucao .= $colunas="pessoa_id";//, setor_id";
			
			$instrucao .= " ) VALUES(";
			
			$instrucao .= $values;
			
			// $instrucao .= "'";
			// $instrucao .= $values;
			// $instrucao .= "'";
			// $instrucao .= ",";
			// $instrucao .= "'";
			// $instrucao .= $values;
			// $instrucao .= "'";
			
			
			$instrucao .=");";

			//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
			//$c: conexao;
			//$metodo: 0 - returns enviar;
			//$metodo: 1 - returns row;
			//$metodo: 2 - returns fetch;
			//$metodo: 2 - returns instrucao sql;
			//$viewsql:0 - oculta sql; 1 - exibe sql
			$q = Self::raw_sql($c, $instrucao, $metodo=0, $retorno=1,$viewsql);

			
			if($q) 
				
				return 1; 

			else 
				return  0;  
			
	}

	

}//fim classe Crud

?>
