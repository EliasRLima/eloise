<!doctype html>
<html lang="pt-br">
<head>

	<noscript>
		<div align="center">Aviso! O JavaScript deve estar habilitado para o correto funcionamento.	</div>
	</noscript>
					
    <meta charset="iso8859-1" />

    <title>ELOISE - Login</title>
    
    
    <?php include "../../static/layout/estilos.html";?>   
    
     
    <?php include "../../static/layout/scripts.html";?>    

    <script src="../../static/layout/assets/js/jquery-2.1.4.min.js"></script>
    <script>

		$(document).ready(function(){

			$(window).load(function(){

				$("#loginiwe").focus();	


			}); //.windown.load



		});//.document.ready	

	</script>
<link rel="stylesheet" type="text/css" href="../../static/css/fonts/MonteCristo/font.css">
<link rel="stylesheet" type="text/css" href="../../static/css/login.css">

</head>


<body>
 
<div id="fundo-externo">
    <div id="fundo">
    
	</div>
</div>
<div id="site">			
<main></main>
           <div class="content">
			<div class="logo"></div>						
				<div class="getForm">
						<p id="titulo">Eloise</p>
						<p>Gerenciador </p>				   	
								<form name="form1" class="form1" action="autho.php" method="post">										
									<label class="cx-label" id="matricula">Digite sua <span>MATR&Iacute;CULA</span> siape</label>
									<div class="cx-texto">
										<input class="user" id="loginiwe" name="loginiwe" type="text" title="SIAPE">
									</div>
									<div id="clear"></div>									
									
									<label class="cx-label" id="senha" >Senha</label>
									<div id="clear"></div>
								
									<input class="pass" name="senha" type="password" value="" title="Senha">
									
									<input class="enter" type="submit" value="Entrar">
									<div id="clear"></div>
								</form>
				</div>								
		   </div>
</div><!-- .site --> 
<div id="clear"></div>


<div class="footer">
    <p>&copy; ELOISE 2017-<?php echo date('Y'); ?> - Desenvolvido por <a href="http://montecastelo.ifma.edu.br/" target="_blank">IFMA</a></p>
</div><!-- .footer -->
</body>
</html>
