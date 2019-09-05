
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

				$query = "";
				$delimitado = 0;

				if(isset($_POST['emp_string']) and $_POST['emp_string']!=null and $_POST['emp_string']!=""){
				 $delimitado = 1;
				}

				if($_POST['CursoRE']!=null and $_POST['CursoRE']!=""){
				 $delimitado = 1;
				}

				if(isset($_POST['serv_string']) and $_POST['serv_string']!=null and $_POST['serv_string']!=""){
				 $delimitado = 1;
				}

				if($_POST['CursoRE']!=null and $_POST['CursoRE']!=""){
					//echo "Curso = ".$_POST['CursoRE']."\n";
				$query = "select (select descricao from curso where id in (select curso_id from pessoa where id = estagiario_id)) as curso,(select count(id) from estagio a where a.estagiario_id in (select id from pessoa where curso_id = (select id from curso where id = (select curso_id from pessoa where id = e.estagiario_id))) and e.estagiario_id not in (select estagiario_id from estagio where id < e.id)) as contagem from estagio e where e.estagiario_id not in (select estagiario_id from estagio where id < e.id) and (select id from curso where id = (select curso_id from pessoa where id = e.estagiario_id)) not in (select id from curso where id in (select curso_id from pessoa where id in (select estagiario_id from estagio where id < e.id))) and (select curso_id from pessoa where id = estagiario_id) in (select id from curso where id = '".$_POST['CursoRE']."') order by contagem desc;";
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				if($num_rows > 0) {
					?>
				<h3><p>Quantos estagios tem por curso:</p></h3>
				<h5><p>Delimitado por <?=$linha['curso']?></p></h5>
				<?

					$query = "SELECT id,(select CodigoTurma from turma_curso where id = p.id limit 1) as turma,(select count(id) from pessoa where turma_curso = p.CodigoTurma and id in (select estagiario_id from estagio)) as estagiarios,(select count(id) from pessoa where turma_curso = p.CodigoTurma and id not in (select estagiario_id from estagio)) as candidatos,conclusao,(select count(id) from pessoa where tipo_cadastro in (3) and curso_id = '2' and id in (select estagiario_id from estagio) and turma_curso in (select Codigoturma from turma_curso)) as ect,(select count(id) from pessoa where tipo_cadastro in (3) and curso_id = '2' and id not in (select estagiario_id from estagio) and turma_curso in (select Codigoturma from turma_curso)) as cct,(select count(id) from pessoa where tipo_cadastro in (3) and curso_id = '2' and id not in (select estagiario_id from estagio)) as ct,(select count(id) from pessoa where tipo_cadastro in (3) and curso_id = '2' and id in (select estagiario_id from estagio)) as et,(select count(situacao_estagio) from estagio where estagiario_id in (select id from pessoa where turma_curso = (select CodigoTurma from turma_curso where id = p.id) and situacao_estagio = 3)) as aberto,(select count(situacao_estagio) from estagio where estagiario_id in (select id from pessoa where turma_curso = (select CodigoTurma from turma_curso where id = p.id) and situacao_estagio = 1)) as andamento,(select count(situacao_estagio) from estagio where estagiario_id in (select id from pessoa where turma_curso = (select CodigoTurma from turma_curso where id = p.id) and situacao_estagio = 2)) as concluido,(select count(situacao_estagio) from estagio where estagiario_id in (select id from pessoa where turma_curso = (select CodigoTurma from turma_curso where id = p.id) and situacao_estagio = 4)) as interrompido FROM eloisebd.turma_curso p where curso = '2';";
					$resultado = @mysqli_query($link,$query);
					$num_rows = @mysqli_num_rows($resultado);
					$linha = @mysqli_fetch_assoc($resultado);
					
					if($num_rows > 0){
						// inicia o loop que vai mostrar todos os dados
						?>
						<table  style="width:100%;background-color: #cccccc;">
						<tr>
							<th>Turma de est&aacute;gio</th>
							<th>Estagiarios</th>
							<th>Candidatos</th>
							<th>Ano de conclusao</th>
							<th>Andamento</th>
							<th>Concluido</th>
							<th>Pendente</th>
							<th>Cancelado</th>
						</tr>
						<?if($linha['ect'] < $linha['et'] or $linha['cct'] < $linha['ct'])?>
						<tr>
							<td>Alunos do curso sem turma</td>
							<td><?$esturma = $linha['et'] - $linha['ect'];if($esturma > 0){echo $esturma;}else{echo "0";}?></td>
							<td><?$csturma = $linha['ct'] - $linha['cct'];if($csturma > 0){echo $csturma;}else{echo "0";}?></td>
							<td></td>
						</tr>
						<?
						do {
						?>	

						<tr>
							<td><?=$linha['turma']?></td>
							<td><?=$linha['estagiarios']?></td>
							<td><?=$linha['candidatos']?></td>
							<td><?=$linha['conclusao']?></td>
							<td><?=$linha['andamento']?></td>
							<td><?=$linha['concluido']?></td>
							<td><?=$linha['aberto']?></td>
							<td><?=$linha['interrompido']?></td>
						</tr>
						<?
						// finaliza o loop que vai mostrar os dados das turmas
						}while($linha = @mysqli_fetch_assoc($resultado));
						?></table><?
					}
					else{
						echo "Turma(s) nao localizada(s)";?><br></br><?
					}
					// fim do if 
				}
				else{
					echo "Estagio(s) nao localizado(s)";?><br></br><?
					}
					   //exit($query);
				}
				

				
				elseif($delimitado != 1){
					$query = "select (select descricao from curso where id in (select curso_id from pessoa where id = estagiario_id)) as curso,(select count(id) from estagio a where a.estagiario_id in (select id from pessoa where curso_id = (select id from curso where id = (select curso_id from pessoa where id = e.estagiario_id))) and e.estagiario_id not in (select estagiario_id from estagio where id < e.id)) as contagem from estagio e where e.estagiario_id not in (select estagiario_id from estagio where id < e.id) and (select id from curso where id = (select curso_id from pessoa where id = e.estagiario_id)) not in (select id from curso where id in (select curso_id from pessoa where id in (select estagiario_id from estagio where id<e.id))) order by contagem desc;";
					
					$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<h3><p>Quantos estagios tem por curso:</p></h3>

				<h5><p>Delimitado por cursos que possuem estagiarios</p></h5>
				<?
				

				if($num_rows > 0) {
					?><table  style="width:100%;background-color: #cccccc;">
					<tr>
						<th>CURSO</th>
						<th>Quantidade de estagios</th>
					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
					if($linha['contagem'] != 0){
					?>	
						<p>
								<tr>
									<td><?=$linha['curso']?></td>
									<td><?=$linha['contagem']?></td>

								</tr>
							
						</p>
					<? }
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio(s) nao localizado(s)";?><br></br><?
					}
				}

				
				







				//cont por empresa
				$query = "";
				//echo "Valor:".$_POST['emp_string'];exit();
				if(isset($_POST['emp_string']) and $_POST['emp_string']!=null and $_POST['emp_string']!=""){
					//echo "Foi setado como:".$_POST['emp_string'];
					$query = "select (select nome from pessoa where id = e.empresa_id and e.empresa_id in (select id from pessoa where nome like '%".$_POST['emp_string']."%')) as empresa,(select count(id) from estagio a where e.empresa_id = a.empresa_id and e.empresa_id not in (select empresa_id from estagio where id < e.id)) as contagem from estagio e where e.empresa_id not in (select empresa_id from estagio where id < e.id) and e.empresa_id in (select id from pessoa where nome like '%".$_POST['emp_string']."%') order by contagem desc;";
					//echo $query;
					$resultado = @mysqli_query($link,$query);
					$num_rows = @mysqli_num_rows($resultado);
					$linha = @mysqli_fetch_assoc($resultado);

				?>
					<h3><p>Quantos estagios tem por empresa:</p></h3>
					<h5><p>Delimitado por <?echo $_POST['emp_string'];?></p></h5>
					
					<?

				if($num_rows > 0) {
					?><table  style="width:100%;background-color: #cccccc;">
					<tr>
						<th>EMPRESA</th>
						<th>Numero de estagios</th>

					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
					?>	
						<p>
								<tr>

									<td><?=$linha['empresa']?></td>
									<td><?=$linha['contagem']?></td>

								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio(s) nao localizado(s)";?><br></br><?
					}
				}
				elseif($delimitado != 1){

					$query = "select id,(select nome from pessoa where pessoa.id = empresa_id) as empresa,(select count(distinct id)from estagio a where a.empresa_id = estagio.empresa_id) as contagem from estagio where empresa_id not in (select empresa_id from estagio e where e.id < estagio.id) order by contagem desc;";
					//echo $query;
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);

				?>
				<h3><p>Quantos estagios tem por empresa:</p></h3>
				<h5><p>Delimitado por empresas que realizaram estagios</p></h5>
				<?
				

				if($num_rows > 0) {
					?><table  style="width:100%;background-color: #cccccc;">
					<tr>
						<th>EMPRESA</th>
						<th>Numero de estagios</th>

					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
					?>	
						<p>
								<tr>

									<td><?=$linha['empresa']?></td>
									<td><?=$linha['contagem']?></td>

								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio(s) nao localizado(s)";?><br></br><?
					}
				}

				





				//cont por servidor
				$query = "";
				if(isset($_POST['serv_string']) and $_POST['serv_string']!=null and $_POST['serv_string']!=""){
					$query = "select (select nome from pessoa where id = e.servidor_id) as servidor,(select count(id) from estagio a where e.servidor_id = a.servidor_id and e.servidor_id not in (select servidor_id from estagio where id < e.id)) as contagem from estagio e where e.servidor_id not in (select servidor_id from estagio where id < e.id) and e.servidor_id in (select id from pessoa where nome like '%".$_POST['serv_string']."%') order by contagem desc;";
					?>
						<h3><p>Quantos estagios tem por servidor:</p></h3>

							<h5><p>Delimitado por <?=$linha['serv_string']?></p></h5>
					<?
						
				//echo $query;
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);

				if($num_rows > 0) {
					?><table  style="width:100%;background-color: #cccccc;">
					<tr>
						<th>Servidor</th>
						<th>Numero de estagios</th>

					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
						if($linha['servidor']=="" or $linha['servidor']==null){
							$linha['servidor'] = "Estagios sem servidor";
						}
					?>	
						<p>
								<tr>

									<td><?=$linha['servidor']?></td>
									<td><?=$linha['contagem']?></td>

								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio(s) nao foi(foram) localizado(s)";?><br></br><?
					}
				}
				elseif($delimitado != 1){
					$query = "select id,(select nome from pessoa where pessoa.id = servidor_id) as servidor,(select count(distinct id)from estagio a where a.servidor_id = estagio.servidor_id) as contagem from estagio where servidor_id not in (select servidor_id from estagio e where e.id < estagio.id) order by contagem desc;";
					?>
						<h3><p>Quantos estagios tem por servidor:</p></h3>
						<h5><p>Delimitado por servidores que participaram em estagios</p></h5>
					<?

				//echo $query;
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);

				if($num_rows > 0) {
					?><table  style="width:100%;background-color: #cccccc;">
					<tr>
						<th>Servidor</th>
						<th>Numero de estagios</th>

					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
						if($linha['servidor']=="" or $linha['servidor']==null){
							$linha['servidor'] = "Estagios sem servidor";
						}
					?>	
						<p>
								<tr>

									<td><?=$linha['servidor']?></td>
									<td><?=$linha['contagem']?></td>

								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linha = @mysqli_fetch_assoc($resultado));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio(s) nao foi(foram) localizado(s)";?><br></br><?
					}
				}
				
				


				?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="sm_quantitativo.php" name="msgdestino"/>
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
