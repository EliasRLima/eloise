
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
 *      seletora.php
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 */


	require "classes/ExecVerificaSessionClass.php";

	// require "classes/classe_criptografia_url.php";

	//require "../static/layout/estilos.html";

	require "../static/layout/scripts.html";

	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');

	?>

	<script type="text/javascript">	
			function setFocus() {
		document.relatorios.matricula.select();
		document.relatorios.matricula.focus();
	}

	$(document).keypress(function(e) {
	    if(e.which == 13) 
	    	//HACK
	    	//XXX
	    	return false;
	    
	});

  	$(document).ready(function(){

		$("#btBuscar").click(function(){ 
	      
	            var m = $('#matricula').val();
	            var f = $('#filtro_').val();
	            var p = $('#papel_').val();
	           
	            <?php 
	            //XXX:RECONFIGURAR CODIFICACAO
	            //PARA NOMES COM ACENTUACAO
	             ?>

  		$.ajax({
                 type: "get"
                 , url: "listagem.php"
                 , data: "_nomcursista="+m+"&_filtro="+f+"&_papel="+p
	             , beforeSend: function(){
                     $("#btBuscar").text("Processando...");   
                     $("#btBuscar").attr("class", "btn btn-warning");
                     
                 } 
                 , complete: function(){ 

                 }  
                 , success: function(data){ 
                    $("#btBuscar").text("Buscar");   
                    $("#btBuscar").attr("class","btn btn-success btn-lg");                        
                    $('#destino').html(data);	                 
                    $("#matricula").val("");                        
                 }
                 , error: function(){ 
                 }  
                    
             });

	 	});
	});
    </script>

    <?
    //XXX:O estilo em cascata da classe mensageira esta influenciando a fonte
	require "classes/Comunicadora.php"; 

	require "classes/Normalizadora.php";
	
	require "classes/Gui.php";

	require "classes/Crud.php";

	$actionEdi = "relatorios.php";

	

	$nmform = "relatorios";

	

	$c = new comunicadora();

	$nr = new Normalizadora();
	
	$gui = new Gui();

	$crud = new Crud();

	$listar = 1;

	//MENU

	include ('../static/layout/layout_menu_nav.php');

	//.Atualiza situacao auto

 	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
	$qdata = @mysqli_query($link,$queryd);
	$data = @mysqli_fetch_assoc($qdata);
	$data = $data['ano']."-".$data['mes']."-".$data['dia'];


	$query = "select id,situacao_estagio,data_termino,data_inicio,(select nome from pessoa where id = estagiario_id) as estagiario,(select nome from pessoa where id = empresa_id) as empresa from estagio";

				//echo $query;exit();
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<?
				// se o número de resultados for maior que zero, mostra os dados
				if($num_rows > 0) {
				// inicia o loop que vai mostrar todos os dados	

					do {
					
						if(strtotime($data) > strtotime($linha['data_inicio']) and strtotime($data) < strtotime($linha['data_termino'])){
  							if($linha['situacao_estagio'] != 1 and $linha['situacao_estagio'] != 3 and $linha['situacao_estagio'] != 4){
  								$queryUPD = "update estagio set situacao_estagio = 1 where id = '".$linha['id']."';";
  								@mysqli_query($link,$queryUPD); 
  							}
  						}
  						elseif(strtotime($data) > strtotime($linha['data_termino'])){
  							if($linha['situacao_estagio'] != 2 and $linha['situacao_estagio'] != 3 and $linha['situacao_estagio'] != 4){
  								$queryUPD = "update estagio set situacao_estagio = 2 where id = '".$linha['id']."';";
  								@mysqli_query($link,$queryUPD); 
  							}
  						}

					}while ($linha = @mysqli_fetch_assoc($resultado));
					# code...
				}
				else{
					//echo "Estagio nao localizado!";
				}
	//echo "<script language='javascript' type='text/javascript'>alert('Atualizado!');window.location.href='verificaDatasEstagio.php'</script>";
	

	//.MENU

	
	$inf->doDecodifica($_GET['url']); //echo $inf; exit;
	
	$arSituacaoEstagio = $gui->renderSituacaoEstagio($c, $crud);
	
	$filtro = $_GET['_filtro']; //echo $filtro; exit;
	
	$papel = $_GET['_papel']; //echo $filtro; exit;

	if($papel==3){
		$action = "edi_aluno.php";
	}
	elseif($papel==1){
		$action = "edi_servidor.php";
	}
	else{
		$action = "edi_pessoa.php";
	}
	
	//XXX
	$idretorno = $_GET['_idretorno']; //echo $filtro; exit;

	$instrucaoRetorno = 0;

	if(is_numeric($idretorno)){
		
		$filtro = 4; 

		$instrucaoRetorno =1;

	} 
	//.XXXX
	$tituloPagina = "Informações";

	if ($filtro==0){

		$descrelatorio ="Dados gerais";

	}
	elseif ($filtro==1){

		$descrelatorio ="Todos os dados"; //sem efeito aqui
	}

	elseif  ($filtro==2){

		$descrelatorio ="Buscar mais empresas";
		$pagina = "Informações das Empresas";
		$botaoBuscar = "buscar outras empresas";
	}

	elseif ($filtro==3){

		$descrelatorio ="buscar mais servidores";
		$pagina = "Informações de servidores";
		$botaoBuscar = "buscar outros servidores";	

	}

	elseif ($filtro==4){
		$descrelatorio = "Buscar mais estágios";
		$pagina = "Informações de estágios";
		$botaoBuscar = "buscar outros estagiarios";
	}
	
	elseif($filtro==5){
		
		$descrelatorio ="Buscar mais cursos";
		$pagina = "Informações de Cursos";
	}
	
	elseif ($filtro==99){

		$pagina ="Usuários";
		$descrelatorio ="Editar";
		$botaoBuscar = "buscar outros Usuários";
	}

	


//.CONFIGURACOES BASICAS

//MENU-DESLOCADO

//include ('../static/layout/layout_menu_nav.php');

//.MENU

//CONTEUDO 


//NOFIFICACAO



//./NOFIFICACAO

?>

    
<?php //require "../static/layout/estilos.html";?>   
     
<?php require "../static/layout/scripts.html";?>   

<?php include ('../static/layout/layout_icontent_breadcrumbs.php');  ?>


 <div class="col-xs-12">
 <!-- PAGE CONTENT BEGINS -->

<div class="page-header">
    <h1>
        <? echo $tituloPagina;?>        
    </h1>
</div><!-- /.page-header --> 

<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo "$pagina";?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">
	
			<form class="form-search" id="<?php echo $nmform; ?>" name="<?php echo $nmform; ?>" action="<?php echo $actionEdi; ?>" method="post" enctype="multipart/form-data">

			<?php

			if (in_array($_SESSION["loginiwe"],$arSA)   ){ 
			
			 $arTitulo = array(
	            				  1=>"ID"	
	            				 ,2=>"Nome"	
	            				 ,3=>"Empresa"	
	            				 ,4=>"Matrícula"	
	            				 ,5=>"Situação"	
	            				 );
			 

			$colunas  =" p.id";
			$colunas .=" ,p.nome";
			$colunas .=" ,p.tipo_cadastro";
			$colunas .=" ,p.tipo_papel";
	        
	        $tabela =" vw_pessoa p";
	        

			if($listar){


				$instrucao  = "select ";
	            $instrucao .= $colunas;
	            $instrucao .=" from";
	            $instrucao .= $tabela;
					
				if($filtro==1){//pessoa
	            	$arTitulo = array(
	            		  1=>"ID"
	            		 ,2=>"Nome"
	            		 ,3=>"CPF"
	            		 ,4=>"Sexo"
	            		 ,5=>"Curso"
	            		);
	            	$instrucao  = "select p.id,p.nome as nome,p.cadastro as empresa,p.sexo as matricula,(select descricao from curso where p.curso_id = curso.id) as situacao_estagio from pessoa p";
	            	$instrucao .=" where";
	            	$instrucao .=" tipo_cadastro in(3)";
	            	$instrucao .=" and tipo_papel in($papel)";
	            	$instrucao .=" group by p.nome LIMIT 10";

					
				}
				if($filtro==2){ //empresa
	            	$arTitulo = array(
	            				  1=>"ID"	
	            				 ,2=>"Nome"	
	            				 ,3=>"Nome fantasia"	
	            				 ,4=>"CNPJ"	
	            				 ,5=>"Área de interesse"	
	            				 );
	            	$instrucao  ="select p.id,p.nome as nome,p.nome_fantasia as empresa,p.cadastro as matricula,p.areas_interesse as situacao_estagio from pessoa p";
	            	$instrucao .=" where";
	            	$instrucao .=" tipo_cadastro in(2)";
	            	$instrucao .=" and tipo_papel in($papel)";
	            	$instrucao .=" order by p.nome";
				
				}
				if($filtro==3){//servidor
					$arTitulo = array(
	            				  1=>"ID"	
	            				 ,2=>"Nome"	
	            				 ,3=>"Sexo"	
	            				 ,4=>"CPF"	
	            				 ,5=>"Observacao"	
	            				 );
					$instrucao = "select pessoa.id,pessoa.nome as nome,sexo as empresa,pessoa.cadastro as matricula,pessoa.observacao as situacao_estagio from pessoa";
					$instrucao .=" where";
	            	$instrucao .=" tipo_cadastro in(1)";
	            	$instrucao .=" and tipo_papel in(1)";
	            	$instrucao .=" group by pessoa.nome";

				}
				if($filtro==5){//curso
					$arTitulo = null;
					$arTitulo = array(
	            				  1=>"ID"	
	            				 ,2=>"Curso"	
	            				 ,3=>"Setor"	
	            				 ,4=>"Carga horária(horas)"	
	            				 ,5=>"Necessidade"	
	            				 ); 
					$newInstrucao = "select setor.sigla as empresa,curso.descricao as nome,curso.id as id,curso.carga_horaria as matricula,curso.estagio_necessidade as situacao_estagio from curso,setor where curso.setor_id = setor.id order by setor.sigla asc";
					$instrucao = $newInstrucao;
					
				
				}
				if($filtro==4){ //para atender o menu supervisao estagiario
	            	$instrucao = "";


	            	$instrucao  =" SELECT";
	            	$instrucao .= $colunas;
	            	$instrucao .=" ,(select nome from pessoa p1 where p1.id=e.empresa_id) as empresa";
	            	$instrucao .=" ,situacao_estagio";
	            	$instrucao .=" ,empresa_id";
	            	$instrucao .=" ,e.id as id_estagio";
	            	$instrucao .=" ,e.servidor_id";
	            	$instrucao .=" ,e.estagiario_id";
	            	$instrucao .=" ,e.matricula";
	            	$instrucao .= " from";
	            	$instrucao .= $tabela;
	            	$instrucao .=" ,estagio e";
	            	$instrucao .=" where";
	            	$instrucao .=" e.estagiario_id=p.id";
	            	$instrucao .=" and p.tipo_cadastro in(1,3)"; 
	            	$instrucao .=" and p.tipo_papel in(3)";
	            	
	            	if($instrucaoRetorno) $instrucao .=" and p.id=".$idretorno;

	            	$instrucao .=" order by p.nome asc";
				
				}
				//XXX
				if($filtro==99){ //para atender o retorno de edi_usuario
	            	
	            	$instrucao = "";

	            	$instrucao = "SELECT"; 
					$instrucao .=  " id";						//0
					$instrucao .=  ", login as nome";						//1
					$instrucao .=  ", ativo as situacao_estagio";						//2		
					$instrucao .=  ", nivel as empresa";							//3
					$instrucao .=  ", autenticador as matricula";							//3
					$instrucao .=  ", pessoa_id";							//3
					$instrucao .=  " FROM";
					$instrucao .=  " login";

					$arTitulo = null;
					$arTitulo = array(
	            				  1=>"#"	
	            				 ,2=>"Nome"	
	            				 ,3=>"Nível"	
	            				 ,4=>"Siape"	
	            				 ,5=>"Ativo"	
	            				 );
		
	            	
	            	
					// echo $instrucao; exit;
				}
				//.XXX

	        
            	// echo  $instrucao; exit;
            	$consulta = $c->enviar($instrucao);
            	//echo $consulta;exit;

            
	            

	            if($filtro==1){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div id="box-barras" class="input-group input-group-lg">
							
							<span class="input-group-btn">
							 <?php $url="_filtro=".$filtro.",_papel=".$papel."";?>
              				    <a href="relatorios.php?url=<?php echo $inf->doCodifica($url)?>" name="btBuscar_" id="btBuscar" class="btn btn-success btn-lg"/>
								<i class='fa fa-search'></i>&nbsp;buscar outros candidatos
								</a>
							</span>
						</div>
					</div>
				</div>
				<?}?>

			<?
	            if($filtro==2){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div id="box-barras" class="input-group input-group-lg">
							
							<span class="input-group-btn">
              				    <a href="sm_empresa.php" name="btBuscar_" id="btBuscar" class="btn btn-success btn-lg"/>
								<i class='fa fa-search'></i>&nbsp;buscar outras empresas
								</a>
							</span>
						</div>
					</div>
				</div>
				<?}?>


			<?
				 if($filtro==4){?>
				<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div id="box-barras" class="input-group input-group-lg">
							
							<span class="input-group-btn">
              				    <a href="sm_busca_estagiario.php" name="btBuscar_" id="btBuscar" class="btn btn-success btn-lg"/>
								<i class='fa fa-search'></i>&nbsp;buscar outros estagi&aacute;rios
								</a>
							</span>
						</div>
					</div>
				</div>
				<?}?>

			<?	
				if($filtro==99){?>
				<!--<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div id="box-barras" class="input-group input-group-lg">
							
							<span class="input-group-btn">
							 <?php $url="_filtro=".$filtro.",_papel=".$papel."";?>
              				    <a href="relatorios.php?url=<?php echo $inf->doCodifica($url)?>" name="btBuscar_" id="btBuscar" class="btn btn-success btn-lg"/>
								<i class='fa fa-search'></i>&nbsp;buscar outros Usuários
								</a>
							</span>
						</div>
					</div>
				</div>-->
				<?}?>

				<?

				echo "<table id='dynamic-table' class='table table-bordered table-hover'>";

	            echo $gui->renderTabelaSeletora($c
	            								,$inf
											    ,$arTitulo
											    ,$espacoClassTitulo="class='center'"
											    ,$arDetalhes=$consulta
											    ,$espacoClassDetalhes
											    ,$tipo_papel=$papel
											    ,$arSituacaoEstagio
											    );


	            ?><input type="hidden" name="siape_" value="<?=$_SESSION['loginiwe']?>"/>
			    <input type="hidden" name="login_" value="<?=$_SESSION['dispname']?>"/>



				<br/>
				<img src="../static/img/processing.gif" id="loader"  style="display:none; color: green; padding-top:350px;"/>
                        
				<div id="destino"></div>	
			
				<div id="pdf"></div>
			<?
				} else {
			?>
			
			<?if($filtro!=5){?>
			<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div id="box-barras" class="input-group input-group-lg">
							<span class="input-group-addon">
								<i class="ace-icon fa fa-check"></i>
							</span>
							<input type="text" class="form-control search-query" placeholder="<?php echo $descrelatorio; ?>" value="<?=$_GET['consulta']?>" name="matricula" id="matricula"/>
							
							
							<span class="input-group-btn">								
								<a href="#" name="btBuscar_" id="btBuscar" class="btn btn-success btn-lg"/>
								
								<i class='fa fa-search'></i>&nbsp;Buscar
								</a>
							</span>
						</div>
					</div>
			</div>
			<?}?>
			 <input type="hidden" name="siape_" value="<?=$_SESSION['loginiwe']?>"/>
			 <input type="hidden" name="login_" value="<?=$_SESSION['dispname']?>"/>
			 <input type="hidden" name="filtro" id="filtro_" value="<?=$filtro ?>"/>

			


			<br/>
			<img src="../static/img/processing.gif" id="loader"  style="display:none; color: green; padding-top:350px;"/>
                        
			<div id="destino"></div>	
			
			<div id="pdf"></div>	

			

			<?php
			}
			}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
			?>
			
			<?php 
			$url="_filtro=".$filtro;
			?>	

				
			</form>







		</div>
	</div>
</div>

	




<!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<?php include ('../static/layout/layout_fcontent.php');  ?>
<?php
//RODAPE
include ('../static/layout/footer_fhtml.html'); 
//.RODAPE
?>
