
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

			 //echo "Curso: ".$_POST['CursoRE']." Estagiario: ".$_POST['est_string']." Empresa: ".$_POST['emp_string']." Servidor: ".$_POST['serv_string'];exit();

			 $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");


			 $auxE = 0;
			 $estagio  = "select id, (select nome from pessoa where estagio.empresa_id = pessoa.id) as empresa,(select nome from pessoa where pessoa.id = estagiario_id) as estagiario, (select nome from pessoa where estagio.servidor_id = pessoa.id) as servidor, (select sigla from agente where estagio.agente_id = agente.id) as agente, coeficiente, matricula, tipo_pne, ano_diploma, situacao_estagio, data_inicio, data_termino, data_distrato, data_prorrogado, data_estagioavaliado, numero_termo, carga_horario, lista_telefones from estagio ";
			if(isset($_POST['CursoRE']) and $_POST['CursoRE'] != "" and $_POST['CursoRE'] != null ){
				if($auxE==0){
					$estagio .=" where";
				}
				$estagio .=  " estagiario_id in (select id from pessoa where curso_id = ".$_POST['CursoRE'].")";
				$auxE = 1;
			}
			if(isset($_POST['est_string']) and $_POST['est_string'] != "" and $_POST['est_string'] != null){
				if($auxE==0){
					$estagio .= " where";
				}
				elseif($auxE==1){
					$estagio .= " and";
				}
				$estagio .= " estagiario_id in (select id from pessoa where nome like '%".$_POST['est_string']."%' and tipo_papel=3)";
				$auxE = 1;
			}
			if(isset($_POST['emp_string']) and $_POST['emp_string'] != "" and $_POST['emp_string'] != null){
				if($auxE==0){
					$estagio .= " where";
				}
				elseif($auxE==1){
					$estagio .= " and";
				}
				$estagio .= " empresa_id in (select id from pessoa where nome like '%".$_POST['emp_string']."%' or nome_fantasia like '%".$_POST['emp_string']."%' and tipo_papel=2)";
				$auxE = 1;
			}
			if(isset($_POST['serv_string']) and $_POST['serv_string'] != "" and $_POST['serv_string'] != null){
				if($auxE==0){
					$estagio .= " where";
				}
				elseif($auxE==1){
					$estagio .= " and";
				}
				$estagio .= " servidor_id in (select id from pessoa where nome like '%".$_POST['serv_string']."%' and tipo_papel=1)";
				$auxE = 1;
			}

			$estagio .= ";";

			//echo $estagio; exit();

				$resultadoE = @mysqli_query($link,$estagio);
				$num_rowsE = @mysqli_num_rows($resultadoE);
				$linhaE = @mysqli_fetch_assoc($resultadoE);

				if($num_rowsE > 0) {
					?>
					<h3>Foram localizados <?=$num_rowsE?> estagios!</h3>
					<table  style="width:100%">
					<tr>
						<th>ID</th>
						<th>EMPRESA</th>
						<th>ESTAGIARIO</th>
						<th>SERVIDOR</th>
						<th>SITUACAO</th>
					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
					?>	
						<p>
								<tr>

									<td><?=$linhaE['id']?></td>
									<td><?=$linhaE['empresa']?></td>
									<td><?=$linhaE['estagiario']?></td>
									<td><?=$linhaE['servidor']?></td>
									<td><?
											if($linhaE['situacao_estagio']==0){ echo ""; }
		            						elseif($linhaE['situacao_estagio']==1){ echo "ANDAMENTO"; }
		            						elseif($linhaE['situacao_estagio']==2){ echo "CONCLUIDO"; }
		            						elseif($linhaE['situacao_estagio']==3){ echo "PENDENTE"; }
		            						elseif($linhaE['situacao_estagio']==4){ echo "CANCELADO"; }?>
		            				</td>
								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linhaE = @mysqli_fetch_assoc($resultadoE));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio nao localizado";?><br></br><?
					}
			 ?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="sm_estagio.php" name="msgdestino"/>
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
