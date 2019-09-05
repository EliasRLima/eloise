
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
			 //$Ac = $_REQUEST['AnoN'];
			 //echo "=>".$Ac;exit();
			 $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
			 $curso =  $_POST['Curso'];
			 if($curso < 10){
			 	$curso = "0".$curso;
			 }
			 $turma = $_POST['AnoN'].$curso.$_POST['Sequencia'].$_POST["Modalidade"].$_POST['Turno'];
			 //echo "=>".$turma."=>".$_POST['AnoN']."=>".$curso."=>".$_POST['Sequencia']."=>".$_POST['Modalidade']."=>".$_POST['Turno'];exit();
			 if($_POST['AnoN'] != "" and $curso != "" and $_POST['Sequencia'] != "" and $_POST["Modalidade"] != "" and $_POST['Turno'] != ""){
			 
			 $queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
			 $qdata = @mysqli_query($link,$queryd);
			 $num_rows_data = @mysqli_num_rows($qdata);
			 $data = @mysqli_fetch_assoc($qdata);
			 $dia = $data['dia'];
			 $mes = $data['mes'];
			 $ano = $data['ano'] - 18;

			 $queryQUANT = "select (select count(id) from pessoa where turma_curso = '".$turma."' and id in (select estagiario_id from estagio)) as cestagio, (select count(id) from pessoa where turma_curso = '".$turma."' and id not in (select estagiario_id from estagio)) as sestagio, (select count(id) from pessoa where turma_curso = '".$turma."') as calunos,(select count(id) from pessoa where turma_curso = '".$turma."' and data_nascimento between '1900-01-01' and '".$ano."-".$mes."-".$dia."') as maiores from pessoa limit 1;";

			 $resultado = @mysqli_query($link,$queryQUANT);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<h3><p>Numeros da turma:</p></h3>
				<?

				if($num_rows > 0) {
					?>
						<table style="width:100%;">
						<tr>
							<th>Alunos</th>
							<th>Estagiarios</th>
							<th>Candidatos</th>
							<th>Maiores de idade</th>

						</tr>	
					<?
					do {
							
							?>
							<tr>
								<td><?=$linha['calunos']?></td>
								<td><?=$linha['cestagio']?></td>
								<td><?=$linha['sestagio']?></td>
								<td><?=$linha['maiores']?></td>
							</tr>

							<?
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Sem numeros exatos";?><br></br><?
					}
			 $queryComEstagio = "SELECT *,(select '1' from pessoa t where t.id = pessoa.id and turma_curso = '".$turma."' and data_nascimento between '1900-01-01' and '".$ano."-".$mes."-".$dia."') as maiores FROM pessoa where turma_curso like '".$turma."' and id in (select estagiario_id from estagio);";
				
				$resultado = @mysqli_query($link,$queryComEstagio);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<h3><p>Alunos com estagio:</p></h3>
				<?

				if($num_rows > 0) {
					?>
						<table style="width:100%;">
						<tr>
							<th>Nome</th>
							<th>Sexo</th>
							<th>Data de Nascimento</th>
							<th>Telefones</th>
							<th>Conclusao</th>
							<th>Maior de idade</th>
						</tr>	
					<?
					do {
							
							?>
							<tr>
								<td><?=$linha['nome']?></td>
								<td><?$sexo = $linha['sexo'];if($sexo==1){echo "Feminino";}else{echo "Masculino";}?></td>
								<td><?if($linha['data_nascimento']!=null){$data = substr($linha['data_nascimento'],8,2)."/".substr($linha['data_nascimento'],5,2)."/".substr($linha['data_nascimento'],0,4);echo $data;}?></td>
								<td><?$telefone = str_replace(",-1","", $linha['telefones']);$telefone = str_replace("1=>","", $telefone);$telefone = str_replace('"]',"", $telefone); $telefone = str_replace("0=>","", $telefone);$telefone = str_replace('["',"", $telefone);$telefone = str_replace(',"',"", $telefone);$telefone = str_replace(",,",",", $telefone);$telefone = str_replace(",,",",", $telefone); echo $telefone;?></td>
								<td><?=$linha['ano_conclusao']?></td>
								<td><?$con=$linha['maiores'];if($con==1){echo "sim";}else{echo "n&atilde;o";}?></td>
							</tr>

							<?
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Sem alunos(as) com estagio!";?><br></br><?
					}

				//echo "Valor:".$_POST['emp_string'];exit();
			 $queryCandidatos = "SELECT *,(select '1' from pessoa t where t.id = pessoa.id and turma_curso = '".$turma."' and data_nascimento between '1900-01-01' and '".$ano."-".$mes."-".$dia."') as maiores FROM pessoa where turma_curso like '".$turma."' and id not in (select estagiario_id from estagio);";
				
				$resultado = @mysqli_query($link,$queryCandidatos);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);

				?>
				<h3><p>Alunos que ainda nao realizaram estagios:</p></h3>
				<?

				if($num_rows > 0) {
					?>
						<table style="width:100%;">
						<tr>
							<th>Nome</th>
							<th>Sexo</th>
							<th>Data de Nascimento</th>
							<th>Telefones</th>
							<th>Conclusao</th>
							<th>Maior de idade</th>
						</tr>	
					<?
					do {
							
							?>
							<tr>
								<td><?=$linha['nome']?></td>
								<td><?$sexo = $linha['sexo'];if($sexo==1){echo "Feminino";}else{echo "Masculino";}?></td>
								<td><?if($linha['data_nascimento']!=null){$data = substr($linha['data_nascimento'],8,2)."/".substr($linha['data_nascimento'],5,2)."/".substr($linha['data_nascimento'],0,4);echo $data;}?></td>
								<td><?$telefone = str_replace(",-1","", $linha['telefones']);$telefone = str_replace("1=>","", $telefone);$telefone = str_replace('"]',"", $telefone); $telefone = str_replace("0=>","", $telefone);$telefone = str_replace('["',"", $telefone);$telefone = str_replace(',"',"", $telefone);$telefone = str_replace(",,",",", $telefone);$telefone = str_replace(",,",",", $telefone);$telefone = str_replace("-1","", $telefone); echo $telefone;?></td>
								<td><?=$linha['ano_conclusao']?></td>
								<td><?$con=$linha['maiores'];if($con==1){echo "sim";}else{echo "n&atilde;o";}?></td>
							</tr>

							<?
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Sem candidatos na turma";?><br></br><?
					}

			 }
			 else{
			 	echo "Nao foi possivel localizar a turma! Preencha todos os campos.";
			 }
				?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="sm_turma.php" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Retornar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>

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
