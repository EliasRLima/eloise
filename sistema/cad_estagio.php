
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
	//Controle de permissoes
	//----------------------------------------------------------------------------


	$nr = new Normalizadora();

	//----------------------------------------------------------------------------

	//instancia para os combos e check
	$c = new comunicadora();

	$crud = new Crud(); 
	
	$gui = new Gui(); 
	
	$cpessoa = new CPessoa(); 

	$action = "classes/ins_estagio.php";
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
$qp = $cpessoa->readPessoa($c, $crud, $colunas="id, nome as descricao, cadastro", $tabela="pessoa", $tipoMetodo=0, $filtro="", $viewsql=0);

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
$qts = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="servidor", $chave="tipo_servidor", $tipoMetodo=0, $filtro="", $orderby="ts.descricao asc",  $viewsql=0);

$qtc = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="tipo_cadastro", $tipoMetodo=0, $filtro="", $orderby="ts.descricao desc", $viewsql=0);

$qtp = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="tipo_papel", $tipoMetodo=0, $filtro="", $orderby="ts.descricao asc", $viewsql=0);
$qsx = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="pessoa", $chave="sexo", $tipoMetodo=0, $filtro="", $orderby="ts.descricao desc", $viewsql=0);

$qse = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="estagio", $chave="situacao_estagio", $tipoMetodo=0, $filtro="", $orderby="ts.valor_char asc", $viewsql=0);

$qtpne = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="estagio", $chave="tipo_pne", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_char asc", $viewsql=0);

//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
//$c: conexao;
//$metodo: 0 - returns enviar;
//$metodo: 1 - returns row;
//$metodo: 2 - returns fetch;
//$metodo: 2 - returns instrucao sql;
//$viewsql:0 - oculta sql; 1 - exibe sql
//id as valor_char, sigla as descricao adaptacoes para guiRender
$qag = $crud->raw_sql($c, "select id as valor_char, sigla as descricao from agente where ativo=1", $metodo=0, $retorno=1,$viewsql);


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

<?php //if (file_exists("ac_pessoa.php")) require("ac_pessoa.php"); exit;?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
				function mensagem() {

   					var matricula = document.getElementById('estagiario_matricula').value;
   					//document.getElementById('estagiario_nome').innerHTML =  matricula;
        			$.post("Js_aux.php",
        				{
          					name: matricula
        				},
        			function(data,status){
            		if(status == "success"){
            			document.getElementById('estagiario_nome').innerHTML = data;
            			}
            		else{
            			document.getElementById('estagiario_nome').innerHTML = "falha inesperada ao procurar nome";
            		}	
        			});

				}


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

		  var pessoa = <?php if (file_exists("ax_pessoa.php")) require("ax_pessoa.php"); else echo "Contato(s) n&atilde;o encontrado(s)!"; ?>
		  
		  $("#empresa_id").autocomplete({
		    source: pessoa ,

		    select: function (event, ui) {
				var nmp = ui.item.value;
				var op = 3;
				
					$.ajax({
	                        type: "get"
	                        , url: "ax_id.php"
	                        , data: "nmp="+nmp+"&op="+op
	                        , beforeSend: function(){
	                        } 
	                        , complete: function(){ 

	                        }  				                        
	                        , success: function(data){ 
	                           $("#divempresaid").html(data);
	                           
	                        }                     
	             		
	                        , error: function(){ 
	                        }  
	            
	                   }); //.ajax


			    } //.select

			//,selectFirst:true

		  
		  });//.autocomplete

		  $("#servidor_id").autocomplete({
		    source: pessoa ,

		    select: function (event, ui) {
				var nmp = ui.item.value;
				var op = 3;
					$.ajax({
	                        type: "get"
	                        , url: "ax_id.php"
	                        , data: "nmp="+nmp+"&op="+op
	                        , beforeSend: function(){
	                        } 
	                        , complete: function(){ 

	                        }  				                        
	                        , success: function(data){ 
	                           $("#divservidorid").html(data);
	                           
	                        }                     
	             		
	                        , error: function(){ 
	                        }  
	            
	                   }); //.ajax


			    } //.select

			//,selectFirst:true

		  
		  });//.autocomplete

		});
		//.hack



		$("input:radio[id='tipo_cadastro']").filter("[value='1']").click(function () {
			$("#cadastro").val("");	
			$("#cadastro").focus();
			$("#cadastro").mask('000.000.000-00');

		}); //.radio cpf
		$("input:radio[id='tipo_cadastro']").filter("[value='2']").click(function () {
			$("#cadastro").val("");	
			$("#cadastro").focus();
			$("#cadastro").mask('00.000.000/0000-00');

		}); //.radio cnpj

		$("#cep").mask('00000-000');
		$("#data_inicio").mask('00/00/0000');
		
		$("#data_termino").mask('00/00/0000');
		$("#data_distrato").mask('00/00/0000');
		$("#data_prorrogado").mask('00/00/0000');
		$("#data_estagioavaliado").mask('00/00/0000');
		
		$("#telefones").mask('9999-9999');
		$("#listas #telefones").mask('9999-9999');
		

		$("#ano_diploma").bind("keyup blur focus", function(e) {
            e.preventDefault();
            var expre = /[^\d]/g;
            $(this).val($(this).val().replace(expre,''));
        });
        $("#numero_termo").bind("keyup blur focus", function(e) {
            e.preventDefault();
            var expre = /[^\d]/g;
            $(this).val($(this).val().replace(expre,''));
        });
        $("#carga_horario").bind("keyup blur focus", function(e) {
            e.preventDefault();
            var expre = /[^\d]/g;
            $(this).val($(this).val().replace(expre,''));
        });


		//$("#empresa_id").val("");	
		$("#empresa_id").focus();
			
}); //.ready

</script>


<div class="page-header">
    <h1>
        <? echo $descrelatorio;?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo "Insira os dados do est&aacute;gio";?></h5>
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
										//"id"=>"id"
										//"N&uacute;mero do termo"=>"numero_termo"
										
										"Matricula do aluno (estagi&aacute;rio)"=>"estagiario_id"
										,"Empresa"=>"empresa_id"
										,"Carga hor&aacute;ria"=>"carga_horario"
										//,"PNE"=>"tipo_pne"
										//,"Servidor"=>"servidor_id"
										,"Agente de integra&ccedil;&atilde;o"=>"agente_id"										
										,"Situa&ccedil;&atilde;o do Est&aacute;gio"=>"situacao_estagio"
										,"Data de in&iacute;cio"=>"data_inicio"
										,"Data de t&eacute;rmino"=>"data_termino"
										//,"Data do distrato"=>"data_distrato"
										//,"Data prorrogado"=>"data_prorrogado"
										//,"coeficiente"=>"coeficiente"
										//,"Data de est&aacute;gio avaliado"=>"data_estagioavaliado"
										
										
										
										//,"lista_telefones"=>"lista_telefones"										
								);	

				
				//laco de renderizacao dos elementos html
				foreach ($arInputLabNome as $lab=>$nm) {
					
						$ph = $lab;

						$mxl="255";

						if($nm=="cep") $ph = "00000-000";

						if($nm=="data_nascimento") $ph = "DD/MM/AAAA";
						if($nm=="data_inicio") $ph = "DD/MM/AAAA";
						if($nm=="data_termino") $ph = "DD/MM/AAAA";
						if($nm=="data_distrato") $ph = "DD/MM/AAAA";
						if($nm=="data_prorrogado") $ph = "DD/MM/AAAA";
						if($nm=="data_estagioavaliado") $ph = "DD/MM/AAAA";
						
						

						if($nm=="tipo_papel"){
							//adequado para arrays de componentes
							//$c
							//$label
							//$tag
							//$class
							//$id
							//$name
							//$value
							//$placeholder
							//$icoclass
							//$type
							//$size
							//$maxlenth
							//$iteracao: query do banco ou qualquer array para engrenar laco 
							//$tipoiteracao: 0:<select>; 1:<radio> 
							//$utf8: 0:default; 1: forca decodificacao para utf8
							//$evento: para onclick, onkeypress, onkeydown ....Uso: $evento="onkeypress='<sua-funcao-javascript>'"
							//utilizar alias 'id' e 'descricao' para as consultas sql para manter o laço 
							echo $gui->renderDinamico( 	    $c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value="-1"
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qtp
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );	

						}elseif($nm=="empresa_id"){

							
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
														   ,$evento=""
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

						}elseif($nm=="estagiario_id"){

							
							/*echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=""
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="20"
														   ,$maxlength=$mxl
														   ,$evento
														  );*/
							//$lab .= " , Localizado: ";
							$ph = "Digite a matricula";
							?>

							<span class='middle'> <? echo $lab;?></span>		
							<div class='row'>
								<div class='col-xs-12 col-sm-12'>						
									<div id='eloise-render' class='input-group input-group-lg'>
										<span class='input-group-addon'>
											<i class='ace-icon fa fa-credit-card'></i>
										</span>								
										<input class='form-control search-query' name='estagiario_matricula' id='estagiario_matricula' onBlur='mensagem()' placeholder="<?=$ph?>" type='text' size='60' maxlength='$max'></input>
										<b class='form-control search-query' name="estagiario_nome" id="estagiario_nome"></b>
					   				</div>
								</div>
							</div>		
							<hr>
							<?
							/*$mxl = 0;
								$ph = "Digite a matricula para localizar o nome";
								
								echo $gui->renderStatico( $label="Nome do Aluno"
														   ,$tag="input style='border:solid 1px #87B87F;'"
														   ,$class="form-control search-query"
														   ,$id="estagiario_nome"
														   ,$name="estagiario_nome"
														   ,$value=""
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-search"
														   ,$type="text"
														   ,$size="40"
														   ,$maxlength=$mxl
														   ,$evento=""
														  );*/

						}elseif($nm=="agente_id"){

							
							//0: para dezativar autocomplete
							$autocomplete =0;
							
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
															   ,$class=""
															   ,$id=$nm
															   ,$name=$nm
															   ,$value="-1"
															   ,$placeholder=$ph
															   ,$icoclass=""
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$iteracao=$qag
															   ,$tipoiteracao=0 //0:select;1:radio
															   ,$utf8=0
															   ,$evento=""
															  );	
							}

						}elseif($nm=="situacao_estagio"){

							
							//0: para dezativar autocomplete
							$autocomplete =0;
							
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
															   ,$class=""
															   ,$id=$nm
															   ,$name=$nm
															   ,$value="-1"
															   ,$placeholder=$ph
															   ,$icoclass=""
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$iteracao=$qse
															   ,$tipoiteracao=0 //0:select;1:radio
															   ,$utf8=0
															   ,$evento=""
															  );	
							}

						}elseif($nm=="tipo_pne"){

							
							//0: para dezativar autocomplete
							$autocomplete =0;
							
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
															   ,$class=""
															   ,$id=$nm
															   ,$name=$nm
															   ,$value="-1"
															   ,$placeholder=$ph
															   ,$icoclass=""
															   ,$type="text"
															   ,$size="60"
															   ,$maxlength=$mxl
															   ,$iteracao=$qtpne
															   ,$tipoiteracao=0 //0:select;1:radio
															   ,$utf8=0
															   ,$evento=""
															  );	
							}

						}elseif($nm=="tipo_cadastro"){
						
							echo $gui->renderDinamico( 	    $c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class="ace"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value="-1"
														   ,$placeholder=$ph
														   ,$icoclass=""
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qtc
														   ,$tipoiteracao=1 //radio
														   ,$utf8=0
														   ,$evento=""
														  );	

						
						}else{ //$gui->renderStatico renderiza
							   // os campos genericos ou daqueles 
							   //que nao precisam de laco

							if($nm=="cadastro") {

								$ph = "CPF/CNPJ"; 
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
                    				<input class="form-control search-query" name="telefones[]" id="telefones" value="" placeholder="Telefones" size="40" maxlength="255" type="text" />
                                
                                </div>
                                <hr>
                                </div>
                                </div>
								<div id="listas">
									<?php //telefones ?>
								</div>

								<?php
								

							}else{



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
				}

				
				}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}

				?>
			

				<div id="divempresaid">
					<?php //busca arquivo que troca nome por id ?>
				</div>
				<div id="divestagiarioid">
					<?php //busca arquivo que troca nome por id ?>
				</div>
				<div id="divservidorid">
					<?php //busca arquivo que troca nome por id ?>
				</div>


				

				</div>	

				<?if (in_array($_SESSION["loginiwe"],$arSA)   ){?>
					<input type="hidden" name="servidor_id" value="<?=$_SESSION["dispname"]?>"> 
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="cadastrar" value="Cadastrar"/>							
						</div>
					</div>
				</div>
				<?}?>

					<input type="hidden" name="datacadastro"/>
					<input type="hidden" name="horacadastro" />
					<input type="hidden" name="msgdestino" value="../sistema/cad_usuario.php"/>
					
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
