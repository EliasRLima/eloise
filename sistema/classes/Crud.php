<?php
/*      Crud.php
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
class Crud extends Manipuladora{

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
				
				//HACK: ABRE PRECEDENTE PARA TORNAR ESTE CRUD
				// -QUE FOI CRIADO PARA SER FRACAMENTE ACOPLADO - EM FORTEMENTE ACOPLADO À PESSOA
				//ATUANDO COMO UM MODEL DA CLASSE PESSOA
				//POSSIBILITANDO RECURSOS TAIS COMO $crud_pessoa, $crud_servidor...
				if($input == 'aux_pessoa_id') {
					
					$input = 'pessoa_id'; 
					
				}


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

	//hack
	

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
	

	



}//fim classe Crud

?>
