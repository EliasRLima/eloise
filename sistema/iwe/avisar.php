<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>Usuário não autenticado</title>
	   
	   <link rel="stylesheet" href="../css/mensagens.css">
</head>
<?
$destino = "entrar.php";
if(!$_GET['msg']){
	$msg = "SIAPE ou SENHA Incorretos !";
	}

?>
<body onLoad="document.form1.botao.focus();">
<form name="form1" id="contorno_form">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div align="center">
  <table width="37%" border="0" align="center"  class="error">
  <tr>
    <td colspan="3" align="center"><strong><p><?= $msg ?>&nbsp;</p></strong></td>
  </tr>
  <tr>
    <td width="45">&nbsp;</td>
    <td width="66">&nbsp;</td>
    <td width="142">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input name="botao" type="button" class="labelazul" onClick="window.location.href = '<?= $destino ?>'; " value="Tentar Novamente"></td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
</table>
</div>
</form>
</body>
</html>
