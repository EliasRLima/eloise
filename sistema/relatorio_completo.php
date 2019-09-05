
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
		<h5 class="widget-title lighter"><?php echo "DADOS LOCALIZADOS";?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">
			<form class="form-search" id="<?php echo $nmform; ?>" name="<?php echo $nmform; ?>" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">


			<!-- PAGE CONTENT STARTS -->
			<?php
			?>
			<head>
			<style>
			table, th, td {
  			  border: 1px solid black;
  			  border-collapse: collapse;
			}
			th, td {
   				 padding: 5px;
			}
			</style>
			</head>
			<?
				$aux_mascara_telefone = '["0=>"]';
				$inf->doDecodifica($_GET['url']);
				$id = $_GET['_id'];
				$aluno = $_GET['_AlunoR'];
				//echo "Achou: ".$id."Resgatou? ".$aluno; //exit;

				if($aluno != "" && $aluno =! null){

					$id = $_GET['_AlunoR'];
				}
				//echo "Achou: ".$id."Resgatou? ".$aluno; //exit;
				//exit("Valor passado: ".$aluno."!");

				//$papel = $get['_papel'];
				//$papel2 =$get['_tipo_papel'];
				//echo "Papel:".$papel. "Papel2:".$papel2;

				$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");

				//query para verificar pessoa
				$pessoal = "select * from pessoa where id=";
				$pessoal .= $id;
				$pessoal .= ";";


				$resultadop = @mysqli_query($link,$pessoal);
				$num_rowsp = @mysqli_num_rows($resultadop);
				$linhap = @mysqli_fetch_assoc($resultadop);
				$CPF = 'CPF';

				$papel = $linhap['tipo_papel'];
				if($papel==2){
					$CPF = 'CNPJ';
				}
				
				$mydata=$linhap['data_nascimento'];
				$brdata = substr($mydata,8,2)."/".substr($mydata,5,2)."/".substr($mydata,0,4);
				//echo $brdata;exit();

				// se o número de resultados for maior que zero, mostra os dados
				if($num_rowsp > 0) {
				// inicia o loop que vai mostrar todos os dados
				do {
				?>
				<h1>DADOS PESSOAIS:</h1>
			<p>
			<table style="width:100%">
  			<tr>
  				<td>NOME</td>
  				<td><?=$linhap['nome']?></td>
  			</tr>
  			<?if($linhap==3 || $linhap==4){?>
  			<tr>
  				<td>CURSO</td>
  				<td><? $curso = "select descricao from curso where id ="; $curso.=$linhap['curso_id']; $resultadoC = @mysqli_query($link,$curso); $linhaC = @mysqli_fetch_assoc($resultadoC); echo $linhaC['descricao'];?></td>
  			</tr>
  			<?}?>
  			<tr>
  				<td><?echo $CPF;?></td>
  				<td><?$cpf = str_replace("-1","", $linhap['cadastro']); echo $cpf;?></td>
  			</tr>
  			<tr>
  				<td>SEXO</td>
  				<td><?$sexo=$linhap['sexo'];if($sexo==1){echo "Feminino";}else{echo "Masculino";}?></td>
  			</tr>
  			<tr>
  				<td>DATA DE NASCIMENTO</td>
  				<td><?$brdata?></td>
  			</tr>
  			<tr>
  				<td>TELEFONE</td>
  				<td><?$telefone = str_replace("-1","", $linhap['telefones']);$telefone = str_replace("1=>","", $telefone);$telefone = str_replace('"]',"", $telefone); $telefone = str_replace("0=>","", $telefone);$telefone = str_replace('["',"", $telefone);$telefone = str_replace(',"',"", $telefone);$telefone = str_replace("".$aux_mascara_telefone."","", $telefone);$telefone = str_replace(",,","", $telefone); echo $telefone; ?></td>
  			</tr>
  			<tr>
  				<td>ENDERE&Ccedil;O</td>
  				<td><?if($linhap['endereco'] !='-1' and $linhap['endereco'] != "" ){?>RUA: <?echo $linhap['endereco'];}?> <?if($linhap['bairro']!='-1' and $linhap['bairro']!=""){?>BAIRRO: <?=$linhap['bairro'];}?> <?if($linhap['cidade']!='-1' and $linhap['cidade']!=""){?>CIDADE: <? echo $linhap['cidade'];}?> <?if($linhap['cep']!='-1' and $linhap['cep']!=""){?>CEP: <?echo $linhap['cep'];}?></td>
  			</tr>

			</table>
			</p>

			<h1>ESTAGIO</h1>
		<?php
			// finaliza o loop que vai mostrar os dados
			}while($linhap = @mysqli_fetch_assoc($resultado));
			// fim do if 
				}
		else{
			echo "Pessoa nao localizada";
		}
		?>
<?php
			// tira o resultado da busca da memória
			if($papel==4){
			//query para verificar estagio

				$estagio  = "select id, (select nome from pessoa where estagio.empresa_id = pessoa.id) as empresa,(select nome from pessoa where pessoa.id = ".$id.") as estagiario, (select nome from pessoa where estagio.servidor_id = pessoa.id) as servidor, (select sigla from agente where estagio.agente_id = agente.id) as agente, coeficiente, matricula, tipo_pne, ano_diploma, situacao_estagio, data_inicio, data_termino, data_distrato, data_prorrogado, data_estagioavaliado, numero_termo, carga_horario, lista_telefones from estagio where estagio.estagiario_id = ";
				$estagio .= $id;
				$estagio .= ";";  

				$resultadoE = @mysqli_query($link,$estagio);
				$num_rowsE = @mysqli_num_rows($resultadoE);
				$linhaE = @mysqli_fetch_assoc($resultadoE);

				if($num_rowsE > 0) {
					?><table  style="width:100%">
					<tr>
						<th>ID</th>
						<th>EMPRESA</th>
						<th>ESTAGIARIO</th>
						<th>SERVIDOR</th>
						<th>SITUACAO</th>
					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
					?>	
						<p>
								<tr>

									<td><?=$linhaE['id']?></td>
									<td><?=$linhaE['empresa']?></td>
									<td><?=$linhaE['estagiario']?></td>
									<td><?=$linhaE['servidor']?></td>
									<td><?
											if($linhaE['situacao_estagio']==0){ echo ""; }
		            						elseif($linhaE['situacao_estagio']==1){ echo "ANDAMENTO"; }
		            						elseif($linhaE['situacao_estagio']==2){ echo "CONCLUIDO"; }
		            						elseif($linhaE['situacao_estagio']==3){ echo "EM ABERTO"; }
		            						elseif($linhaE['situacao_estagio']==4){ echo "INTERROMPIDO"; }?>
		            				</td>
								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linhaE = @mysqli_fetch_assoc($resultadoE));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio nao localizado";?><br></br><?
					}
			}
			elseif($papel == 2){
				$empresa = "select id, (select nome from pessoa where estagio.empresa_id = pessoa.id) as empresa,(select nome from pessoa where pessoa.id = estagio.estagiario_id) as estagiario, (select nome from pessoa where estagio.servidor_id = pessoa.id) as servidor, (select sigla from agente where estagio.agente_id = agente.id) as agente, coeficiente, matricula,situacao_estagio, tipo_pne, ano_diploma, data_inicio, data_termino, data_distrato, data_prorrogado, data_estagioavaliado, numero_termo, carga_horario, lista_telefones from estagio where empresa_id =";
				$empresa .= $id; 
				$empresa .= " order by estagio.id";
				$resultadoN = @mysqli_query($link,$empresa);
				$num_rowsN = @mysqli_num_rows($resultadoN);
				$linhaN = @mysqli_fetch_assoc($resultadoN);
				?><p>Numero de estagios: <?echo $num_rowsN?></p><?
				if($num_rowsN > 0) {
					// inicia o loop que vai mostrar todos os dados
					?><table  style="width:100%">
					<tr>
						<th>ID</th>
						<th>EMPRESA</th>
						<th>ESTAGIARIO</th>
						<th>SERVIDOR</th>
						<th>SITUACAO</th>
					</tr>
					<?

					do {
					?>	
						<tr>
							<td><?=$linhaN['id']?></td>
							<td><?=$linhaN['empresa']?></td>
							<td><?=$linhaN['estagiario']?></td>
							<td><?=$linhaN['servidor']?></td>
							<td><?
											if($linhaN['situacao_estagio']==0){ echo ""; }
		            						elseif($linhaN['situacao_estagio']==1){ echo "ANDAMENTO"; }
		            						elseif($linhaN['situacao_estagio']==2){ echo "CONCLUIDO"; }
		            						elseif($linhaN['situacao_estagio']==3){ echo "EM ABERTO"; }
		            						elseif($linhaN['situacao_estagio']==4){ echo "INTERROMPIDO"; }?>
		            		</td>
						</tr>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linhaN = @mysqli_fetch_assoc($resultadoN));
						?></table><?
					// fim do if 
					}
				else{
					echo "Estagios nao localizados";?><br></br><?
					}
			}
			elseif($papel == 1){
				$servidor = "select id, (select nome from pessoa where estagio.empresa_id = pessoa.id) as empresa,(select nome from pessoa where pessoa.id = estagio.estagiario_id) as estagiario, (select nome from pessoa where estagio.servidor_id = pessoa.id) as servidor, (select sigla from agente where estagio.agente_id = agente.id) as agente, coeficiente, matricula, situacao_estagio, tipo_pne, ano_diploma, data_inicio, data_termino, data_distrato, data_prorrogado, data_estagioavaliado, numero_termo, carga_horario, lista_telefones from estagio where servidor_id =";
				$servidor .= $id; 
				$servidor .= " order by estagio.id";
				$resultadoS = @mysqli_query($link,$servidor);
				$num_rowsS = @mysqli_num_rows($resultadoS);
				$linhaS = @mysqli_fetch_assoc($resultadoS);
				?><p>Numero de estagios: <?echo $num_rowsS?></p><?

				if($num_rowsS > 0) {
					// inicia o loop que vai mostrar todos os dados
					?><table  style="width:100%">
					<tr>
						<th>ID</th>
						<th>EMPRESA</th>
						<th>ESTAGIARIO</th>
						<th>SERVIDOR</th>
						<th>SITUACAO</th>
					</tr>
					<?

					do {
					?>	
						<tr>
							<td><?=$linhaS['id']?></td>
							<td><?=$linhaS['empresa']?></td>
							<td><?=$linhaS['estagiario']?></td>
							<td><?=$linhaS['servidor']?></td>
							<td><?
											if($linhaS['situacao_estagio']==0){ echo ""; }
		            						elseif($linhaS['situacao_estagio']==1){ echo "ANDAMENTO"; }
		            						elseif($linhaS['situacao_estagio']==2){ echo "CONCLUIDO"; }
		            						elseif($linhaS['situacao_estagio']==3){ echo "EM ABERTO"; }
		            						elseif($linhaS['situacao_estagio']==4){ echo "INTERROMPIDO"; }?>
		            		</td>
						</tr>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linhaS = @mysqli_fetch_assoc($resultadoS));
						?></table><?
					// fim do if 
					}
				else{
					echo "pessoa nunca se relacionou com estagios ou estagios nao localizados";?><br></br><?
					}
			}
			elseif($papel == 3){
				$candidato  = "select id, (select nome from pessoa where estagio.empresa_id = pessoa.id) as empresa,(select nome from pessoa where pessoa.id = ".$id.") as estagiario, (select nome from pessoa where estagio.servidor_id = pessoa.id) as servidor, (select sigla from agente where estagio.agente_id = agente.id) as agente, situacao_estagio,coeficiente, matricula, tipo_pne, ano_diploma, data_inicio, data_termino, data_distrato, data_prorrogado, data_estagioavaliado, numero_termo, carga_horario, lista_telefones from estagio where estagio.estagiario_id = ";
				$candidato .= $id;
				$candidato .= ";";  

				$resultadoC = @mysqli_query($link,$candidato);
				$num_rowsC = @mysqli_num_rows($resultadoC);
				$linhaC = @mysqli_fetch_assoc($resultadoC);

				if($num_rowsC > 0) {
					?><table  style="width:100%">
					<tr>
						<th>ID</th>
						<th>EMPRESA</th>
						<th>ESTAGIARIO</th>
						<th>SERVIDOR</th>
						<th>SITUACAO</th>
					</tr>
					<?

					// inicia o loop que vai mostrar todos os dados
					do {
					?>	
						<p>
								<tr>

									<td><?=$linhaC['id']?></td>
									<td><?=$linhaC['empresa']?></td>
									<td><?=$linhaC['estagiario']?></td>
									<td><?=$linhaC['servidor']?></td>
									<td><?
											if($linhaC['situacao_estagio']==0){ echo ""; }
		            						elseif($linhaC['situacao_estagio']==1){ echo "ANDAMENTO"; }
		            						elseif($linhaC['situacao_estagio']==2){ echo "CONCLUIDO"; }
		            						elseif($linhaC['situacao_estagio']==3){ echo "EM ABERTO"; }
		            						elseif($linhaC['situacao_estagio']==4){ echo "INTERROMPIDO"; }?>
		            				</td>
								</tr>
							
						</p>
					<?php
				// finaliza o loop que vai mostrar os dados
					}while($linhaE = @mysqli_fetch_assoc($resultadoE));
					// fim do if 
					?></table><?
					}
				else{
					echo "Estagio nao localizado";?><br></br><?
					}
			}
			$urles = "_id=$id";
			$url = $inf->doCodifica($urles);
			//exit("Papel: ".$papel);
			//exit("Id:".$id);
			if($papel==3){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">

							<!--<a href="edi_aluno.php?url=<?echo $url;?>" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Editar aluno
							</button>-->

							<a href="sm_aluno.php" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Voltar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>
				<?}
				elseif($papel==1){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">

							<a href="edi_servidor.php?url=<?echo $url;?>" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Editar servidor
							</button>

							<a href="seletora.php?url=eJyLT8vMKSnKtzXWiS9ILEjNsTUEAD%2FqBms%3D" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Voltar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>
				<?}
				elseif($papel==2){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">

							<a href="edi_empresa.php?url=<?echo $url;?>" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Editar empresa
							</button>

							<a href="seletora.php?url=eJyLT8vMKSnKtzXWiS9ILEjNsTUEAD%2FqBms%3D" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Voltar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>

			<?}
				else{?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">

							<a href="seletora.php?url=eJyLT8vMKSnKtzXWiS9ILEjNsTUEAD%2FqBms%3D" name="msgdestino"/>
							<button type="button"  class="btn btn-success btn-lg" >
								<i class="ace-icon fa fa-undo bigger-110"></i>Voltar
							</button>
							
							</a>
											

						</div>
					</div>
				</div>
				
			<?}
		    ?> 
		    </form>
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
