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
 *      edi_empresa.php
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
	$action = "classes/upd_visita.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="EDITAR visita";	
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
			,descricao
			,data_visita
			,local_visita
			,horario
			,supervisor		
			";

	//preservar a ordem do array
	//em funcao dos desvios ifs
	//das rotinas $gui->renderX
	$arInputLabNome = array(
						
							"Descri&ccedil;&atilde;o da visita"=>"descricao"
							,"Data da visita"=>"data_visita"
							,"Local da visita"=>"local_visita"
							,"Hor&aacute;rio da visita"=>"horario"
							,"Supervisor"=>"supervisor"

							
					);		




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


	$qp = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="visita", $tipoMetodo=2, $filtro=$extra, $viewsql=0);


	$mydata=$qp['data_visita'];
	$brdata = substr($mydata,8,2)."/".substr($mydata,5,2)."/".substr($mydata,0,4);
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




?>

<script>


$(document).ready(function(){


		//telefones
		$(function(){


		
			var campos_max          = 10;   //max de 10 campos
	        var x = 1; // campos iniciais
	        $('#add_field').click (function(e) {
                e.preventDefault();     //prevenir novos clicks
                if (x < campos_max) {
                        $('#listas').append('<div id="row">\
                        					   <div  class="col-xs-12 col-sm-12">\
											   <div id="listas" class="input-group input-group-lg">\
												<input name="telefones[]" id="telefones" value="" placeholder="Telefones" size="40" maxlength="255" type="text" />\
                                <a href="#" class="remover_campo">\
                                <i class="fa fa-times red fa-lg"></i>\
                                </a>\
                                </div><hr>\
                                </div>\
                                </div>'

                                );


                        	


                        x++;
                }
	        });



		    // Remover o div anterior
	        $('#listas').on("click",".remover_campo",function(e) {
	                e.preventDefault();
	                $(this).parent('div').remove();
	                x--;
	        });   


		});
		//.telefones


		//hack
		$(function() {
		  var pessoas = <?php if (file_exists("ax_pessoa.php")) require("ax_pessoa.php"); else echo "Contato(s) n&atilde;o encontrado(s)!"; ?>
		  $("#aux_pessoa_id").autocomplete({
		    source: pessoas,

		    select: function (event, ui) {
				 var op = 1;
				 var nmp = ui.item.value;
				 

				 				$.ajax({
				                        type: "get"
				                        , url: "ax_id.php"
				                        , data: "nmp="+nmp+"+&op="+op				                       
				                        , beforeSend: function(){
				                        } 
				                        , complete: function(){ 

				                        }  				                        
				                        , success: function(data){ 
				                           $("#divpessoaid").html(data);
				                           
				                        }                     
				             		
				                        , error: function(){ 
				                        }  
				            
				                   }); //.ajax


			    } //.select

			//,selectFirst:true

		  
		  });

		});
		//.hack


		//exibir-telefones
		  
		  $(window).load(function () {
		  		 var op = 1;
				 var id = <?php echo $id; ?>;
				 //alert(nmp) ; 
				 
				 				$.ajax({
				                        type: "get"
				                        , url: "ax_telefones.php"
				                        , data: "id="+id+"+&op="+op				                       
				                        , beforeSend: function(){
				                        } 
				                        , complete: function(){ 

				                        }  				                        
				                        , success: function(data){ 
				                           $("#exibir-telefones").html(data);
				                           
				                        }                     
				             		
				                        , error: function(){ 
				                        }  
				            
				                   }); //.ajax


			    }); //.click
			//.exibir-telefones



		$("#data_visita").mask('00/00/0000');
		
		$(window).load(function(){

			$("#divpessoaid").append('<input type="hidden" id="_pessoa_id" name="_pessoa_id" value="<?php echo $qc['id']; ?>"/>');

			
				
		});




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

			<form class="form-search" action='<?=$action ?>' method="post"	enctype="multipart/form-data" name="formcadusuario">
				
				
				
				<?php 

				if (in_array($_SESSION["loginiwe"],$arSA)   ){
				
				//laco de renderizacao dos elementos html

				foreach ($arInputLabNome as $lab=>$nm) {
												
						$ph = $lab;

						$mxl="255";
						if($nm=="data_visita") $ph="DD/MM/AAAA";
						
						

						if($nm=="data_visita"){

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
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
							}elseif($nm=="descricao"){

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
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
							}elseif($nm=="local_visita"){

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['local_visita']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );
							}elseif($nm=="horario"){

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['horario']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );
							}elseif($nm=="supervisor"){

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['supervisor']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );
						
							}else{ 

									echo $gui->renderStatico( $label=$lab
															   ,$tag="input"
															   ,$class="form-control search-query"
															   ,$id=$nm
															   ,$name=$nm
															   ,$value
															   ,$placeholder=$ph
															   ,$icoclass="ace-icon fa fa-credit-card"
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$evento
															  );


							}


						}

				
				
				?>
			
				<div id="divpessoaid">
					<?php //busca arquivo que troca nome por id ?>
				</div><!-- .divpessoaid -->
				

				</div>
				<?
				$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				$queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
				$qdata = @mysqli_query($link,$queryd);
				$num_rows_data = @mysqli_num_rows($qdata);
				$data = @mysqli_fetch_assoc($qdata);
				$data_atualizacao_cadastro = $data['ano']."-".$data['mes']."-".$data['dia'];
				//echo "=>".$data_cadastro;exit();

				?>

				<input type="hidden" name="id" value="<?php echo $qp['id']; ?>"/>

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
			<?}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}?>
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