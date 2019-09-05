
<?php
//HACK:O BANCO
// header ('Content-type: text/html; charset=UTF-8');
// header ('Content-type: text/html; charset=ISO-8859-1');
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

	require "classes/classe_criptografia_url.php";
	
	require "classes/Comunicadora.php";

	include("classes/CrudElise.php");	
	
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

	$action = "classes/TesteCrud.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="CONSULTAR";


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

$ipessoa = "SELECT id,nome from pessoa where tipo_cadastro=1";  

//$qp = $c->enviar($ipessoa);

//abstrato raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
//$c: conexao;
//$metodo:  0 - returns enviar;
//$metodo:  1 - returns row;
//$metodo:  2 - returns fetch;
//$metodo:  2 - returns instrucao sql;
//$retorno: 0 - doesn't return sql result method; 1 - returns sql result method
//in order to fetch method $retorno always must be 1;
//$viewsql: 0 - oculta sql; 1 - exibe sql
$qp = $crud->raw_sql($c, $ipessoa, $metodo=0, $retorno=1);





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
				<span class="middle">Nome:</span>		
					<div class="row">
						<div class="col-xs-12 col-sm-12">						
							<div class="input-group input-group-lg">
								<span class="input-group-addon">
								<i class="ace-icon fa fa-lock"></i>
								</span>
								<select class="form-control search-query" name="nome">
										<option selected="selected" value=""></option>
										<?php
												
											while($l = $c->extrair($qp)){

												echo "<option value='".$l['id']."'>".utf8_encode($l['nome'])."</option>";							
											
											}
										
										?>
									</select>
							</div>
						</div>
					</div>	

				
				<hr>
				<span class="middle">Siape:</span>		
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<i class="ace-icon fa fa-credit-card"></i>
							</span>
								<input class="form-control search-query" name="siape" placeholder="Siape" type="text" size="60" maxlength="255"/>
						</div>
					</div>
				</div>		
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						
						<span class="middle">Tipo cadastro</span>		
						<div class="radio">
							<label>
								<input class="ace" type="radio" name="tipocadastro" value="1" size="50" checked />
								<span class="lbl">SERVIDOR</span>
							</label>
							<label>														
								<input class="ace" type="radio" name="tipocadastro" value="2" size="50"/>
								<span class="lbl">EMPRESA</span>														
							</label>
							<label>														
								<input class="ace" type="radio" name="tipocadastro" value="3" size="50"/>
								<span class="lbl">CANDIDATO</span>														
							</label>
							<label>														
								<input class="ace" type="radio" name="tipocadastro" value="4" size="50"/>
								<span class="lbl">ESTAGIARIO</span>														
							</label>
						</div>
					</div>
				</div>			
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						
						<span class="middle">Tipo servidor</span>		
						<div class="radio">
							<label>
								<input class="ace" type="radio" name="tiposervidor" value="1" size="50" checked />
								<span class="lbl">DOCENTE</span>
							</label>
							<label>														
								<input class="ace" type="radio" name="tiposervidor" value="2" size="50"/>
								<span class="lbl">ADMINISTRATIVO</span>														
							</label>
						</div>
					</div>
				</div>			

				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<input class="btn btn-success btn-lg" type="submit" name="cadastrar" value="Cadastrar"/>							
						</div>
					</div>
				</div>

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

