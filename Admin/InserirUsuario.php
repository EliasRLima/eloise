<?php 
 
$login = $_POST['login'];
$autenticador = $_POST['autenticador'];
$senha = MD5($_POST['senha']);
$connect = @mysql_connect('LocalHost','root','');
$db = @mysql_select_db('eloisebd');

 
  if($login == "" || $login == null){
    echo"<script language='javascript' type='text/javascript'>alert('O campo login deve ser preenchido');window.location.href='inserirUsuario.html';</script>";
    }
  else{
        $query = "INSERT INTO login (login,senha,autenticador,pessoa_id,nivel) VALUES ('$login','$senha','$autenticador','1','1')";
        $insert = @mysql_query($query,$connect) or die(mysql_error());
         
        if($insert){
          echo"<script language='javascript' type='text/javascript'>alert('Usuario cadastrado com sucesso!');window.location.href='inserirUsuario.html'</script>";
        }else{
          echo"<script language='javascript' type='text/javascript'>alert('Nao foi possível cadastrar esse usuario');window.location.href='inserirUsuario.html'</script>";
        }
      
    }
?>