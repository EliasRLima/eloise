<?php

include('VerificaSessionClass.php');

class ExecVerificaSession extends VerificaSession
{

	public function ExecVerificaSession(){
		
		$exeSession = new VerificaSession();
		$exeSession->verificaSession1();

	}

}
$verif = new ExecVerificaSession();

?>
