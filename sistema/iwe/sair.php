<? header("cache-control:no-cache, no-store , must-revalidate");?>
<?
	session_start();

	$user = $_SESSION['loginiwe'];
	
	unset($_SESSION['codusuarioiwe']);

	unset($_SESSION['loginiwe']);

	//grava o log de saida do usuario
	
	include("../classes/Comunicadora.php");

	include("../classes/Crud.php");	
	
	include("../classes/Log.php");	

	include("../classes/Normalizadora.php");


	$crud = new Crud();

	$log = new Log();

	$c = new comunicadora();


	$log->gravarLog(
							$c						
							,"LOGOUT ELOISE"
							,"18" //user
							,date('Y-m-d')
							,date('H:i:s')
							,"ELOISE" //tipo usuario
							,$idbolsista=""
							,$tipooperacao="LOGOUT MODULO AUTENTICADOR"
							,$user  //DEFAULT CPF
							,0
							,0
							);



	// $crud->notify($c
	// 				  ,$msger
	// 				  ,$log
	// 				  ,$instrucao
	// 				  ,$resinstrucao
	// 				  ,$pathheader
	// 				  ,$cryptoheader="-1"
	// 				  ,$tabelahash="pessoa"
	// 				  ,$chavehash=$_REQUEST["cadastro"]//FIXME
	// 				  ,$login=$user	
	// 				  ,$tipooperacao=1
	// 				  ,$tipousuario=2 //TODO: ler do bd
	// 				  ,$msgalerta
	// 				  ,$metodo=0
	// 				  ,$viewsql=1
	// 				  );	


	
	session_destroy();
	header("Location: entrar.php");
	
?>
