
<?php
error_reporting(0);
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
 *      Desenvolvedor:
 *
 *      Copyright
 *
 *      Instituto Federal do Maranhao - Campus Monte Castelo
 */

	require "classes/ExecVerificaSessionClass.php";

	require "classes/classe_criptografia_url.php";
	
	require "classes/Comunicadora.php";
	
	require "classes/Normalizadora.php";

	require "../static/layout/scripts.html";


	//----------------------------------------------------------------------------
	//Controle de permissoes
	//----------------------------------------------------------------------------
	
	$nr = new Normalizadora();


	//----------------------------------------------------------------------------

	//instancia para os combos e check
	$c = new comunicadora();

	$action = "classes/RecUsuario.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="CADASTRAR";


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
  ?>

<div class="page-header">
    <h1>
        <? echo "Usu&aacute;rios [".$descrelatorio."]";?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo $descrelatorio;?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">
			<?if (in_array($_SESSION["loginiwe"],$arSA)   ){?>
			<form class="form-search" action='<?=$action ?>' method="post"	enctype="multipart/form-data" name="formcadusuario">
				<span class="middle">Nome:</span>		
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<i class="ace-icon fa fa-user"></i>
							</span>
							<input class="form-control search-query" name="nome" placeholder="Nome" type="text" size="60px" maxlength="255"/>
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
				<span class="middle">Grupo de permissão: SA: Super Administrador; O: Operador; C: Consulta.</span>		
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
							<i class="ace-icon fa fa-lock"></i>
							</span>
								<select class="form-control search-query" name="grupogestao">
									<option selected="selected" value="-1">--SELECIONE O GRUPO--</option>
										<?php
												echo "<option value='SA'>Super Administrador</option>";							
												echo "<option value='O'>Operador</option>";							
												echo "<option value='C'>Consulta</option>";							
										
												
										?>
								</select>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						
						<span class="middle">Ativar</span>		
						<div class="radio">
							<label>
								<input class="ace" type="radio" name="ativo" value="S" size="50" checked />
								<span class="lbl">SIM</span>
							</label>
							<label>														
								<input class="ace" type="radio" name="ativo" value="N" size="50"/>
								<span class="lbl">N&Atilde;O</span>														
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
			<?}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}?>
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

