<?php
class VerificaSession
{

	public function verificaSession1(){
	
		session_start();
		
		//if ($_SESSION['loginiwe']!="")

			//$token = md5($_SESSION['loginiwe']); //exit;
		
		//echo $token; //$_SESSION['loginiwe']; //exit;
		
		$codigo1 = $_SESSION['codusuarioiwe'];
	
		if($codigo1 == "") {
		   echo"<b>Carregando....</b>";
		   print "<script>document.location='index.php'</script>";
		}	
	}

}

?>
