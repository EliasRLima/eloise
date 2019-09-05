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
 *      edi_empresa.php
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
	//TODO:Controle de permissoes
	//----------------------------------------------------------------------------



	//----------------------------------------------------------------------------
	$nr = new Normalizadora();

	//instancia para os combos e check
	$c = new comunicadora();

	$crud = new Crud(); 
	
	$gui = new Gui(); 
	
	$cpessoa = new CPessoa(); 	
	$action = "classes/upd_pessoa.php";
	$impar = "#FFFFFF";
	$par = "#CCCCCC";
	$impar = $par;
	$fundo = "#006400";
	$colspan ="3";
	$siape = "";
	$descrelatorio="Inativar";	
	$lbbtnsubmit="Atualizar";


//.CONFIGURACOES BASICAS

//MENU

include ('../static/layout/layout_menu_nav.php');

//.MENU

//CONTEUDO 




?>

    
<?php //require "../static/layout/estilos.html";?>   
     
<?php //require "../static/layout/scripts.html";?>

<?php include ('../static/layout/layout_icontent_breadcrumbs.php');



 	if (in_array($_SESSION["loginiwe"],$arSA)   ){
	$inf->doDecodifica($_GET['url']);

	$id = $_GET['_id'];  //echo "=>".$id; exit;
	$obs = $_POST['obs']; //echo "=>".$obs; exit;

	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");

	$query = "insert into pessoa_inativos (select * from pessoa where id = '".$id."');";
	//echo "=>".$query;exit();
	@mysqli_query($link,$query);

	$query = "update pessoa_inativos set observacao = '".$obs."' where id = '".$id."';";
	@mysqli_query($link,$query);

	//echo "Movido!";

	$query = "delete from estagiario where id = '".$id."' and id in (select id from pessoa_inativos);";
	@mysqli_query($link,$query);
	$query = "delete from empresa where id = '".$id."' and id in (select id from pessoa_inativos);";
	@mysqli_query($link,$query);
	$query = "delete from servidor where id = '".$id."' and id in (select id from pessoa_inativos);";
	@mysqli_query($link,$query);
	$query = "delete from pessoa where id = '".$id."' and id in (select id from pessoa_inativos);";
	@mysqli_query($link,$query);

	$query = "select 1 from pessoa where id = '".$id."'";
	$resultado = @mysqli_query($link,$query);
	$num_rows = @mysqli_num_rows($resultado);

	if($num_rows < 1){
		echo"<script language='javascript' type='text/javascript'>alert('Pessoa removida com sucesso!');window.location.href='sm_busca_novo_inativo.php'</script>";
	
	}
	else{
		$query = "delete from pessoa_inativos where id = '".$id."';";
		@mysqli_query($link,$query);
		echo"<script language='javascript' type='text/javascript'>alert('Pessoa nao removida devido possuir estagio!');window.location.href='sm_busca_novo_inativo.php'</script>";
	
	}
	//echo "removido!";

		
	}else{ echo "Sistema anti-link SVTR_ foi bem ativado!";}
	?>


    <!-- PAGE CONTENT ENDS -->
</div><!-- /.cols -->
<?php include ('../static/layout/layout_fcontent.php');  ?>

<?php

//RODAPE

include ('../static/layout/footer_fhtml.html'); 

//.RODAPE


?>
<script src="../static/layout/assets/js/jquery.mask.min.js"></script>