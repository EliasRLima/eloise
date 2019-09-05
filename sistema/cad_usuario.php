
<?php

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
 *      cad_usuario.php
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

	$action = "classes/ins_usuario.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="Apenas um servidor ou aluno pode ser usuario, realize o cadastro caso nao possua";


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

	$qp = $cpessoa->readPessoa($c, $crud, $colunas="id, nome as descricao, cadastro", $tabela="pessoa", $tipoMetodo=0, $filtro="tipo_cadastro IN (1,2)", $viewsql=0);

	$qgp = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="login", $chave="nivel", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc",  $viewsql=0);

	$qat = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="login", $chave="ativo", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao desc",  $viewsql=0);

  ?>

<script>

	$(document).ready(function(){

			//hack
		$(function() {
		  var pessoas = <?php if (file_exists("ax_pessoa.php")) require("ax_pessoa.php"); else echo "Contato(s) n&atilde;o encontrado(s)!"; ?>
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

	}); //.ready

</script>

<div class="page-header">
    <h1>
        <? echo "Cadastro de usu&aacute;rios";?>        
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
										,"Senha"=>"senha"
										,"Grupo de permiss&atilde;o:"=>"nivel"
										,"Ativar"=>"ativo"
										
								);

				foreach ($arInputLabNome as $lab=>$nm) {
					if($nm=="autenticador"){ $ph = "Digite seu login siape";}
					if($nm=="login"){

						$autocomplete =1;
							
						if($autocomplete){

							$ph = "Digite um nome para pesquisar no sistema";
							
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

					

					}elseif($nm=="nivel"){

						echo $gui->renderDinamico( 	    
													$c
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
												   ,$iteracao=$qgp
												   ,$tipoiteracao=0 //select
												   ,$utf8=0
												   ,$evento=""
												  );	

					}elseif($nm=="ativo"){

						echo $gui->renderDinamico( 	    
													$c
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
												   ,$iteracao=$qat
												   ,$tipoiteracao=1 //0:select;1:radio
												   ,$utf8=0
												   ,$evento=""
												  );	

					}elseif($nm=="senha"){

							$autocomplete =1;
								
							if($autocomplete){

								$ph = "Digite sua senha";
								
								echo $gui->renderStatico( $label=$lab
														   ,$tag="input"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=""
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-search"
														   ,$type="password"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$evento
														  );
							}
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
					<?php 
					
					?>
				</div>
				<input type="hidden" name="pessoa_id" value="0"/>

				<?if (in_array($_SESSION["loginiwe"],$arSA)   ){?>

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

