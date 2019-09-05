
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
	$descrelatorio="Listagem";

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
		<h5 class="widget-title lighter"><?php echo "Ordenado por ano de conclusao";?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">
			
			 <?php
			 $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");

			 $queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
				$qdata = @mysqli_query($link,$queryd);
				$num_rows_data = @mysqli_num_rows($qdata);
				$data = @mysqli_fetch_assoc($qdata);
				$dia = $data['dia'];
				$mes = $data['mes'];
				$ano = $data['ano'];


					//echo "Ano  ".$ano."Mes  ".$mes."Dia  ".$dia; exit();
			 //echo "Curso: ".$_POST['CursoRE']." Maior: ".$_POST['MIdade'];//exit();

			 $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");


			 $query = "select (select 1 from pessoa p where p.id in (select estagiario_id from estagio) and p.id = e.id) as estagiario,nome,(select (select descricao from tipo_situacao where valor_char = CodigoTurma limit 1) from turma_curso where CodigoTurma = e.turma_curso) as curso,ano_conclusao from pessoa e where e.ano_conclusao !='' and e.ano_conclusao != '0000-00-00' and curso_id = ".$_POST['CursoRE']." ";
			 /*if(isset($_POST['MIdade'])){
					$query .= " and data_nascimento between '1968-01-31' and '";
					$query .= $ano;
					$query .="-";
					$query .= $mes;
					$query .="-";
					$query .= $dia;
					$query .="'";
				}*/
				$query .= " order by turma_curso desc, ano_conclusao asc;";

				//echo $query;
				$resultado = @mysqli_query($link,$query);
				$resultadoCont = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				$linhaCont = @mysqli_fetch_assoc($resultadoCont);

				$sem = 0;
				$com = 0;

				if($num_rows > 0) {
					do {
						if($linhaCont['estagiario']=="" or $linhaCont['estagiario']==null){
							$linhaCont['estagiario'] = "Sem estagio";
							$sem += 1;
						}
						elseif($linha['estagiario']=='1'){
							$linhaCont['estagiario'] = "Ja realizou estagio";
							$com += 1;
						}

				// finaliza o loop que vai mostrar os dados
					}while($linhaCont = @mysqli_fetch_assoc($resultadoCont));
					?>
					<table style="width:100%">
								<tr>
									<td style="width:10%"><b>Com estagio: <?=$com?></b></td>
									<td style="width:40%"><b>Sem estagio: <?=$sem?></b></td>
									<td><a href="sm_egressos.php" name="msgdestino"/>
										<button type="button"  class="btn btn-success btn-lg" >
										<i class="ace-icon fa fa-undo bigger-110"></i>Retornar
									</button>
							
									</a></td>
								</tr>

					</table>

					<table  style="width:100%">
					<tr>
						<th>Estagio</th>
						<th>Nome</th>
						<th>Turma - Curso</th>
						<th>Ano de conclusao</th>

					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
						if($linha['estagiario']=="" or $linha['estagiario']==null){
							$linha['estagiario'] = "Sem estagio";
							$sem += 1;
						}
						elseif($linha['estagiario']=='1'){
							$linha['estagiario'] = "Realizou estagio";
							$com += 1;
						}
					?>	
						<p>
								<tr>

									<td><?=$linha['estagiario']?></td>
									<td><?=$linha['nome']?></td>
									<td><?=$linha['curso']?></td>
									<td><?=$linha['ano_conclusao']?></td>

								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio(s) nao foi(foram) localizado(s)";?><br></br>
					<a href="sm_grupo.php" name="msgdestino"/>
						<button type="button"  class="btn btn-success btn-lg" >
							<i class="ace-icon fa fa-undo bigger-110"></i>Retornar
						</button>
							
					</a>
									<?
					}

				?>
				


				
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							
											

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
