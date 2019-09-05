
<?php

	/*
 *      autho.php
 *      
 *      Copyright 2013 IFMA>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 * 	
 */

	require '../classes/Normalizadora.php';
	require '../classes/Log.php';
	require '../classes/Comunicadora.php';
	require '../classes/Informadora.php';

	
	$c = new comunicadora();
	
	$inf = new Informadora();

	$tipoAuth = 0; //0:DEFAULT

	$login = strip_tags($_POST['loginiwe']); 

	$senha = strip_tags($_POST['senha']);

	//rotas
	$arRotas =array(

					 "pessoa"         =>"../cad_pessoa.php"
					,"home"           =>"../sm_aluno.php" //../seletora.php?url=
					,"index"          =>"index.php"
					,"relatorio"      =>"../../sistema/relatorios.php?url="
					,"urlRelatorio"   =>"_filtro=4,_papel=4"

					);


	$paginaHome = $arRotas[home];//.$inf->doCodifica($arRotas[urlRelatorio]);

	$paginaErro = $arRotas[index];
	
	$paginaRelatorio = $arRotas[relatorio].$inf->doCodifica($arRotas[urlRelatorio]);

	//.rotas



	
	//TODO:alocar em rotina
	$instrucao = "SELECT ";
	$instrucao .= " autenticador, login";
	$instrucao .= " FROM";
	$instrucao .= " login";
	$instrucao .= " WHERE";
	$instrucao .= " nivel in (1)";
 
	$q  = $c->enviar($instrucao);
	$arSA = array();
	while($l = $c->extrair($q)){
		 $arSA[] = $l['autenticador'];  
		}
	   
	//.TODO:alocar em rotina

	
	$msger = new Mensageira();
	
	$log = new Log();

	$ld = null;

	
	function anti_sql_injection($str) {
	    if (!is_numeric($str)) {
		$str = get_magic_quotes_gpc() ? stripslashes($str) : $str;
		$str = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($str) : mysql_escape_string($str);
	    }
	    return $str;
	}
	
	$instrucao = " SELECT";
	$instrucao .= " * ";
	$instrucao .= " FROM";
	$instrucao .= " login l, pessoa p";
	$instrucao .= " WHERE";
	$instrucao .= " p.id=l.pessoa_id";
	$instrucao .= " and";

	if ($tipoAuth == 0){
			
			$instrucao .= " autenticador = '".anti_sql_injection(strip_tags($login))."'";			
			$instrucao .= " AND senha = '".anti_sql_injection(sha1(strip_tags($senha)))."'";
			$instrucao .= " AND ativo = 1";
			
			$q = $c->fetch($instrucao);

			if($c->row($instrucao) >= 0){
				
				session_start();
				
				$_SESSION['codusuarioiwe'] = $q['id'];
				$_SESSION['dispname'] = $q['nome'];
				
				$_SESSION['loginiwe'] = strip_tags($_POST['loginiwe']);

				//TODO: GRAVAR LOG
				
				//.TODO: GRAVAR LOG

				
				header("Location: {$paginaHome}");
			
				exit;

			}

			else {

				$destino = "entrar.php";

					include ('../../static/layout/iniciohead.html');				

					include ('../../static/layout/iniciopg.html');

					include ('../../static/layout/estilos.html');
				
					include ('../../static/layout/scripts.html');
					?>


					<link href="../../static/css/buttons.css" rel="stylesheet" type="text/css" />


					<div id="box-form-sistema">

					<!-- <div id="box-titulo"></div> -->

					<div id="box-botoes">
                     

					<?
					$msger->msgPadrao($tit="ELOISE"
										, $inf="Usu&aacute;orio sem permiss&atilde;o de acesso!"
										, $txb="Continuar"
										, $destino
										, $cssb="botao-vermelho"
										, $cssm="error"
										, $x="10"
										, $y="10"
										);

					?>
					</div> <!-- /.box-botoes --> 

						
					</div> <!-- box-form-sistema -->

					<?

					require "../../static/layout/rodape.html"; 
				
			}
	
	} 

	?>