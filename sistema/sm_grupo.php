
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
	$descrelatorio="Buscar grupo de aluno";


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
		<h5 class="widget-title lighter"><?php echo $descrelatorio;?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">

			<div style="height:280px;width:100%">
						<h3><b>Buscar grupo de alunos</b></h3>  
		   					<form name="formGrupoALuno" method="POST" action="relatorio_alunos.php">
		    									<p>
		    									<?
		    									$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="curso", $chave="setor_id", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);
		    									
		    									echo $gui->renderDinamico( $c
														   ,$label="Curso:"
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id="CursoRE"
														   ,$name="CursoRE"
														   ,$value=""
														   ,$placeholder="expandir"
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="20"
														   ,$maxlength=255
														   ,$iteracao=$qtr
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );
		    									?>

							<!-- </form>
		   					<form name="formRelatorioComEstagio" method="POST" action="relatorio_aluno_candidato_maior.php"> -->
												<!--<input type="radio" name="AL" value="1"> Apenas candidatos
  												<input type="radio" name="AL" value="2"> Apenas estagi&aacute;rios
  												<input type="radio" name="AL" value="3"> Apenas egressos sem estagio
  												<input type="radio" name="AL" value="4"> Apenas egressos com estagio-->

												<label><?echo "Filtro:  ";?></label><select name="AL">
													<option value="5">Sem filtro</option>
													<option value="1">Candidatos</option>
													<option value="2">Estagiarios</option>
													<option value="3">Egressos sem estagio</option>
													<option value="4">Egressos com estagio</option>
												</select>
											   <input type="checkbox" name="MIdade" id="MIdade" value="1"/>
												<Label for="MIdade">Maiores de idade</label>
												<input type="checkbox" name="Jap" id="Jap" value="1"/>
												<Label for="Jap">Menores de 24 anos</label>
							<!-- </form>
							<form name="formRelatorioComEstagio" method="POST" action="relatorio_aluno_estagiario_maior.php"> -->
												<br>
												<input type="submit" class="btn btn-success btn-lg" name="gerar" id="gerar" value="Buscar"/>
												</br>
												</p>

												

							</form>
						</div>
			

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

