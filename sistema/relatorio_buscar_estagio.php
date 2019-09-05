
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

//.Atualiza situacao auto

 	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
	$qdata = @mysqli_query($link,$queryd);
	$data = @mysqli_fetch_assoc($qdata);
	$data = $data['ano']."-".$data['mes']."-".$data['dia'];


	$query = "select id,situacao_estagio,data_termino,data_inicio,(select nome from pessoa where id = estagiario_id) as estagiario,(select nome from pessoa where id = empresa_id) as empresa from estagio";

				//echo $query;exit();
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<?
				// se o número de resultados for maior que zero, mostra os dados
				if($num_rows > 0) {
				// inicia o loop que vai mostrar todos os dados	

					do {
					
						if(strtotime($data) > strtotime($linha['data_inicio']) and strtotime($data) < strtotime($linha['data_termino'])){
  							if($linha['situacao_estagio'] != 1 and $linha['situacao_estagio'] != 3 and $linha['situacao_estagio'] != 4){
  								$queryUPD = "update estagio set situacao_estagio = 1 where id = '".$linha['id']."';";
  								@mysqli_query($link,$queryUPD); 
  							}
  						}
  						elseif(strtotime($data) > strtotime($linha['data_termino'])){
  							if($linha['situacao_estagio'] != 2 and $linha['situacao_estagio'] != 3 and $linha['situacao_estagio'] != 4){
  								$queryUPD = "update estagio set situacao_estagio = 2 where id = '".$linha['id']."';";
  								@mysqli_query($link,$queryUPD); 
  							}
  						}

					}while ($linha = @mysqli_fetch_assoc($resultado));
					# code...
				}
				else{
					//echo "Estagio nao localizado!";
				}
	//echo "<script language='javascript' type='text/javascript'>alert('Atualizado!');window.location.href='verificaDatasEstagio.php'</script>";


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
			  $string = $_POST['EstN'];
			  $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				
				//query para buscar estagios
				$query = "select *,(select nome from pessoa where id = e.estagiario_id) as est,(select nome from pessoa where id = e.empresa_id) as emp from estagio e where (select nome from pessoa where id = e.estagiario_id) like '%";
				$query .= $string;
				$query .= "%';";
				//echo $query; exit();
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
						<h3>Numero de alunos localizados: <?echo $num_rows;?></h3>
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
						 <th></th>
  			 			 <th>Estagiario</th>
   			 			 <th>Empresa</th>
   			 			 <th>Data inicio</th>
   			 			 <th>Data termino</th>
   			 			 <th>Situa&ccedil;&atilde;o</th>
  					</tr> <?
  					$controlador = 0;
				do {
					?>
  					<tr>
  						<td>

  							<?php $url="_AlunoR=".$linha['estagiario_id'];?>
  							<a href="relatorio_completo.php?url=<?php echo $inf->doCodifica($url)?>" class="dropdown-toggle">
              					<i class="menu-icon fa fa-search" style="color: black;"></i>
            				</a>

            				<?php $url="_id=".$linha['id'];?>
  							<a href="edi_estagio.php?url=<?php echo $inf->doCodifica($url)?>" name="msgdestino"/>
								<i class="ace-icon fa fa-pencil" style="color: black;"></i>
  							<!--<form name="relatorioAlunos" method="POST" action="relatorio_completo.php?url=eJyLz0yxNbQwBgAJNAIG">
  												<input type="hidden" name="tipoP" id="tipoP" value="3"/>
												<input type="hidden" name="AlunoR" id="AlunoR" value="<?=$linha['id']?>"/>
												<input style="width:100%;" class="menu-icon fa fa-search" type="submit" name="button" id="button" value=""/>
							</form>-->
						</td>
  						<td><?=$linha['est']?></td>
  						<td><?=$linha['emp']?></td>
  						<td><?
  						$mydata=$linha['data_inicio'];
						$brdata = substr($mydata,8,2)."/".substr($mydata,5,2)."/".substr($mydata,0,4);
  						echo $brdata;
  						?></td>
  						<td><?
  						$mydata=$linha['data_termino'];
						$brdata = substr($mydata,8,2)."/".substr($mydata,5,2)."/".substr($mydata,0,4);
  						echo $brdata;
  						
  						?></td>
  						<td><?$sit=$linha['situacao_estagio'];if($sit==0){echo "";}elseif($sit == 1){echo "ANDAMENTO";}elseif($sit == 2){echo "CONCLUIDO";}elseif($sit==3){echo "PENDENTE";}elseif($sit==4){echo "CANCELADO";}?></td>

  					</tr>
						<?
						$controlador+=1;

				}while ($linha = @mysqli_fetch_assoc($resultado) and $controlador <30);
					# code...
				?></table><?
			}
				else{
					?><p></p><?
					echo "Nenhum estagio localizado!";
				}
			 ?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="relatorio_aluno.php" name="msgdestino"/>
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
