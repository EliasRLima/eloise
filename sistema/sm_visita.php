
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
	$descrelatorio="Buscar visita";


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


$(document).ready(function(){

		$("#DataV").mask('00/00/0000');
		

}); //.ready


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

			<!-- PAGE CONTENT STARTS -->
			<?if (in_array($_SESSION["loginiwe"],$arSA)   ){?>

		    <div style="width: 100%; height: 450px">
					<h3><b>Busca e edi&ccedil;&atilde;o de visitas:</b></h3>
					</br><h4>Filtrar pela data:</h4>  
		   			<form name="formNomeBusca" method="POST" action="relatorio_visita.php" style="">
								<input type="hidden" name="tipo_filtro" id="tipo_filtro" value="1"/>
								<input style="width:80%;margin:3px;" type="text" name="DataV" id="DataV" placeholder="00/00/0000"></input><input style="width:15%;" class="btn btn-success btn-lg" type="submit" name="button" id="button" value="Buscar"/>
												

					</form>
					</br><h4>Filtrar pelo supervisor:</h4>  
		   			<form name="formNomeBusca" method="POST" action="relatorio_visita.php" style="">
								<input type="hidden" name="tipo_filtro" id="tipo_filtro" value="2"/>
								<input style="width:80%;margin:3px;" type="text" name="NomeS" id="NomeS" placeholder="Digite o nome do supervisor"></input><input style="width:15%;" class="btn btn-success btn-lg" type="submit" name="button" id="button" value="Buscar"/>
												

					</form>
			</div>

		    <!-- PAGE CONTENT ENDS -->
			<?}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}?>

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

