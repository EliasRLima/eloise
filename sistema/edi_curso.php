
<?php
error_reporting(0);
//HACK:BANCO
$iso = 0;

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
 *      Desenvolvedor:
 *
 *      Copyright
 *
 *      Instituto Federal do Maranhao - Campus Monte Castelo
 */

	require "classes/ExecVerificaSessionClass.php";

	require "classes/Comunicadora.php";
	
	require "classes/Normalizadora.php";

	require "../static/layout/scripts.html";

	include("classes/Crud.php");

	include("classes/Gui.php");	
	
	include("classes/CPessoa.php");	


	//----------------------------------------------------------------------------
	//Controle de permissoes
	//----------------------------------------------------------------------------


	//----------------------------------------------------------------------------

	//instancia para os combos e check
	$cBD = new comunicadora();

	$nr = new Normalizadora();
	
	$gui = new Gui();

	$crud = new Crud();

	$cpessoa = new CPessoa();

	$action = "classes/upd_usuario.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="EDITAR CURSO";


//.CONFIGURACOES BASICAS

//MENU

include ('../static/layout/layout_menu_nav.php');

//.MENU

//CONTEUDO 




?>

    
<?php //require "../static/layout/estilos.html";?>   
     
<?php require "../static/layout/scripts.html";?>   

<?php include ('../static/layout/layout_icontent_breadcrumbs.php');  ?>


<div class="col-xs-12">
 <!-- PAGE CONTENT BEGINS -->

 <?php 


 	$inf->doDecodifica($_GET['url']);

 	$curso_id =  $_GET['_id']; 
	//NOFIFICACAO

		//$msg 	    = "";	
		//$classmsg = "alert alert-danger";		
		//$href     = "";
		//$txtHef   = "";		
		//$header   = "";
		if (isset($_GET['al']) && isset($_GET['msg']))

			echo $inf->nav_notificacao( $al=$_GET['al'] 
										,$msg=$_GET['msg']
								        ,$classmsg= "alert alert-danger"				
								  		,$href="#"
								  		,$txtHef=""		
								  		,$header="#"
								 	  );

	//./NOFIFICACAO

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

	$qp = $cCurso->readCurso($c, $crud, $colunas="id, descricao, setor_id", $tabela="curso", $tipoMetodo=0, $filtro="", 
		$viewsql=0);

	$qgp = $crud->readCurso($c, $colunas="id, descricao, setor_id", $tabela="curso", $chave="", $tipoMetodo=0, $filtro="", $orderby="id asc",  $viewsql=0);

	$qat = $crud->readCurso($c, $colunas="id, descricao, setor_id", $tabela="curso", $chave="", $tipoMetodo=0, $filtro="", $orderby="id desc",  $viewsql=0);


	$lp = $ccurso->readCurso($c, $crud, $colunas="id, descricao, setor_id, tipo_turno, tipo_modalidade", $tabela="curso", $tipoMetodo=2, $filtro="", $viewsql=0);

	$lgp = $ccurso->readCurso($c, $crud, $colunas="id, setor_id, descricao ,carga_horaria", $tabela="curso", $tipoMetodo=2, $filtro="carga_horaria>=0", $viewsql=0);

	$lat = $ccurso->readCurso($c, $crud, $colunas="id, carga_horaria", $tabela="curso", $tipoMetodo=2, $filtro="carga_horaria>=0", $viewsql=0);

	$lmat = $ccurso->readCurso($c, $crud, $colunas="id, descricao", $tabela="curso", $tipoMetodo=2, $filtro="", $viewsql=0);

	$lse = $ccurso->readCurso($c, $crud, $colunas="setor_id, descricao", $tabela="curso", $tipoMetodo=2, $filtro="", $viewsql=0);

	$login_id = $lgp['id'];



	$arFiltro = array(
						"_filtro="=>5
						,",_papel="=>7
						//,"_idretorno="=>$login_id
						//,"_id="=>$login_id 	 
						
					  );
	
	//rota
	//$arFiltro: Filtro com os filtros. Ex.: "_filtro="=>99",",_papel="=>5
	//$viewFiltro: 0: default; 1: exibe sem cryptografia
	//returns: url criptografada
	$msgdestino = $inf->rota($arFiltro,$destino="seletora.php?url=", $viewCaminho=0);


  ?>

<script>

	$(document).ready(function(){

			//hack
		$(function() {
		  var pessoas = <?php if (file_exists("ax_curso.php")) require("ax_curso.php"); else echo "Contato(s) n&atilde;o encontrado(s)!"; ?>
		  $("#login").autocomplete({
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

		$(window).load(function(){

			$("#divpessoaid").append('<input type="hidden" id="_id" name="_id" value="<?php echo $id; ?>"/>');

			
				
		});

	}); //.ready

</script>

<div class="page-header">
    <h1>
        <? echo "[".$descrelatorio."]";?>        
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
				//preservar a ordem do array
				//em funcao dos desvios ifs
				//das rotinas $gui->renderX
				$arInputLabNome = array(
									
										"Nome"=>"login"
										,"Siape"=>"autenticador"
										//TODO: A SENHA DEVE SER MODIFICADA EM PAGINA 
										//EXCLUSIVA
										//,"Senha"=>"senha"
										,"Grupo de permiss&atilde;o: SA: Super Administrador; O: Operador; C: Consulta."=>"nivel"
										,"Ativar:"=>"ativo"
										
								);

				foreach ($arInputLabNome as $lab=>$nm) {

					if($nm=="login"){

						$autocomplete =1;
							
						if($autocomplete){

							$ph = "Digite um nome para pesquisar";
							
							echo $gui->renderStatico( $label=$lab
													   ,$tag="input style='border:solid 1px #87B87F;'"
													   ,$class="form-control search-query"
													   ,$id=$nm
													   ,$name=$nm
													   ,$value=$lp['descricao']
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
													   ,$value=$lp['descricao']
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

					

					}elseif($nm=="nivel"){

						echo $gui->renderDinamico( 	    
													$c
												   ,$label=$lab
												   ,$tag="select"
												   ,$class="form-control search-query"
												   ,$id=$nm
												   ,$name=$nm
												   ,$value=$lgp['nivel']
												   ,$placeholder=$ph
												   ,$icoclass="ace-icon fa fa-credit-card"
												   ,$type="text"
												   ,$size="60"
												   ,$maxlength=$mxl
												   ,$iteracao=$qgp
												   ,$tipoiteracao=0 //select
												   ,$utf8=0
												   ,$evento=""
												  );	

					}elseif($nm=="senha"){

						echo $gui->renderStatico( $label=$lab
													   ,$tag="input style='border:solid 1px #87B87F;'"
													   ,$class="form-control search-query"
													   ,$id=$nm
													   ,$name=$nm
													   ,$value=$lse['senha']
													   ,$placeholder=$ph
													   ,$icoclass="ace-icon fa fa-search"
													   ,$type="password"
													   ,$size="60"
													   ,$maxlength=$mxl
													   ,$evento
													  );

					}elseif($nm=="ativo"){

						echo $gui->renderDinamico( 	    
													$c
												   ,$label=$lab
												   ,$tag="select"
												   ,$class="form-control search-query"
												   ,$id=$nm
												   ,$name=$nm
												   ,$value=$lat['ativo']
												   ,$placeholder=$ph
												   ,$icoclass="ace-icon fa fa-credit-card"
												   ,$type="text"
												   ,$size="60"
												   ,$maxlength=$mxl
												   ,$iteracao=$qat
												   ,$tipoiteracao=1 //0:select;1:radio
												   ,$utf8=0
												   ,$evento=""
												  );	

					}elseif($nm=="autenticador"){

						echo $gui->renderStatico( $label=$lab
												   ,$tag="input"
												   ,$class="form-control search-query"
												   ,$id=$nm
												   ,$name=$nm
												   ,$value=$lmat['descricao']
												   ,$placeholder=$ph
												   ,$icoclass="ace-icon fa fa-search"
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
												   ,$value=""
												   ,$placeholder=$ph
												   ,$icoclass="ace-icon fa fa-search"
												   ,$type="text"
												   ,$size="60"
												   ,$maxlength=$mxl
												   ,$evento
												  );
					}

				}//fim foreach	

				}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
			 ?>
			 	<div id="divpessoaid">
					<?php //busca arquivo que troca nome por id ?>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="atualizar" value="Atualizar"/>	
							<a href="../sistema/<?php echo  $msgdestino; ?>" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Voltar
							</button>
							
							</a>						
						</div>
					</div>
				</div>

					<input type="hidden" id="_login_id" name="_login_id" value="<?php echo $login_id;?>"/>
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