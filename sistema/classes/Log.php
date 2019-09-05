<?php

class Log {


	//----rotinas de mensagens usadas em validacao para refactoring
	//gravarLog($c,$operacao,$user,$datalog,$horalog,$tipousuario,$numinsc,$tipooperacao,$login,$metodo,$viewsql)
	//$c: conexao;
	//$metodo: 0 - returns enviar;
	//$metodo: 1 - returns row;
	//$metodo: 2 - returns fetch;
	//$metodo: 3 - returns string sql;
	//$viewsql:0 - oculta sql; 1 - exibe sql
	//return array ou int
	public function gravarLog($c,$operacao,$datalog,$horalog,$tipousuario,$tipooperacao,$login,$metodo,$viewsql){

		$retorno = -1;

		$iphost = "0.0.0.0";//$_SERVER["REMOTE_ADDR"]."-".$_SERVER["REMOTE_HOST"];

		$datalogdatetime = $datalog." ".$horalog.'.123';

		$instrucao  = " INSERT INTO log";
		$instrucao .= " (";
		$instrucao .= "  data";
		$instrucao .= " ,hora";
		$instrucao .= " ,operacao";
		$instrucao .= " ,tipo_usuario";
		$instrucao .= " ,tipo_operacao";
		$instrucao .= " ,login";
		$instrucao .= " ,ip";
		$instrucao .= ")";
		$instrucao .= " values";
		$instrucao .= " (";


		$instrucao .= " '$datalog'";
		$instrucao .= ", '$horalog'";
		$instrucao .= ", '$operacao'";
		$instrucao .= ", '$tipousuario'";
		$instrucao .= ", '$tipooperacao'";
		$instrucao .= ", '$login'";
		$instrucao .= ", '$iphost'";
		$instrucao .= ")";


		if($viewsql==1){

			echo $instrucao."-<br/>";

			exit();
		}

		switch($metodo){
				//retorna array
				case 0: $retorno = $c->enviar($instrucao); break;
				//retorna int
				case 1: $retorno = $c->row($instrucao); break;
				//retorna array
				case 2: $retorno = $c->fetch($instrucao); break;
				//retorna array
				case 3: $retorno = $instrucao; break;


		}

		return $retorno;

	}


}
?>

