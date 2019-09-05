<?php

/*
 *      Comunicadora.php
 *
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 * 		
 */

error_reporting(0);
//---------------------------------------------------------------------------------
//                                           Mysql
//---------------------------------------------------------------------------------
class Comunicadora{

	var $_msag = null;
	var $_nomeapp = null;
	var $_titulomsag = null;
	var $_camminhobotao = null;
	var $_bd = null;

	function comunicadora(){
		//0: localhost; 1: producao
		$srv = 0;

		$this->_msag = new Mensageira();

		$this->nomeapp = "ELOISE-MY";
		$this->titulomsag = "Esta&ccedil;&atilde;o Local Independente para Supervis&atilde;o de Estudantes";
		$this->camminhobotao = "../index.php";
		$this->bd = "eloisebd";

		if ($srv == 1)

			@mysql_connect("127.0.0.1", "user", "senha") or die (
						$this->_msag->viewMsg("error",
					   $this->titulomsag,
					   $this->nomeapp." - N&atilde;o foi poss&iacute;vel estabelecer conex&atilde;o!" ,
					   "",
					   $this->camminhobotao,
					   55)
					   );
		else

			@mysql_connect("localhost", "eloise", "eloise")
			or die (
			$this->_msag->viewMsg("error",
					   $this->titulomsag,
					   $this->nomeapp." - N&atilde;o foi poss&iacute;vel estabelecer conex&atilde;o!" ,
					   "",
					   $this->camminhobotao,
					   55)
					   );

		@mysql_select_db($this->bd)
		or die (
		$this->_msag->viewMsg("error",
					   $this->titulomsag,
					   $this->nomeapp." - Banco de dados n&atilde;o encontrado!" ,
					   "",
					   $this->camminhobotao,
					   55)
					   );

	}

	function enviar($sql){
		# update, insert, delete... usar no while
		$resultado = mysql_query($sql)
		or die (
	    $this->_msag->viewMsg("error",
					   //$sql,
					   $this->titulomsag,
					   $this->nomeapp." - N&Atilde;O FOI POSS&Iacute;VEL ENVIAR DADOS" ,
					   "",
					   $this->camminhobotao,
					   55)
					   );

		return $resultado;
	}

	function fetch($sql){
		#essa resultado de um select especifico com mysql_fetch_array()
		$resultado = mysql_query($sql)
		or die (
	    $this->_msag->viewMsg("error",
					   $this->titulomsag,
					   // $sql,
					   $this->nomeapp." - N&Atilde;O FOI POSS&Iacute;VEL GRAVAR DADOS" ,
					   "Voltar",
					   $this->camminhobotao,
					   200)
					   );

		$linha = mysql_fetch_array($resultado, MYSQL_BOTH);
		return $linha;
	}

	function row($sql){

		#numero de linhas de um select especifico com mysql_num_rows()
		$resultado = mysql_query($sql)

		or die (
	    $this->_msag->viewMsg("error",
					   $this->titulomsag,
					   // $sql,
					   $this->nomeapp." - N&Atilde;O FOI POSS&Iacute;VEL OBTER LINHA",
					   "",
					   $this->camminhobotao,
					   55)
					   );

		$row = mysql_num_rows($resultado);
		return $row;
	}
	function extrair($array){
				#para utilizar como contador do laco que percorre os resultados
				return mysql_fetch_array($array);

			}
}

?>


<style>
body {font-family:Arial, Helvetica, sans-serif; font-size:13px;}
p#info-titulo {font-size:13px;}
.info, .success, .question, .warning, .error, 
.validation {border: 1px solid;	margin: 10px 0px;	padding:15px 10px 15px 50px;	background-repeat: no-repeat;	background-position: 10px center;}
.info {color: #00529B;background-color: #BDE5F8;background-image: url('../../static/layout/info.png');}
.success {color: #4F8A10;background-color: #DFF2BF;background-image:url('../../static/layout/success.png'); border-color: #DAA520;}
.question {color: #00529B;background-color: #BDE5F8;background-image:url('../../static/layout/question.png');background-size:70px;}
.warning {color: #9F6000;background-color: #FEEFB3;background-image: url('../../static/layout/warning.png');}
.error {color: #FFFFFF! important; background-color: #CC0000;background-image: url('../../static/layout/error.png'); border-color: #DAA520! important;}
table.msg-alertas { border-collapse: collapse; border:1px solid; width:30%;	}

</style>

<?php
/*
 *      Mensageira.php
 *
 *      Copyright 2013 IFMA CAMPUS MONTE CASTELO
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
 */



class Mensageira{


	var $_agora = null;
	var $_hoje = null;

	//contrutor
	function Mensageira(){

		$this->_agora = date("H:i:s");
		$this->_hoje = date("Y-m-d");

	}
	public function viewMsg($msgTipo, $msgTitulo, $msgRetorno, $labelbotao, $destino, $msgPorcLargTela){

		?>
		<div align="center" style="padding-top:35px;padding-bottom:170px;">
		<form name="frmerrologin" >
			<table width="<?=$msgPorcLargTela?>" border="0" class="<?=$msgTipo?>">
			  <tr>
				<td align="center"><p><strong><?=$msgTitulo?></strong></p></td>
			  </tr>
			  <tr>
				<td align="center" class="style38">&nbsp;</td>
			  </tr>
			  <tr>
					<td align="right" style="padding-left:150px;"><p align="right"><?= $msgRetorno ?></p></td>
			 </tr>
			  <tr>
				<td align="center">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center"><a href="<?=$destino ?>" >
				  <label>
				  <?
					if ($labelbotao!="")
						echo "<input name='botao' type='button' class='labelazul' onClick='window.location.href = '$destino' value='$labelbotao'>";
				  ?>
				  </label>
				</a></td>
			  </tr>
			</table>
		</form>
		</div>
		
	<? }//fim viewMsq

	//$tit, $inf, $txb, $des, $cssb, $cssm
	public function msgPadrao($tit, $inf, $txb, $des, $cssb, $cssm, $x, $y){

			?>

			<div align="center" style="margin-top:<?php echo $x;?>; margin-left:<?php echo $y;?>">
						<div class="<?php echo $cssm;?>">

							<div id="titulo">
							<p><strong></strong><?php echo $tit;?></strong></p>
							</div><!--divtitulo -->

							<div id="icone"></div><!--divicone-->
							<div id="info">
								<p align="right" id="info-titulo"><?php echo $inf; ?></p>
							</div><!--divinfo -->

							<div id="clear"></div>

							<div id="box-botoes">
							<a href="<?php echo $des; ?>" class="<?php echo $cssb; ?>"><?php echo $txb; ?></a>
							</div><!--div -->

						</div><!--divbox-mensagem -->
						<div id="clear"></div>

			</div><?

	}//fim msgPadrao

}//fim classe Mensageira

?>




