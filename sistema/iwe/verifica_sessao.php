<?
session_start();

echo "USUARIO: ".$_SESSION['codusuarioiwe']."<p>";
echo "LOGIN: ".$_SESSION['loginiwe'];

if(!isset($_SESSION['codusuarioiwe']) || !isset($_SESSION['loginiwe'])){
	
	
	header("avisar.php?msg=Usuário não autenticado!");


}

?>
