
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
		<div class="widget-main">
			
			 <?php

			 $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				
				//query para buscar estagios
				$queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
				$qdata = @mysqli_query($link,$queryd);
				$num_rows_data = @mysqli_num_rows($qdata);
				$data = @mysqli_fetch_assoc($qdata);
				$cursoID = 0;
				$diaMax = $dia = $data['dia'];
				$mesMax = $mes = $data['mes'];
				$anoMax = $ano = $data['ano'];//para ser maior de idade
				
					if(isset($_POST['Jap'])){
						$anoMax = $ano - 25;
						if($dia >1){
							$diaMax = $dia - 1; 
						}
						elseif($dia == 1 and $mes != 3){
							$diaMax = 30 and $mesMax = $mes - 1;
						}
						elseif($dia==1 and $mes==3){
							$diaMax = 28 and $mesMax = $mes - 1;
						}
					}
			 		if(isset($_POST['MIdade']))
					{
   						$ano = $ano-18;
					}
					/*else{
						echo "MIdade nao marcado";
					}**/
					//echo "Baseando se na data:".$dia."/".$mes."/".$ano."";exit();
					if(isset($_POST['CursoRE']))
					{
						$cursoID = $_POST['CursoRE'];
						//echo "Curso: ".$cursoID;
					}
   					
					else{
						echo "CursoRE nao capturado";
					}
					if(isset($_POST['AL']))
					{
   						$AL = $_POST['AL'];
   						if($AL==1){
   							$AL = " id not in (select estagiario_id from estagio)";
   						}
   						elseif($AL==2){
   							$AL = " id in (select estagiario_id from estagio)";
   						}
   						elseif($AL==3){
   							$AL = " ano_conclusao>1960 and id not in (select estagiario_id from estagio)";
   						}
   						elseif($AL==4){
   							$AL = " ano_conclusao>1960 and id in (select estagiario_id from estagio)";
   						}
   						else
   						{
   							$AL = 5;
   						}
   						//echo "Valor de AL = ".$AL;
					}
					else
					{
						$AL = 5;
					}
					/*
					if(isset($_POST['AE']))
					{
   						echo "checkbox AE marcado! <br/>";
   						echo "valor: " . $_POST['AE'];
					}
					else
					{
						echo "AE nao marcado";
					}**/



				$query = "SELECT (select valor_int from tipo_situacao where valor_char = pessoa.turma_curso) as curso,id,nome,data_nascimento,matricula,email,sexo,bairro,telefones FROM eloisebd.pessoa where ";

				if(isset($_POST['MIdade']) and !isset($_POST['Jap'])){
					$query .= "data_nascimento between '1968-01-31' and '";
					$query .= $ano;
					$query .="-";
					$query .= $mes;
					$query .="-";
					$query .= $dia;
					$query .="'";
					if(isset($AL) and $AL !=5){
						$query .=" and";
					}
					
				}
				if(!isset($_POST['MIdade']) and isset($_POST['Jap'])){
					$query .= "data_nascimento between '".$anoMax."-".$mesMax."-".$diaMax."' and '";
					$query .= $ano;
					$query .="-";
					$query .= $mes;
					$query .="-";
					$query .= $dia;
					$query .="'";
					$query .=" and";
					
				}
				if(isset($_POST['MIdade']) and isset($_POST['Jap'])){
					$query .= "data_nascimento between '".$anoMax."-".$mesMax."-".$diaMax."' and '";
					$query .= $ano;
					$query .="-";
					$query .= $mes;
					$query .="-";
					$query .= $dia;
					$query .="'";
					if(isset($AL) and $AL !=5){
						$query .=" and";
					}
					
				}

				if($AL!=5){
					$query .= $AL;
				}
				if($cursoID != '' and $cursoID != null and $cursoID!=0){
					if(isset($AL) and $AL !=5 or isset($_POST['MIdade'])){
						$query .=" and";
					}
					$query .= " pessoa.curso_id =";
					$query .= $cursoID; 
				}
				$query .= " and tipo_papel in (3) order by curso desc,nome asc;";

				//echo $query;exit();
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);

				//query conta maiores de idade por curso
				

				?>
				<?
				// se o número de resultados for maior que zero, mostra os dados
				if($num_rows > 0) {
				// inicia o loop que vai mostrar todos os dados	
					?>
					<p>
					<h3>Registros</h3>
					<form name="exportar" method="POST" action="relatorio_alunos_exportacao.php">
					<h4><b>Localizado(s) <?=$num_rows?> registro(s)</b></h4>
					<input type="hidden" name="query" id="quer" value="<?=$query?>"/>
					<b><input class="btn btn-success btn-lg" type="submit" name="button" id="button" value="Visualizar dados para exporta&ccedil;&atilde;o"/></b>
					<a href="sm_grupo.php" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" style="allign: left;">
								<i class="ace-icon fa fa-undo bigger-110"></i>Retornar
							</button>
							
					</a> 
					</form>
					</p>
					
					<head>
					<style>
					table, th, td {
    				border: 1px solid black;
    				border-collapse: collapse;
					}
					th, td {
   					 padding: 5px;
					}
					th {
  					  text-align: left;
					}
					</style>
					</head>
					<table width="100%">
					<tr>
  			 			 <th></th>
  			 			 <th>Matricula</th>
  			 			 <th>Nome</th>
  			 			 <th>Sexo</th>
  			 			 <th>Bairro</th>
   			 			 <th>Data nascimento</th>
   			 			 <th>Telefones</th>
   			 			 <th>Email</th>
   			 			 <th>Ano de conclusao previsto</th>
  					</tr>
  					 <?
  					 //$controlador = 0;
				do {
					?>
  					<tr>
  						<td>

  							<?php $url="_tipoP=3,_AlunoR=".$linha['id'];?>
  							<a href="relatorio_completo.php?url=<?php echo $inf->doCodifica($url)?>" class="dropdown-toggle">
              					<i class="menu-icon fa fa-search" style="color: black;"></i>
            				</a>

            				<?php $url="_id=".$linha['id'];?>
  							<a href="edi_aluno.php?url=<?php echo $inf->doCodifica($url)?>" name="msgdestino"/>
								<i class="ace-icon fa fa-pencil" style="color: black;"></i>
  							<!--<form name="relatorioAlunos" method="POST" action="relatorio_completo.php?url=eJyLz0yxNbQwBgAJNAIG">
  												<input type="hidden" name="tipoP" id="tipoP" value="3"/>
												<input type="hidden" name="AlunoR" id="AlunoR" value="<?=$linha['id']?>"/>
												<input style="width:100%;" class="menu-icon fa fa-search" type="submit" name="button" id="button" value=""/>
							</form>-->
						</td>
						<td><?=$linha['matricula']?></td>
  						<td><?=$linha['nome']?></td>
  						<td><?$sexo=$linha['sexo'];if($sexo==1){?><i class="menu-icon fa  fa-venus" style="color: black;"></i><?}elseif($sexo=2){?><i class="menu-icon fa fa-mars" style="color: black;"></i><?}?></td>
  						<td><?$email=$linha['bairro'];if($email != '-1'){echo $email;}?></td>
  						<td><?if($linha['data_nascimento']!=null){$data = substr($linha['data_nascimento'],8,2)."/".substr($linha['data_nascimento'],5,2)."/".substr($linha['data_nascimento'],0,4);echo $data;}?></td>
  						<td><?$telefone = str_replace(",-1","", $linha['telefones']);$telefone = str_replace("-1","", $telefone);$telefone = str_replace("1=>","", $telefone);$telefone = str_replace('"]',"", $telefone); $telefone = str_replace("0=>","", $telefone);$telefone = str_replace('["',"", $telefone);$telefone = str_replace(',"',"", $telefone);$telefone = str_replace(",,",",", $telefone);$telefone = str_replace(",,",",", $telefone); echo $telefone; ?></td>
  						<td><?$email=$linha['email'];if($email != '-1'){echo $email;}?></td>
  						<td><?=$linha['curso']?></td>
  					</tr>
						<?
						$controlador+=1;

				}while ($linha = @mysqli_fetch_assoc($resultado) /*and $controlador<50*/); //controlador limita numero de linhas
					# code...
				?></table><?
			}
				else{

					echo "Nenhum aluno localizado!";
					?><p><a href="sm_alunos.php" name="msgdestino"/>
										<button type="button"  class="btn btn-success btn-lg" >
										<i class="ace-icon fa fa-undo bigger-110"></i>Retornar
									</button>
							
									</a></p><?
					
				}

			 ?>

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
