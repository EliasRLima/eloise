
<?php
error_reporting(0);
//HACK:BANCO
$iso = 1;

$utf = 0;

$msg = "";

if ($iso==1){

	header ('Content-type: text/html; charset=ISO-8859-1');

	$msg = iconv('utf8','ISO-8859-1',$_GET['msg']);

}


elseif($utf==1) {

	
	header ('Content-type: text/html; charset=UTF-8');

	$msg = $_GET['msg'];
}

?>

<?php

//LAYOUT

include ('../static/layout/ihtml.html');

include ('../static/layout/ihead_base_styles.html');

include ('../static/layout/base_styles_fhead.html');

//./LAYOUT

//CONFIGURACOES BASICAS
/*
 *      pagina_em_branco.php
 *
 *
 *      Desenvolvedor:
 *
 *      Copyright
 *
 *      Instituto Federal do Maranhao - Campus Monte Castelo
 */

	require "classes/ExecVerificaSessionClass.php";

	require "classes/Comunicadora.php";

	include("classes/Crud.php");

	include("classes/Gui.php");	

	include("classes/CPessoa.php");	
	
	require "classes/Normalizadora.php";

	require "../static/layout/scripts.html";


	//----------------------------------------------------------------------------
	//Controle de permissoes
	//----------------------------------------------------------------------------


	$nr = new Normalizadora();

	//----------------------------------------------------------------------------

	//instancia para os combos e check
	$c = new comunicadora();

	$crud = new Crud(); 
	
	$gui = new Gui(); 
	
	$cpessoa = new CPessoa(); 


	$action = "#";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="RELAT&Oacute;RIO";

//.CONFIGURACOES BASICAS

//MENU

include ('../static/layout/layout_menu_nav.php');

//.MENU

//CONTEUDO 




?>


<?php include ('../static/layout/layout_icontent_breadcrumbs.php');  ?>


<div class="col-xs-12">
 <!-- PAGE CONTENT BEGINS -->

 <?php 
//NOFIFICACAO

	//$msg 	    = "";	
	//$classmsg = "alert alert-danger";		
	//$href     = "";
	//$txtHef   = "";		
	//$header   = "";
 	
 	//$inf->Informadora() declarada
 	//em static/layout/layout_menu_nav.php
	if (isset($_GET['al']) && isset($_GET['msg']))

		echo $inf->nav_notificacao( $al=$_GET['al'] 
									,$msg//=$_GET['msg']
							        ,$classmsg= "alert alert-danger"				
							  		,$href="#"
							  		,$txtHef=""		
							  		,$header="#"
							 	  );

//./NOFIFICACAO



?>



<script>


</script>



<div class="page-header">
    <h1>
        <? echo $descrelatorio;?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo "Localize o resultado desejado";?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">
			
			 <?php

			 if (in_array($_SESSION["loginiwe"],$arSA)   ){
			  $string = $_POST['pessoa'];
			  $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				
				//query para buscar estagios
				$query = "select *,(select descricao from curso where id = pessoa.curso_id)as curso from pessoa where nome like '%";
				$query .= $string;
				$query .= "%';";
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<?
				// se o número de resultados for maior que zero, mostra os dados
				if($num_rows > 0) {
				// inicia o loop que vai mostrar todos os dados	
					?>
					<p>
						<h3>Numero de pessoas localizadas: <?echo $num_rows;?></h3>
					</p>
					<p>
						<?if($num_rows >30){
						?><h5>Maximo de 30 resultados, tente ser mais especifico</h5><?
						}?>
					</p>
					<head>
					<style>
					table, th, td {
    				border: 1px solid black;
    				border-collapse: collapse;
					}
					th, td {
   					 padding: 5px;
					}
					th {
  					  text-align: left;
					}
					</style>
					</head>
					<table width="100%">
					<tr>
						 <th>Desativar</th>
  			 			 <th>Nome</th>
  			 			<th>CPF/CNPJ</th>
   			 			 <th>Sexo</th>
   			 			 <th>Bairro</th>
   			 			 <th>Telefones</th>
   			 			 <th>Fun&ccedil;&atilde;o</th>

  					</tr> <?
  					$controlador = 0;
				do {
					?>
  					<tr>
  						<td>

            				<?php $url="_id=".$linha['id'];?>
  							<a href="confirmar_inativar.php?url=<?php echo $inf->doCodifica($url)?>" name="msgdestino"/>
								<i class="ace-icon fa fa-lock" style="color: black;"></i>
							</a>
  							<!--<form name="relatorioAlunos" method="POST" action="relatorio_completo.php?url=eJyLz0yxNbQwBgAJNAIG">
  												<input type="hidden" name="tipoP" id="tipoP" value="3"/>
												<input type="hidden" name="AlunoR" id="AlunoR" value="<?=$linha['id']?>"/>
												<input style="width:100%;" class="menu-icon fa fa-search" type="submit" name="button" id="button" value=""/>
							</form>-->
						</td>

  						<td><?=$linha['nome']?></td>
  						<td><?=$linha['cadastro']?></td>
  						<td><?$sexo=$linha['sexo'];if($sexo==1){echo "Feminino";}elseif($sexo==2){echo "Masculino";}?></td>
  						<td><?=$linha['bairro']?></td>
  						<td><?$telefone = str_replace(",-1","", $linha['telefones']);$telefone = str_replace("1=>","", $telefone);$telefone = str_replace('"]',"", $telefone); $telefone = str_replace("0=>","", $telefone);$telefone = str_replace('["',"", $telefone);$telefone = str_replace(',"',"", $telefone);$telefone = str_replace(",,",",", $telefone);$telefone = str_replace(",,",",", $telefone); echo $telefone; ?></td>
  						<?
   			 			 if($linha['tipo_papel']==1){
   			 			 	?><td>Servidor</td><?
   			 			 	}
   			 			 elseif($linha['tipo_papel']==2){
   			 			 	?><td>Empresa</td><?
   			 			 }
   			 			 elseif($linha['tipo_papel']==3){
   			 			 	?><td>Aluno</td><?
   			 			 }

   			 			 ?>
  					</tr>
						<?
						$controlador+=1;

				}while ($linha = @mysqli_fetch_assoc($resultado) and $controlador <30);
					# code...
				?></table><?
			}
				else{
					?><p></p><?
					echo "Nenhum aluno localizado!";
				}

				}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
			 ?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="sm_busca_novo_inativo.php" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Retornar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>

		     <input type="hidden" name="siape_" value="<?=$_SESSION['loginiwe']?>"/>
			 <input type="hidden" name="login_" value="<?=$_SESSION['dispname']?>"/>
			 <input type="hidden" name="filtro" id="filtro_" value="<?=$filtro ?>"/>
			 <input type="hidden" name="palpel" id="papel_" value="<?=$papel ?>"/>
		    <br/>
		    <img src="../static/img/processing.gif" id="loader"  style="display:none; color: green; padding-top:350px;"/>
		    <!-- PAGE CONTENT ENDS -->
			

		</div><!-- widget-main -->
	</div><!-- widget-body -->
</div>	<!-- ./widget-box -->	    
		    	


    
</div><!-- /.cols -->


<?php include ('../static/layout/layout_fcontent.php');  ?>

<?php

//RODAPE

include ('../static/layout/footer_fhtml.html'); 

//.RODAPE


?>
<script src="../static/layout/assets/js/jquery.mask.min.js"></script>
