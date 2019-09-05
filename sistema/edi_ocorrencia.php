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
	//TODO:Controle de permissoes
	//----------------------------------------------------------------------------



	//----------------------------------------------------------------------------
	$nr = new Normalizadora();

	//instancia para os combos e check
	$c = new comunicadora();

	$crud = new Crud(); 
	
	$gui = new Gui(); 
	
	$cpessoa = new CPessoa(); 	
	$action = "classes/upd_ocorrencia.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="Ocorr&ecirc;ncia";	
	$lbbtnsubmit="Atualizar";


//.CONFIGURACOES BASICAS

//MENU

include ('../static/layout/layout_menu_nav.php');

//.MENU

//CONTEUDO 




?>

    
<?php //require "../static/layout/estilos.html";?>   
     
<?php //require "../static/layout/scripts.html";?>

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
 	

	if (isset($_GET['al']) && isset($_GET['msg']))

		echo $inf->nav_notificacao( $al=$_GET['al'] 
									,$msg
							        ,$classmsg= "alert alert-danger"				
							  		,$href="#"
							  		,$txtHef=""		
							  		,$header="#"
							 	  );

//./NOFIFICACAO





	$inf->doDecodifica($_GET['url']);

	$tuplas ="
			 id				  
			  ,(select nome from pessoa where o.estagiario_id = id) as estagiario	
			  ,(select nome from pessoa where o.servidor_id = id) as servidor
			  ,descricao
			  ,data_ocorrencia	
			";

	//preservar a ordem do array
	//em funcao dos desvios ifs
	//das rotinas $gui->renderX
	$arInputLabNome = array(
						
							"Estagiario"=>"estagiario_id"
							,"Servidor"=>"servidor_id"
							,"Descricao"=>"descricao"
							,"Data da ocorr&ecirc;ncia"=>"data_ocorrencia"
							,"Tipo ocorr&ecirc;ncia"=>"tipo_ocorrencia"	

							
					);		


	$id = $_GET['_id']; //echo "=>".$id; exit;

	$extra = " id=".$id;

	//readPessoaLine
	//$c: conexao;
	//$crud: ;
	//$colunas: ;
	//$tabela: ;
	//$tipoMetodo:  0 - returns set;
	//$tipoMetodo:  1 - returns total row;
	//$tipoMetodo:  2 - returns line - usage: $var_array[<index_array>];
	//$tipoMetodo:  3 - returns instrucao sql;
	//$filtro:  DEFAULT: $filtro="". Instrucao sql livre para concatenar no final de $intrucao;
	//$viewsql: 0 - oculta sql; 1 - exibe sql


	$qp = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="ocorrencia o", $tipoMetodo=2, $filtro=$extra, $viewsql=0);

	$qest = $cpessoa->readPessoa($c, $crud, $colunas="id", $tabela="estagio", $tipoMetodo=2, $filtro="estagiario_id=$id", $viewsql=0);


	$arFiltro = array(
						"_filtro="=>$qp[tipo_cadastro]
						,",_papel="=>$qp[tipo_papel]
						,",_idretorno="=>$id
						,",_id="=>$qest[id] 	 
						
					  );
	
	//rota
	//$arFiltro: Filtro com os filtros. Ex.: "_filtro="=>99",",_papel="=>5
	//$viewFiltro: 0: default; 1: exibe sem cryptografia
	//returns: url criptografada
	$msgdestino = $inf->rota($arFiltro,$destino="seletora.php?url=", $viewCaminho=0);


	
	//autorelacionamento
	$tuplas = "
			  id				  
			  ,(select nome from pessoa where o.estagiario_id = id) as estagiario	
			  ,(select nome from pessoa where o.servidor_id = id) as servidor
			  ,descricao
			  ,data_ocorrencia
			  ";
	$extra = "";
	$extra = " id=(select p1.id from pessoa p1 where id=".$id." limit 1)";
			  

	$qc = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="ocorrencia o", $tipoMetodo=2, $filtro=$extra, $viewsql=0);
	
	//.autorelacionamento


	//readTipoSituacao
	//$c: conexao;
	//$colunas para clausula select;
	//$tabela: tabela da relacao com tipo_situacao;
	//$chave: tipo_<[servidor; pessoa; estagiario;...]>;
	//$tipoMetodo:  0 - returns set;
	//$tipoMetodo:  1 - returns total row;
	//$tipoMetodo:  2 - returns line - usage: $var_array[<index_array>];
	//$tipoMetodo:  3 - returns instrucao sql;
	//$viewsql: 0 - oculta sql; 1 - exibe sql
	$qoc = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="ocorrencia", $chave="tipo", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);

	//https://www.w3schools.com/jquery/jquery_syntax.asp
	//You might have noticed that all jQuery methods in our examples, are inside a document ready event:
	// More Examples of jQuery Selectors
	// Syntax 						Description 	
	// $("*")						Selects all elements						
	// $(this)						Selects the current HTML element 	
	// $("p.intro") 				Selects all <p> elements with class="intro" 	
	// $("p:first") 				Selects the first <p> element 	
	// $("ul li:first") 			Selects the first <li> element of the first <ul> 	
	// $("ul li:first-child") 		Selects the first <li> element of every <ul> 	
	// $("[href]") 					Selects all elements with an href attribute 	
	// $("a[target='_blank']") 		Selects all <a> elements with a target attribute value equal to "_blank" 	
	// $("a[target!='_blank']") 	Selects all <a> elements with a target attribute value NOT equal to "_blank" 	
	// $(":button") 				Selects all <button> elements and <input> elements of type="button" 	
	// $("tr:even") 				Selects all even <tr> elements 	
	// $("tr:odd") 					Selects all odd <tr> elements

	// MouseEvents	 					Keyboard Events 	Form Events 	Document/Window Events
	// click 							keypress			submit			load
	// dblclick 						keydown				change			resize
	// mouseenter 						keyup				focus			scroll
	// mouseleave 	  					blur				unload

	// For versions of jQuery prior to (<) 1.6, use:

	// $("#radio_1").attr('checked', 'checked');

	// For versions equal or above (>=) 1.6, use:

	// $("#radio_1").prop("checked", true)

	$mydata=$qp['data_ocorrencia'];
	$brdata = substr($mydata,8,2)."/".substr($mydata,5,2)."/".substr($mydata,0,4);

?>

<script>


$(document).ready(function(){

		$("#data_ocorrencia").mask('00/00/0000');
		

}); //.ready


</script>


<div class="page-header">
    <h1>
        <? echo $descrelatorio;?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo "Editar ".$descrelatorio;?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">

			<form class="form-search" action='<?=$action ?>' method="post"	enctype="multipart/form-data" name="formcadusuario">
				
				
				
				<?php 
				
				if (in_array($_SESSION["loginiwe"],$arSA)   ){
				
				
				//laco de renderizacao dos elementos html

				foreach ($arInputLabNome as $lab=>$nm) {
												
						$ph = $lab;

						$mxl="255";					
						

						if($nm=="estagiario_id"){

							echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['estagiario']
														   ,$placeholder="Nome completo do estagi&aacute;rio"
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );		
							}elseif($nm=="servidor_id"){
						
							echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['servidor']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );

						}elseif($nm=="descricao"){
						
							echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['descricao']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );

						}elseif($nm=="data_ocorrencia"){
						
							echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$brdata
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );

						}elseif($nm=="tipo_ocorrencia"){
						
							echo $gui->renderDinamico( 	    $c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value="-1"
														   ,$placeholder="expandir"
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qoc
														   ,$tipoiteracao=1 //select
														   ,$utf8=0
														   ,$evento=""
														  );

						}else{ //$gui->renderStatico renderiza
							   // os campos genericos ou daqueles 
							   //que nao precisam de laco

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=""
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );
							}
				}

				
				}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
				?>
			
				<div id="divpessoaid">
					<?php //busca arquivo que troca nome por id ?>
				</div><!-- .divpessoaid -->
				

				</div>
				<input type="hidden" name="id_ocorrencia" value="<?=$qp['id']?>"/>

				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="<?php echo  $lbbtnsubmit; ?>" value="Atualizar"/>
							<a href="seletora.php?url=eJyLT8vMKSnKtzXRiS9ILEjNsTUBAD%2F3Bm8%3D" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Voltar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>

					<input type="hidden" name="datacadastro"/>
					<input type="hidden" name="horacadastro" />
					
			</form>

		</div><!-- widget-main -->
	</div><!-- widget-body -->
</div>	<!-- ./widget-box -->


    <!-- PAGE CONTENT ENDS -->
</div><!-- /.cols -->
<?php include ('../static/layout/layout_fcontent.php');  ?>

<?php

//RODAPE

include ('../static/layout/footer_fhtml.html'); 

//.RODAPE


?>
<script src="../static/layout/assets/js/jquery.mask.min.js"></script>