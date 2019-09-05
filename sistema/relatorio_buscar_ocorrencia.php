
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
			  $string = $_POST['OcoN'];
			  $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				
				//query para buscar estagios
				$query = "select o.id, o.descricao, (select descricao from tipo_situacao where o.tipo_ocorrencia = valor_char and nome_tabela = 'ocorrencia' and nome_coluna = 'tipo') as tipo, (select nome from pessoa where id = o.servidor_id limit 1) as servidor, (select nome from pessoa where id = o.estagiario_id limit 1) as estagiario, o.data_ocorrencia from ocorrencia o where (select matricula from pessoa where id = o.estagiario_id) like '".$string."' order by o.tipo_ocorrencia asc";

				//echo $query;exit();
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
						<h3>Numero de ocorr&ecirc;ncias localizadas: <?echo $num_rows;?></h3>
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
  			 			 <th>Estagi&aacute;rio</th>
   			 			 <th>Ocorr&ecirc;ncia</th>
   			 			 <th>Situa&ccedil;&atilde;o</th>
   			 			 <th>Servidor</th>
   			 			 <th>Data da ocorr&ecirc;ncia</th>
  					</tr> <?
  					$controlador = 0;
				do {
					?>
  					<tr>
  						<td style="display: flex;flex-direction: row;justify-content: center;align-items: center;">

            				<?php $url="_id=".$linha['id'];?>
  							<a href="edi_ocorrencia.php?url=<?php echo $inf->doCodifica($url)?>" name="msgdestino"/>
								<i class="ace-icon fa fa-pencil" style="color: black;height:20px;"></i>

						</td>
  						<td><?=$linha['estagiario']?></td>
  						<td><?=$linha['descricao']?></td>
  						<td><?=$linha['tipo']?></td>
  						<td><?=$linha['servidor']?></td>
  						<td><?
  							$mydata=$linha['data_ocorrencia'];
							$brdata = substr($mydata,8,2)."/".substr($mydata,5,2)."/".substr($mydata,0,4);
							echo $brdata;
						?></td>			
  					</tr>
						<?
						$controlador+=1;

				}while ($linha = @mysqli_fetch_assoc($resultado) and $controlador <30);
					# code...
				?></table><?
			}
				else{
					?><p></p><?
					echo "Aluno nao localizado!";
				}
			 }else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
			 ?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="sm_ocorrencia.php" name="msgdestino"/>
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
