
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
 *      relatorios.php
 *
 *      Copyright 2014 cti-mcast <ctic@ifma.edu.br>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 * 		ULTIMA ATUALIZACAO: 27-12-2016
 */


	require "classes/ExecVerificaSessionClass.php";

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
    //XXX:atencao que o estilo em cascata da 
    //classe mensageira esta influenciando a fonte
	require "classes/Comunicadora.php"; 

	require "classes/Normalizadora.php";

	$action = "relatorios.php";

	$nmform = "relatorios";

	$c = new comunicadora();

	$nr = new Normalizadora();

	//MENU

	include ('../static/layout/layout_menu_nav.php');

	//.MENU

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

				
	$inf->doDecodifica($_GET['url']);


	$filtro = strip_tags($_GET['_filtro']); 
	
	$papel = strip_tags($_GET['_papel']); 


	$descplaceholder = "";

	if ($filtro==0)

		$descrelatorio ="geral";

	if ($filtro==2)

		$descrelatorio ="Digite o nome da empresa e clique em buscar";

	if ($filtro==3)

		$descrelatorio ="Digite o nome do servidor e clique em buscar";

	if ($filtro==4)

		$descrelatorio ="Digite o nome da pessoa e clique em buscar";

	$descplaceholder = $descrelatorio;
	
	if ($filtro==1){

		$descplaceholder = "Digite um nome do aluno e clique em buscar";

		$descrelatorio ="Alunos - ".$descplaceholder;
	
	}

	$pagina = "Consulta";

//.CONFIGURACOES BASICAS



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
        <? echo $pagina;?>        
    </h1>
</div><!-- /.page-header --> 


<div class="widget-box">
	<div class="widget-header widget-header-small">          
		<h5 class="widget-title lighter"><?php echo $descrelatorio;?></h5>
	</div>
	<div class="widget-body">
		<div class="widget-main">
	
			<form class="form-search" id="<?php echo $nmform; ?>" name="<?php echo $nmform; ?>" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

			<?php

			if (in_array($_SESSION["loginiwe"],$arSA)   ){ 

			if($filtro==0){

			$irelatorio   = "select ";
			$irelatorio  .= "id ";
			$irelatorio  .= ",tipo_papel ";
			$irelatorio  .= ",tipo_cadastro ";
            $irelatorio  .=" * from pessoa";
            
            $consulta = $c->enviar($irelatorio);


			$table_titulo = "";

            echo "<table border='0'>";

            $table_titulo .="<tr class='titulo-padrao'>";
            $table_titulo .="<td>#</td>";
            $table_titulo .="<td align='center'>Acessos</td>";
            $table_titulo .="<td align='center'>Matrícula</td>";
            $table_titulo .="<td>Aluno</td>";
            $table_titulo .="<td align='center'>Registro</td>";
            $table_titulo .="<td align='center'>Data</td>";
            $table_titulo .="</tr>";

            echo $table_titulo;
            
          	$nomcursista = "";

            while($l = $c->extrair($consulta)){




                if(($ordem % 2) == 0){

                     $cor = 'row1';

                     if ($l['acessos']==2) $cor .= ' alerta'; else if ($l['acessos']>=3) $cor .= ' excedido';

                }
                else{
                     $cor = 'row2';

                     if ($l['acessos']==2) $cor .= ' alerta'; else if ($l['acessos']>=3) $cor .= ' excedido';

                }

                ++$ordem;

                echo "<tr class='$cor'>";
                echo "<td class='label'>".$l['id']."</td>";
                echo "<td class='label' align='center'>".$l['acessos']."</td>";
                echo "<td class='label' align='center'>".$l['matricula']."</td>";
                echo "<td class='label'>".iconv('iso-8859-1', 'utf-8', $l['aluno'])."</td>";
                echo "<td class='label' align='center'>".$l['registro']."</td>";
                echo "<td class='label' align='center'>".$nr->normalizarData($l['data'],5)." | ".$l['hora']."</td>";
                echo "</tr>";


               
            }

            echo "</table>";
            echo $c->row($irelatorio)." Registro(s)";


				} else {
			?>




			<div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div id="box-barras" class="input-group input-group-lg">
							<span class="input-group-addon">
								<i class="ace-icon fa fa-check"></i>
							</span>
							<input type="text" class="form-control search-query" placeholder="<?php echo $descplaceholder; ?>" value="<?=strip_tags($_GET['consulta'])?>" name="matricula" id="matricula"/>
							
							<span class="input-group-btn">								
								<a href="#" name="btBuscar_" id="btBuscar" class="btn btn-success btn-lg"/>
								
								<i class='fa fa-search'></i>&nbsp;Buscar
								</a>
							</span>
						</div>
					</div>
			</div>
			 <input type="hidden" name="siape_" value="<?=$_SESSION['loginiwe']?>"/>
			 <input type="hidden" name="login_" value="<?=$_SESSION['dispname']?>"/>
			 <input type="hidden" name="filtro" id="filtro_" value="<?=$filtro ?>"/>
			 <input type="hidden" name="palpel" id="papel_" value="<?=$papel ?>"/>

			


			<br/>
			<img src="../static/img/processing.gif" id="loader"  style="display:none; color: black; padding-top:350px;"/>
                        
			<div id="destino"></div>
			

			<div id="pdf"> </div>	

			

			<?php
			}

			}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}

			?>
		
			<?php 
			$filtro = 0;
			$url="_filtro=".$filtro;?>

				
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
