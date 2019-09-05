
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

	$action = "classes/upd_turma.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="EDITAR USU&Aacute;RIO";


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

 	$turma_id =  $_POST['Turma'];

  ?>


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
					
				//preservar a ordem do array
				//em funcao dos desvios ifs
				//das rotinas $gui->renderX
				$tuplas ="
					id
					,(select descricao from tipo_situacao where nome_tabela = 'curso' and nome_coluna = 'setor_id' and valor_char = (select curso from turma_curso where CodigoTurma = '".$turma_id."' )) as curso
					,Conclusao
					,CargaHorariaEstagio
					,Sequencia
					,Modalidade
					,turno		
				";
				$turma = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="turma_curso", $tipoMetodo=2, $filtro=$extra, $viewsql=0);
				
				$qtr = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="curso", $chave="setor_id", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);

				$arInputLabNome = array(
									
										"Curso"=>"curso"
										,"Ano de Conclusao"=>"Conclusao"
										,"Carga horaria de estagio"=>"CargaHorariaEstagio"
										,"Sequencia"=>"sequencia"
										,"Modalidade"=>"modalidade"
										,"Turno"=>"turno"
										
								);

				foreach ($arInputLabNome as $lab=>$nm) {

					if($nm=="curso"){

						echo $gui->renderDinamico( 	    $c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$turma['curso']
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

					}elseif($nm=="Conclusao"){

						echo $gui->renderStatico( $label=$lab
													   ,$tag="input style='border:solid 1px #87B87F;'"
													   ,$class="form-control search-query"
													   ,$id=$nm
													   ,$name=$nm
													   ,$value=$turma['Conclusao']
													   ,$placeholder=$ph
													   ,$icoclass="ace-icon fa fa-search"
													   ,$type="text"
													   ,$size="60"
													   ,$maxlength=$mxl
													   ,$evento
													  );

					}elseif($nm=="CargaHorariaEstagio"){

						echo $gui->renderStatico( $label=$lab
													   ,$tag="input style='border:solid 1px #87B87F;'"
													   ,$class="form-control search-query"
													   ,$id=$nm
													   ,$name=$nm
													   ,$value=$turma['CargaHorariaEstagio']
													   ,$placeholder=$ph
													   ,$icoclass="ace-icon fa fa-search"
													   ,$type="text"
													   ,$size="60"
													   ,$maxlength=$mxl
													   ,$evento
													  );

					}elseif($nm=="sequencia"){

								echo $gui->renderDinamico( 	$c
														   ,$label=$lab
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$turma['sequencia']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qseq
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );	

							}elseif($nm=="modalidade"){
						
							echo $gui->renderDinamico( 	    $c //modo_rolamento
														   ,$label=$lab //nome
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$turma['modalidade']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qmod
														   ,$tipoiteracao=0 //1 radio //2 escolhas
														   ,$utf8=0
														   ,$evento=""
														 );
							

						}elseif($nm=="turno"){
						
							echo $gui->renderDinamico( 	    $c //modo_rolamento
														   ,$label=$lab //nome
														   ,$tag="select"
														   ,$class="form-control search-query"
														   ,$id=$nm
														   ,$name=$nm
														   ,$value=$turma['turno']
														   ,$placeholder=$ph
														   ,$icoclass="ace-icon fa fa-credit-card"
														   ,$type="text"
														   ,$size="60"
														   ,$maxlength=$mxl
														   ,$iteracao=$qtur
														   ,$tipoiteracao=0 //1 radio //2 escolhas
														   ,$utf8=0
														   ,$evento=""
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

