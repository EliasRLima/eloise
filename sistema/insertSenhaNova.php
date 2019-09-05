


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
	$descrelatorio="Nova senha";

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
				
				$usuario = utf8_encode($_SESSION['dispname']);
				$senha = $_POST['senhaOld'];
				$senha1 = $_POST['senhaNew'];
				$senha2 = $_POST['senhaNew2'];//echo "=>".$senha." =>".$senha1." =>".$senha2;exit();
				if($senha1 == $senha2){
					$senhaCPT = sha1($senha); 
					$senhaNew = sha1($senha1);
					//echo "=>".$senha1."=>".$senhaNew;exit();
					$query = "select login,senha from login";
					//echo $query;exit();
				
					$resultado = @mysqli_query($link,$query);
					$num_rows = @mysqli_num_rows($resultado);
					$linha = @mysqli_fetch_assoc($resultado);

					if($num_rows > 0){
						$aux = 0;
						do {
				     		if($aux == 0){
				     			if($linha['login']==$usuario and $linha['senha']==$senhaCPT){
				     			$queryUPD = "update login set senha = '".$senhaNew."' where login = '".$usuario."';";
				     			//echo $queryUPD;exit();
				     			$resutado = @mysqli_query($link,$queryUPD);
				     			$aux = 1;
				     			}
				     		}
						}while ($linha = @mysqli_fetch_assoc($resultado) /*and $controlador<50*/);
						if($aux == 1){
							echo"<script language='javascript' type='text/javascript'>alert('Usuario atualizado com sucesso!');window.location.href='trocarSenha.php'</script>";
						}elseif($aux == 0){
							echo"<script language='javascript' type='text/javascript'>alert('Senha atual incorreta!');window.location.href='trocarSenha.php'</script>";
						}else{
							echo"<script language='javascript' type='text/javascript'>alert('Erro!');window.location.href='trocarSenha.php'</script>";
						}
					}
				}
				else{
					echo"<script language='javascript' type='text/javascript'>alert('Falha ao confirmar senha!');window.location.href='trocarSenha.php'</script>";
				}
				
	//echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='login.html'</script>";
?>
			 <div class="row">
					<div class="col-xs-12 col-sm-12">						
						<div class="form-actions center">
							<a href="relatorio_menu.php" name="msgdestino"/>
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

