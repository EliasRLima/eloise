<?php

/*		Abstracao
 *      Manipuladora.php
 *
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 *		Definicoes primitivas de SQL para Create(Insert), Read (Select), Update e Delete
 */

error_reporting(0);
Abstract class Manipuladora{

	//ABSTRATOS
	abstract function create($c, $tabela, $colunas, $tuplas, $opcao, $maxinputs, $retorno, $viewsql);

	abstract function update($c, $tabela, $colunas, $tuplas, $filtro, $opcao,  $inputini, $inputfim, $retorno, $viewsql);
	

	//CONCRETOS
	//notify alertas e gravacao de log
	//$c: conexao;
	//$msger
	//$log
	//$instrucao: sql principal e o mesmo que sera gravado no log
	//$resinstrucao: retorno da instrucao se gravou ou nao
	//$pathheader: caminho de redirecionamento da mensagem de alerta
	//$cryptoheader: opcional DEFULT "-1" para criptografar as variaveis get do redirecionamento
	//$tabelahash: tabela que tem campo hash como bloqueador de duplicidade de insert
	//$chavehash: default '-1' dados a serem utilizados para compor a chave unica de hash. Exemplo: chave primaria e/ou CPF e/ou nome e/ou matricula e/ou CNPJ
	//$tipooperacao: definidos na tipo_situacao
	//$tipousuario: definidos na tipo_situacao
	//$metodo: 0 - returns enviar;
	//$metodo: 1 - returns row;
	//$metodo: 2 - returns fetch;
	//$metodo: 3 - returns string sql;
	//$viewsql:0 - oculta sql; 1 - exibe sql
	public function notify($c, $msger, $log, $instrucao, $resinstrucao, $pathheader, $cryptoheader, $tabelahash, $chavehash , $login, $tipooperacao, $tipousuario, $msgalerta, $metodo,$viewsql){
		
		$res = $resinstrucao; //$c->enviar($instrucao);

		$url = $chavehash;//$altnome.$altusuario.$ativo; //echo $url; exit;

		//parametros para alertas
		$header = $pathheader;//"../alt_usuario.php?url=".doCodifica($codconteudo);
		
		$al_success=0;
		
		$al_error=1;

		$al_warning=2;
		
		$al_info=3;

		$al_default=4;

		//$inf_success="Opera&ccedil;&atilde;o realizada!";
		$inf_success .="Operacao realizada!";

		//$inf_erro="Opera&ccedil;&atilde;o n&atilde;o realizada!";
		$inf_erro .="Operacao nao realizada! </p>".$msgalerta;

		$header_success = "&al=".$al_success."&msg=".$inf_success;

		$header_error = "&al=".$al_error."&msg=".$inf_erro;

		//./parametros para alertas

		//-------------------------------------------------------------------------
		//antiBadEngineering
		//

		$hash = md5($url);

		$sqlbe = "SELECT hash FROM ".$tabelahash." WHERE hash='$hash'";

		$antiBadEngine = $c->row($sqlbe);

		// if ($altnome!="" && $antiBadEngine<=0) {
		//echo $res; exit; //problemas aqui porque nao tem hash
		//echo $antiBadEngine; exit; //problemas aqui porque nao tem hash
		

		if ($res>0){//} && TODO:SUBSTITUIR PELO CPF$antiBadEngine<=0) {
		
			

			//login $_SESSION["codusuarioiwe"];	
			$datalog = date('Y-m-d');
			$horalog = date('H:i');		

			$operacao = $instrucao;

			if($viewsql==1){
				
				echo "ORGIGEM: ".$operacao."</p>";	
				// echo "DESTINO: ".str_replace("'","",$operacao); 
				echo "DESTINO: ".$header_success; 
				exit;
			}

			if($viewsql==2){
				
				echo "ORIGEM: ".$operacao."</p>";	
				// echo "DESTINO: ".str_replace("'","",$operacao); 
				echo "DESTINO: ".$header_success; 
				//exit;
			}

			//gravarLog
			//$c
			//$operacao
			//$user
			//$datalog
			//$horalog
			//$tipousuario
			//$tipooperacao
			//$login
			//$metodo
			//$viewsql
			//exit("aqui");
			$reslog = $log->gravarLog(
					$c						
					,str_replace("'","",$operacao) //operacao
					,$datalog
					,$horalog
					,$tipousuario //int
					,$tipooperacao //int
					,$login    //login DEFAULT matricula ou CPF
					,$metodo
					,$viewsql
					);

			//alert
			
			if($reslog>0){

				$header .= $header_success;

				header("Location: {$header}");		
				
			}


			//.alert
				
			}
			
			else{
				//alert

				$header .= $header_error;

				header("Location: {$header}");		
				
				//.alert
				
			}
		
	}//fim notify



	//TODO
	// abstract function read($c, $tabela, $colunas, $tuplas, $opcao, $maxinputs, $retorno, $viewsql);
	//TODO
	//abstract function delete($c, $tabela, $colunas, $tuplas, $opcao, $maxinputs, $retorno, $viewsql);
	
	//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
	//$c: conexao;
	//$metodo: 0 - returns enviar;
	//$metodo: 1 - returns row;
	//$metodo: 2 - returns fetch;
	//$metodo: 2 - returns instrucao sql;
	//$viewsql:0 - oculta sql; 1 - exibe sql
	public function raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql){

		$res =-1;
	
		if($viewsql==1){

			echo $instrucao."<br/>";

			exit();
		}

		switch($metodo){
				//retorna array
				case 0: $res = $c->enviar($instrucao); break;
				//retorna int
				case 1: $res = $c->row($instrucao); break;
				//retorna array
				case 2: $res = $c->fetch($instrucao); break;
				//retorna a consulta
				case 3: $res = $instrucao; break;

				

		}

		if($retorno)
			
			return $res; 


	}
	//readTipoSituacao
	//$c: conexao;
	//$colunas para clausula select;
	//$tabela: tabela da relacao com tipo_situacao;
	//$chave: tipo_<[servidor; pessoa; estagiario;...]>;
	//$tipoMetodo:  0 - returns set;
	//$tipoMetodo:  1 - returns total row;
	//$tipoMetodo:  2 - returns line - usage: $var_array[<index>];
	//$tipoMetodo:  3 - returns instrucao sql;
	//$filtro:  ja incluido o and
	//$viewsql: 0 - oculta sql; 1 - exibe sql
	public function readTipoSituacao($c, $colunas, $tabela, $chave, $tipoMetodo, $filtro, $orderby, $viewsql){


		$instrucao = "SELECT ";		
		$instrucao .= $colunas;
		$instrucao .= " from";
		$instrucao .= " tipo_situacao ts";
		$instrucao .= " where";
		$instrucao .= " ts.nome_tabela='$tabela'";
		$instrucao .= " and ts.nome_coluna='$chave'";
		
		if($filtro!="")

			$instrucao .= " and ".$filtro." ";


		if($orderby!="")

			$instrucao .= " order by ".$orderby;

		//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
		//$c: conexao;
		//$metodo: 0 - returns enviar;
		//$metodo: 1 - returns row;
		//$metodo: 2 - returns fetch;
		//$metodo: 2 - returns instrucao sql;
		//$viewsql:0 - oculta sql; 1 - exibe sql
		//public function raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql) 
		$q = Self::raw_sql($c, $instrucao, $metodo=$tipoMetodo, $retorno=1,$viewsql=$viewsql);

		return $q;

	}

	public function readPessoas($c, $colunas, $tabela, $chave, $tipoMetodo, $filtro, $orderby, $viewsql){


		$instrucao = "SELECT ";		
		$instrucao .= $colunas;
		$instrucao .= " from";
		$instrucao .= " pessoa ts";
		$instrucao .= " where";
		$instrucao .= " ts.tipo_papel='$tabela'";
		
		if($filtro!="")

			$instrucao .= " and ".$filtro." ";


		if($orderby!="")

			$instrucao .= " order by ".$orderby;

		//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
		//$c: conexao;
		//$metodo: 0 - returns enviar;
		//$metodo: 1 - returns row;
		//$metodo: 2 - returns fetch;
		//$metodo: 2 - returns instrucao sql;
		//$viewsql:0 - oculta sql; 1 - exibe sql
		//public function raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql) 
		$q = Self::raw_sql($c, $instrucao, $metodo=$tipoMetodo, $retorno=1,$viewsql=$viewsql);

		return $q;

	}


	


}

?>
