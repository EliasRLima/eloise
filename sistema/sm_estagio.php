
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
	$descrelatorio="relatorio de estagio";


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
		<div class="widget-main" style="height: 750px;">

			<h3><b>Buscar por estagio</b></h3>  
		   					<form name="formEstagio" method="POST" action="relatorio_estagio.php">
		    									<p>Utilize os campos para tentar localizar um grupo ou um estagio especifico:</p>
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
												<Label>Estagi&aacute;rio:</label><br><input style="width:80%;" type="text" name="est_string" value="" placeholder="Filtrar pelo nome do estagiario"/></br>
  												<Label>Empresa:</label><br><input style="width:80%;" type="text" name="emp_string" value="" placeholder="Filtrar pelo nome da empresa"/></br>
  												
  												<Label>Servidor:</label><br><input style="width:80%;" type="text" name="serv_string" value="" placeholder="Filtrar pelo nome do servidor"/></br>
												</p>
												<input style="width:75%;" class="btn btn-success btn-lg" type="submit" name="buscar" id="button_buscar" value="Buscar"/>

							</form>

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

