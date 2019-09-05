
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
 *      cad_pessoa.php
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

	$action = "classes/ins_pessoa.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="Cadastrar";


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
									,$msg//=$_GET['msg']
							        ,$classmsg= "alert alert-danger"				
							  		,$href="#"
							  		,$txtHef=""		
							  		,$header="#"
							 	  );

//./NOFIFICACAO



//readPessoaLine
//$c: conexao;
//$crud: ;
//$colunas: ;
//$tabela: tabela da relacao com tipo_situacao;
//$tipoMetodo:  0 - returns set;
//$tipoMetodo:  1 - returns total row;
//$tipoMetodo:  2 - returns line - usage: $var_array[<index_array>];
//$tipoMetodo:  3 - returns instrucao sql;
//$filtro:  DEFAULT: $filtro="". Instrucao sql livre para concatenar no final de $intrucao;
//$viewsql: 0 - oculta sql; 1 - exibe sql
//IN(1 - FISICA, 2 - JURIDICA)
$qp = $cpessoa->readPessoa($c, $crud, $colunas="id, nome as descricao, cadastro", $tabela="pessoa", $tipoMetodo=0, $filtro="tipo_cadastro IN (1,2)", $viewsql=0);

//readTipoSituacao
//$c: conexao;
//$colunas para clausula select;
//$tabela;
//$chave: tipo_<[servidor; pessoa; estagiario;...]>;
//$tipoMetodo:  0 - returns set;
//$tipoMetodo:  1 - returns total row;
//$tipoMetodo:  2 - returns line - usage: $var_array[<index_array>];
//$tipoMetodo:  3 - returns instrucao sql;
//$filtro:  ja incluido o and
//$viewsql: 0 - oculta sql; 1 - exibe sql



$qts = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="servidor", $chave="tipo_servidor", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc",  $viewsql=0);

$qtc = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="tipo_cadastro", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao desc", $viewsql=0);

$qtp = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="tipo_papel", $tipoMetodo=0, $filtro="ativo=1 and valor_char not in(4) and descricao!='EMPRESA'", $orderby="ts.descricao asc", $viewsql=0);

$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="turma_curso", $chave="curso", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);

$qsx = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char, valor_int", $tabela="pessoa", $chave="sexo", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_int desc", $viewsql=0);

$qpne = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="estagio", $chave="tipo_pne", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);

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

<?php //if (file_exists("ax_pessoa.php")) require("ax_pessoa.php"); exit;?>



<script>


$(document).ready(function(){


		//telefones
		$(function(){


		
			var campos_max          = 5;   //max de 10 campos
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
				 //alert( $("#pessoa_id").val(ui.item.value).val() ) ; 
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



		$("#cadastro").mask('000.000.000-00');
		$("#cep").mask('00000-000');
		$("#data_nascimento").mask('00/00/0000');
		$("#data_cadastro").mask('00/00/0000');
		$("#data_atualizacao").mask('00/00/0000');
		$("#telefones").mask('99999-9999');
		$("#listas #telefones").mask('99999-9999');
		$("#matricula").mask('999999999999');
		

}); //.ready


</script>



<div class="page-header">
    <h1>
        <? echo $descrelatorio;?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo "Insira os dados do aluno";?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">

			<form class="form-search" action='<?=$action ?>' method="post"	enctype="multipart/form-data" name="formcadusuario">
				<?php 
				if (in_array($_SESSION["loginiwe"],$arSA)   ){
				//preservar a ordem do array
				//em funcao dos desvios ifs
				//das rotinas $gui->renderX
				$arInputLabNome = array(
									
										"Matricula"=>"matricula"
										,"Nome"=>"nome"
										,"Turma"=>"turma_curso"
										,"Cadastro de pessoa f&iacute;sica(CPF)"=>"cadastro"
										,"Sexo"=>"sexo"
										,"Endere&ccedil;o"=>"endereco"
										,"Bairro"=>"bairro"
										,"Cidade"=>"cidade"
										,"Cep"=>"cep"
										,"Data de nascimento"=>"data_nascimento"
										//"Tipo papel"=>"tipo_papel"
										,"Telefones"=>"telefones"
										,"Email"=>"email"
										,"Necessidade especial"=>"pne"
										//,"tipo de cadastro"=>"tipo_cadastro"
										
								);	

				
				//laco de renderizacao dos elementos html

				foreach ($arInputLabNome as $lab=>$nm) {
					
						$ph = $lab;
						$tipoP = "text";
						$mxl="255";

						if($nm=="cep") $ph = "00000-000";
						if($nm=="data_nascimento") $ph = "DD/MM/AAAA";
						if($nm=="data_cadastro") $ph="DD/MM/AAAA";


						if($nm=="turma_curso"){

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
														   ,$iteracao=$qtr
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );	
							}elseif($nm=="pne"){

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
														   ,$iteracao=$qpne
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );	
							}elseif($nm=="aux_pessoa_id"){

							//$nm="pessoa_id";	
							//0: para dezativar autocomplete
							$autocomplete =1;
							
							if($autocomplete){

								$ph = "Digite um nome para pesquisar";
								
								echo $gui->renderStatico( $label=$lab
														   ,$tag="input style='border:solid 1px #87B87F;'"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=""
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-search"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );
							}else{

								echo $gui->renderDinamico( 	    $c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=""
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qp
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );	

							}

						}elseif($nm=="sexo"){
						
							echo $gui->renderDinamico( 	    $c //modo_rolamento
														   ,$label=$lab //nome
														   ,$tag="select"
														   ,$class=""
														   ,$id=$nm
														   ,$name=$nm
														   ,$value="-1"
														   ,$placeholder=$ph
														   ,$icoclass=""
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qsx
														   ,$tipoiteracao=1 //radio //2 escolhas
														   ,$utf8=0
														   ,$evento=""
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

								?>							

								<span class='middle'>
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
                    				<input class="form-control search-query" name="telefones[]" id="telefones" value="" placeholder="Telefones" size="45" maxlength="255" type="text" />
                                
                                </div>
                                <hr>
                                </div>
                                </div>
								<div id="listas">
									<?php //telefones ?>
								</div>

								<?php
								

							}
							else{	echo $gui->renderStatico( $label=$lab
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
				}
				
				}else{echo "Sistema anti-link SVTR_ foi bem ativado!";}
				?>
			
				<div id="divpessoaid">
					<?php //busca arquivo que troca nome por id ?>
				</div>


				

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
				<input type="hidden" name="data_cadastro" value="<?=$data_cadastro?>"/>
				<input type="hidden" name="tipo_papel" value="3"/>
				<input type="hidden" name="tipo_cadastro" value=""/>

				<?if (in_array($_SESSION["loginiwe"],$arSA)   ){?>
				
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="cadastrar" value="Cadastrar"/>							
						</div>
					</div>
				</div>
				<?}?>
					
					
					<input type="hidden" name="msgdestino" value="../sistema/cad_aluno.php"/>
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
