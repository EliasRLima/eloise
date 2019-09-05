
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

	$action = "classes/ins_turma.php";
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

 <?php
			  $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				$query = "SELECT *,(select descricao from curso where id = turma_curso.Curso) as nome_curso FROM eloisebd.turma_curso where CodigoTurma not in (SELECT valor_char FROM eloisebd.tipo_situacao where nome_tabela = 'turma_curso' and nome_coluna = 'curso')";
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);

				if($num_rows > 0) {

				do {
					$curso = $linha['Curso'];
					if($curso < 10){
						$curso = "0".$curso;
					}
  						$codigo = $linha['Conclusao'].$curso.$linha['sequencia'].$linha['modalidade'].$linha['turno'];
  						$query_insert = "insert into tipo_situacao(descricao,nome_tabela,nome_coluna,valor_char,valor_int,ativo) values('";
  						$query_insert .= $codigo." - ".$linha['nome_curso'];
  						$query_insert .= "','turma_curso','curso','".$linha['CodigoTurma']."','".$linha['Conclusao']."','1')";
						//echo $query_insert; exit();
						$inserir = @mysqli_query($link,$query_insert);

				}while ($linha = @mysqli_fetch_assoc($resultado));
					# code...
				?></table><?
			}
				else{
				}
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


	$qcurso = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="curso", $chave="setor_id", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.descricao asc", $viewsql=0);
	$qmod = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="turma_curso", $chave="modalidade", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_char asc", $viewsql=0);
	$qtur = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="turma_curso", $chave="turno", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_char asc", $viewsql=0);
	$qseq = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="turma_curso", $chave="sequencia", $tipoMetodo=0, $filtro="ativo=1", $orderby="ts.valor_char asc", $viewsql=0);
?>

<?php //if (file_exists("ax_pessoa.php")) require("ax_pessoa.php"); exit;?>



<script>

</script>



<div class="page-header">
    <h1>
        <? echo $descrelatorio;?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo "Insira os dados da turma";?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">

			<form class="form-search" action='<?=$action ?>' method="post"	enctype="multipart/form-data" name="formcadusuario">
				<?php 
				if (in_array($_SESSION["loginiwe"],$arSA)   ){
				
				//preservar a ordem do array
				$arInputLabNome = array(

										"Curso"=>"curso"
										,"Ano de Conclusao"=>"Conclusao"
										,"Carga horaria de estagio"=>"CargaHorariaEstagio"
										,"Sequencia"=>"sequencia"
										,"Modalidade"=>"modalidade"
										,"Turno"=>"turno"		
										
								);	


				foreach ($arInputLabNome as $lab=>$nm) {
					
						$ph = $lab;
						$tipoP = "text";
						$mxl="255";

						if($nm=="curso"){

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
														   ,$iteracao=$qcurso
														   ,$tipoiteracao=0 //select
														   ,$utf8=0
														   ,$evento=""
														  );	
							}elseif($nm=="sequencia"){

								echo $gui->renderDinamico( 	$c
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
														   ,$value=""
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
														   ,$value=""
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
				</div>


				

				</div>	
				<input type="hidden" name="CodigoTurma" value=""/>

				<?if (in_array($_SESSION["loginiwe"],$arSA)   ){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="cadastrar" value="Cadastrar"/>							
						</div>
					</div>
				</div>

				<?}?>	
					
					<input type="hidden" name="msgdestino" value="../sistema/cad_turma.php"/>
					
					
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
