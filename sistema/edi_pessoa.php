
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
	$action = "classes/upd_pessoa.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="EDITAR servidor";	
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
			,nome as descricao
			,cadastro
			,sexo
			,telefones		
			,bairro
			,cidade
			,endereco
			,cep
			";

	//preservar a ordem do array
	//em funcao dos desvios ifs
	//das rotinas $gui->renderX
	$arInputLabNome = array(
						
							"Nome"=>"nome"
							//,"Curso"=>"curso_id"
							,"Cadastro de pessoa f&iacute;sica(CPF)"=>"cadastro"
							,"Sexo"=>"sexo"
							,"Endere&ccedil;o"=>"endereco"
							,"Bairro"=>"bairro"
							,"Cidade"=>"cidade"
							,"Cep"=>"cep"
							//,"Data de nascimento"=>"data_nascimento"
							//,"Tipo papel"=>"tipo_papel"
							//aux_pessoa_id eh desviado para pessoa_id na
							//rotina create da classe Crud.
							,"Telefones"=>"telefones"
							//,"Data de cadastro"=>"datacadastro"
							
						
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


	$qp = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro=$extra, $viewsql=0);

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
			  ,nome as descricao	
			  ,id
			  ";
	$extra = "";
	$extra = " id=(select p1.id from pessoa p1 where id=".$id." limit 1)";
			  

	$qc = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro=$extra, $viewsql=0);
	
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
	$qts = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="servidor", $chave="tipo_servidor", $tipoMetodo=0, $filtro="", $orderby="ts.descricao asc",  $viewsql=0);

	$qtc = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="tipo_cadastro", $tipoMetodo=0, $filtro="",  $orderby="ts.descricao desc", $viewsql=0);

	$qtp = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="tipo_papel", $tipoMetodo=0, $filtro="",  $orderby="ts.descricao asc", $viewsql=0);

	$qsx = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="sexo", $tipoMetodo=0, $filtro="",  $orderby="ts.descricao desc", $viewsql=0);

	$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="curso", $chave="id", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);
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



		$("#cadastro").mask('000.000.000-00');
		$("#cep").mask('00000-000');
		$("#data_nascimento").mask('00/00/0000');
		$("#data_atualizacao_cadastro").mask('00/00/0000');
		$("#telefones").mask('99999-9999');
		$("#listas #telefones").mask('99999-9999');
		
		$("#aux_pessoa_id").val('<?php echo $qc['descricao']; ?>');
		
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

						if($nm=="cep") $ph = "00000-000";

						if($nm=="data_nascimento") $ph = "DD/MM/AAAA";
						if($nm=="data_atualizacao_cadastro") $ph="DD/MM/AAAA";
						
						

						if($nm=="data_atualizacao_cadastro"){

								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
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
						
							else{ //$gui->renderStatico renderiza
							   // os campos genericos ou daqueles 
							   //que nao precisam de laco

							if($nm=="cadastro") {


								$ph = "CPF"; 
								$mxl="20"; //inclui mascaras


								
							}

							if($nm=='telefones'){

								//TODO: carregar os telefones via ajax e exibir com
								//opcao de exclusao. Efetivar somente se clicar o botao atualizar

								?>							

								<span class='middle' id="ico-tels">
								<i class="ace-ico fa fa-phone-square"></i>
								<?php echo $lab.":"; ?>
								</span>	
								<div id="row">
            					   <div id="listas" class="col-xs-12 col-sm-12">
								   <div class="input-group input-group-lg">
									<span class="input-group-addon">
									<i class="fa fa-plus-square fa-lg green" id="add_field"></i>
									<a href="#" class="remover_campo">
                    				</a>
									</span>
                    				<input class="form-control search-query" name="telefones[]" id="telefones" value="" placeholder="Telefones" size="40" maxlength="255" type="text" />
                                
                                </div>
                                <div id="row">
            					   <div id="exibir-telefones">Nenhum telefone cadastrado</div>
                                
                                </div>
                                <hr>
                                </div>
                                </div>
								<div id="listas">
									<?php //telefones ?>
								</div>

								<?php
								

							}else{


								if($nm=="nome"){

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
								}elseif($nm=="sexo"){
						
							echo $gui->renderDinamico( 	    $c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class=""
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$qp['sexo']
														   ,$placeholder=$ph
														   ,$icoclass=""
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qsx
														   ,$tipoiteracao=1 //radio
														   ,$utf8=0
														   ,$evento=""
														  );	

						}elseif($nm=="cadastro"){

									echo $gui->renderStatico( $label=$lab
															   ,$tag="input"
															   ,$class="form-control search-query"
															   ,$id=$nm
															   ,$name=$nm
															   ,$value=$qp['cadastro']
															   ,$placeholder=$ph
															   ,$icoclass="ace-icon fa fa-credit-card"
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$evento
															  );


								}elseif($nm=="endereco"){

									echo $gui->renderStatico( $label=$lab
															   ,$tag="input"
															   ,$class="form-control search-query"
															   ,$id=$nm
															   ,$name=$nm
															   ,$value=$qp['endereco']
															   ,$placeholder=$ph
															   ,$icoclass="ace-icon fa fa-credit-card"
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$evento
															  );


								}elseif($nm=="bairro"){

									echo $gui->renderStatico( $label=$lab
															   ,$tag="input"
															   ,$class="form-control search-query"
															   ,$id=$nm
															   ,$name=$nm
															   ,$value=$qp['bairro']
															   ,$placeholder=$ph
															   ,$icoclass="ace-icon fa fa-credit-card"
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$evento
															  );


								}elseif($nm=="cidade"){

									echo $gui->renderStatico( $label=$lab
															   ,$tag="input"
															   ,$class="form-control search-query"
															   ,$id=$nm
															   ,$name=$nm
															   ,$value=$qp['cidade']
															   ,$placeholder=$ph
															   ,$icoclass="ace-icon fa fa-credit-card"
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$evento
															  );


								}elseif($nm=="cep"){

									echo $gui->renderStatico( $label=$lab
															   ,$tag="input"
															   ,$class="form-control search-query"
															   ,$id=$nm
															   ,$name=$nm
															   ,$value=$qp['cep']
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


						}
				}

				
				}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
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
				$data_cadastro = $data['ano']."-".$data['mes']."-".$data['dia'];
				//echo "=>".$data_cadastro;exit();

				?>
				<input type="hidden" name="data_cadastro" value="<?=$data_atualizacao_cadastro?>"/>
				<input type="hidden" name="tipo_papel" value="1"/>
				<input type="hidden" name="id" value="<?php echo $qp['id']; ?>"/>

				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="<?php echo  $lbbtnsubmit; ?>" value="Atualizar"/>
							<a href="seletora.php?url=eJyLT8vMKSnKtzXWiS9ILEjNsTUEAD%2FqBms%3D" name="msgdestino"/>
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
