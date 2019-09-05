
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
		<div class="widget-main" style="margin: 0;border: 0; width:100%;">
			<div style="width:100%;">

		   			<div style="height:720px;width: 101%">
							<h3><b>Relat&oacute;rio por turma:</b></h3>  
		   					<form name="formEstagio" method="POST" action="relatorio_turma.php">
		   										<label>Ano de conclus&atilde;o previsto:</label><br><?$max = 4;?>
		   										<input style="width:80%;margin:3px;" type="text" name="AnoN" id="AnoN" placeholder="Digite o ano de conclusao" maxlength = "<?=$max?>"></br>
												<?
		    									//$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char, valor_int", $tabela="turma_curso", $chave="curso", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_int asc", $viewsql=0);
		    									
		    									/*echo $gui->renderDinamico( $c
														   ,$label="Turma:"
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id="Turma"
														   ,$name="Turma"
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
														  );*/

												$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char, valor_int", $tabela="curso", $chave="setor_id", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);
		    									
		    									echo $gui->renderDinamico( $c
														   ,$label="Curso:"
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id="Curso"
														   ,$name="Curso"
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

												$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char, valor_int", $tabela="turma_curso", $chave="modalidade", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);
		    									
		    									echo $gui->renderDinamico( $c
														   ,$label="Modalidade:"
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id="Modalidade"
														   ,$name="Modalidade"
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

		    									$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char, valor_int", $tabela="turma_curso", $chave="turno", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);
		    									
		    									echo $gui->renderDinamico( $c
														   ,$label="Turno:"
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id="Turno"
														   ,$name="Turno"
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

		    									$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char, valor_int", $tabela="turma_curso", $chave="sequencia", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_char asc", $viewsql=0);
		    									
		    									echo $gui->renderDinamico( $c
														   ,$label="Caracteristica:"
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id="Sequencia"
														   ,$name="Sequencia"
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
												<!--<br><label>Modalidade</label></br>
												<input type="radio" id="modalidade" nome="modalidade" value="1"/>Integrado
												<br><input type="radio" id="modalidade" nome="modalidade" value="2"/>Concomitante<br>
												<input type="radio" id="modalidade" nome="modalidade" value="3"/>Subsequente
												<br><input type="radio" id="modalidade" nome="modalidade" value="4"/>Superior</br>
												<br><label>Turno</label></br>
												<input type="radio" id="turno" nome="turno" value="1"/>Matutino
												<br><input type="radio" id="turno" nome="turno" value="2"/>Vespertino</br>
												<input type="radio" id="turno" nome="turno" value="3"/>Noturno
												<br><input type="radio" id="turno" nome="turno" value="4"/>Diurno</br>-->

												<input style="width:75%;" class="btn btn-success btn-lg" type="submit" name="buscar" id="button_buscar" value="Gerar"/>

							</form>
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
