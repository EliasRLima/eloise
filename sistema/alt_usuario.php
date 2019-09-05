
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
 *      alt_usuario.php
 *      
 *      Desenvolvedor:
 *      
 *      Coordenadoria de Tecnologia da Informacao <ctic@ifma.edu.br>
 *      
 *      Copyright 2015 
 *      
 *      Instituto Federal do Maranhao - Campus Monte Castelo
 *      Coordenadoria de Tecnologia da Informacao
 *      http://www.ifma.edu.br/montecastelo/ctic
 *      
 */
	
	require "classes/ExecVerificaSessionClass.php";

	require "classes/classe_criptografia_url.php";
	
	require "classes/Comunicadora.php";
	
	require "classes/Normalizadora.php";

	require "../static/layout/scripts.html";
	
	//----------------------------------------------------------------------------
	//Controle de permissoes
	//----------------------------------------------------------------------------
	
	
	//----------------------------------------------------------------------------
	
	$coditem = @gzuncompress( base64_decode( $_GET['url'] ) );
		
	//instancia para os combos e check
	$c = new comunicadora();
	
	$nr = new Normalizadora(); //declarada em iwe/classes.php
		
	$action = "./classes/RecAltUsuario.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$descrelatorio="EDITAR";
	
	$sqlUsuario = "SELECT"; 
	$sqlUsuario .=  " id";						//0
	$sqlUsuario .=  ", login";						//1
	$sqlUsuario .=  ", ativo";
	$sqlUsuario .=  ", pessoa_id";
	$sqlUsuario .=  ", (select p.nome from pessoa p where p.id=l.pessoa_id) as nome";							//2
	$sqlUsuario .=  ", nivel";							//2
	$sqlUsuario .=  " FROM";
	$sqlUsuario .=  " login l";	
	$sqlUsuario .=  " WHERE";
	$sqlUsuario .=  " id =". $coditem;
	
	// echo $sqlUsuario; exit;
	
	 $lpu = $c->fetch($sqlUsuario); 
	 
	 $codaltusuario = $coditem;
	
	$checks = "";
	
	$checkn = "";
	
	$check = "checked";
	
	if ($lpu['ativo']==1) $checks = $check; else $checkn = $check;
		

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

				<form class="form-search" action='<?=$action ?>' method="post"	enctype="multipart/form-data" name="formaltusuario" onsubmit="return enviardados();">
					<span class="middle">Nome:</span>		
					<div class="row">
						<div class="col-xs-12 col-sm-12">						
							<div class="input-group input-group-lg">
								<span class="input-group-addon">
									<i class="ace-icon fa fa-user"></i>
								</span>
								<input class="form-control search-query" name="altnome" type="text" size="50" maxlength="255" value="<?=$lpu['nome']?>"/>
							</div>
						</div>
					</div>
					<hr>
					<span class="middle">Senha:</span>		
					<div class="row">
						<div class="col-xs-12 col-sm-12">						
							<div class="input-group input-group-lg">
								<span class="input-group-addon">
									<i class="ace-icon fa fa-user"></i>
								</span>
									<input class="form-control search-query" name="altsenha" type="text" size="15" maxlength="20 " value="<?=$lpu['login']?>"/>
							</div>
						</div>
					</div>
					<hr>	
					<span class="middle">Siape:</span>		
					<div class="row">
						<div class="col-xs-12 col-sm-12">						
							<div class="input-group input-group-lg">
								<span class="input-group-addon">
									<i class="ace-icon fa fa-user"></i>
								</span>
									<input class="form-control search-query" name="altsiape" type="text" size="15" maxlength="20 " value="<?=$lpu['login']?>"/>
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
								<select class="form-control search-query" name="altgrupogestao">
										<option selected="selected" value="<? echo $lpu['nivel']; ?>"><? echo $lpu['nivel'];?></option>
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
						<span class="midle">Ativo:</span>						
								<div class="radio">
									<label>
										<input type="radio" name="altativo" value="1" size="50" <?php echo $checks; ?> />
										<span class="lbl">SIM</span>
									</label>
									<label>
										<input type="radio" name="altativo" value="0" size="50"<?php echo $checkn; ?> />
										<span class="lbl">N&Atilde;O</span>		
									</label>
					
								</div>
						</div>			
					</div>
					<input name="datacadastro" type="hidden" />
					<input name="horacadastro" type="hidden" />

					<input type="hidden" name="msgdestino" value="../sistema/alt_usuario.php"/>
					<input type="hidden" name="codaltusuario" value="<?=$codaltusuario?>"/>
					
					<div class="row">
						<div class="col-xs-12 col-sm-12">						
							<div class="form-actions center">
								<input type="submit" class="btn btn-success btn-lg" name="cadastrar" value="Alterar"/>				
								<a href='<? echo "sel_conteudo.php?url=".doCodifica(5); ?>' ><input  class="btn btn-info btn-lg" type="button" name="voltar" value="Voltar" />
								</a>			
							</div>
						</div>
					</div>		
				
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