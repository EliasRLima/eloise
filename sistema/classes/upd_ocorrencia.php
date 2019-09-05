

<?php




	require "ExecVerificaSessionClass.php";

	require "Comunicadora.php";

	require "Normalizadora.php";

	include("Crud.php");	
	
	include("CPessoa.php");	
	
	include("Log.php");	

	include("Informadora.php");	
	
	$c = new comunicadora();
	
	$nr = new Normalizadora();

	$crud = new Crud();
	
	$cpessoa = new CPessoa();

	$log = new Log();

	$msger = new Mensageira();

	$inf = new Informadora();

	//abstrato
	//raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql)
	//$c: conexao;
	//$metodo: 0 - returns enviar;
	//$metodo: 1 - returns row;
	//$metodo: 2 - returns fetch;
	//$metodo: 2 - returns instrucao sql;
	//$viewsql:0 - oculta sql; 1 - exibe sql e para; 2 - returns sql
	//public function raw_sql($c, $instrucao,  $metodo, $retorno,  $viewsql) 


	//TODO: ENVIAR PARA METODO DE VALIDACAO
	$values = array();

	$properties = array();

	$validado = 1;

	$msgalerta ="";


	$id_ocorrencia = $_REQUEST['id_ocorrencia'];
	//echo "=>".$id_ocorrencia; exit();
	//ajax: ac_idpessoa.php
	$pessoa_nome = $_REQUEST['estagiario_id'];
	//echo $pessoa_nome;exit();
  	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
  	$query = "SELECT id from pessoa where nome like '".$pessoa_nome."%' and id in (select id from estagiario);";
  	$resultado = @mysqli_query($link,$query);
  	$num_rows = @mysqli_num_rows($resultado);
 	if($num_rows != 1){
 		if($num_rows < 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Estagiario nao localizado!');window.location.href='edi_ocorrencia.php'</script>";
 		}
 		if($num_rows > 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Mais de um estagiario localizado!');window.location.href='edi_ocorrencia.php'</script>";
 		}
 	}
 	$linha = @mysqli_fetch_assoc($resultado);
  	$idEstagiario = $linha['id'];


  	$pessoa_nome = $_REQUEST['servidor_id'];
  	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
  	$query = "SELECT id from pessoa where nome like '".$pessoa_nome."%' and id in (select id from servidor);";
  	$resultado = @mysqli_query($link,$query);
  	$num_rows = @mysqli_num_rows($resultado);
 	if($num_rows != 1){
 		if($num_rows < 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Servidor nao localizado!');window.location.href='edi_ocorrencia.php'</script>";
 		}
 		if($num_rows > 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Mais de um servidor localizado!');window.location.href='edi_ocorrencia.php'</script>";
 		}
 	}
 	$linha = @mysqli_fetch_assoc($resultado);
  	$idServidor = $linha['id'];

	//echo $data;exit(); 

	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(

							'msgdestino'
							,'cadastrar'
							,'datacadastro'
							,'horacadastro'
							,'atualizar'
							,'id_ocorrencia'
							);

	$arkeysignoradas = array(

							'msgdestino'
							,'cadastrar'
							,'horacadastro'
							,'atualizar'
							,'id_ocorrencia'

							);
	

	
	//.hack
	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";






	foreach ($_REQUEST as $ptag => $vtag) {
		
		//echo $ptag."=".$vtag."<p>"; 

		if( ( !in_array($ptag, $arptagsignoradas) ) ){


			

			if( (empty($vtag) || ($vtag=="-1") || ($vtag=="") || ($vtag==NULL) )  ){
			
				$validado = 0;
				
				$msgalerta .= "Preencha o campo: ";

				$msgalerta .=" ".$ptag."</p>";	


			}elseif($ptag=="estagiario_id"){

				$properties[] = "estagiario_id";

				$values[] = $idEstagiario;					


			}elseif($ptag=="servidor_id"){

				$properties[] = "servidor_id";

				$values[] = $idServidor;					


			}elseif($ptag=="data_ocorrencia"){

				$properties[] = $ptag;

				$values[] = $nr->normalizarData($vtag,16);					


			}else{
					
					$properties[] = $ptag;

					$values[] = $vtag;					
			}

			
	}else{

				if( ( !in_array($ptag, $arkeysignoradas) ) ){

					$values[] = $vtag;
			 
					$properties[] = $ptag;
				
				}

			
		
		}//.fim tagsignoradas	 
		
	

	}//fium foreach
	

	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	$url = "_id=".$id_ocorrencia; 
	
	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url=''
	$pathheader = "../edi_ocorrencia.php?url=".$inf->doCodifica($url);

	
	
	//MSG SUCCESS
	if($validado){  
		
		//$_REQUEST e um array http
		$resinstrucao = $crud->update($c
									  ,$tabela="ocorrencia"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$id_ocorrencia
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)-2
									  ,$retorno=1
									  ,$viewsql=0
									  );

		$instrucao = $crud->update($c
									  ,$tabela="ocorrencia"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$id_ocorrencia
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)-2
									  ,$retorno=1
									  ,$viewsql=2 //0:default; 1:exibe e interrompe a execucao; 2: returns a instrucao sql
									  );

	  $sql = $instrucao;
	  //echo "=>".$sql;exit();	
	  $link = @mysqli_connect('LocalHost','root','','eloisebd')	or die("Sem conexao");
	  $resultado = @mysqli_query($link,$sql);
	  if($resultado==1){
	  		echo"<script language='javascript' type='text/javascript'>alert('Ocorrencia atualizada!');window.location.href='../sm_ocorrencia.php'</script>";
	  }
	  //echo $resultado;exit();				   
		
		//ADMINISTRADOR 	tipo_usuario  1
		//OPERADOR 			tipo_usuario  2
		//VISUALIZADOR 		tipo_usuario  3
		//exit("aqui");
		$crud->notify($c
					  ,$msger
					  ,$log
					  ,$instrucao
					  ,$resinstrucao
					  ,$pathheader
					  ,$cryptoheader="-1"
					  ,$tabelahash="ocorrencia"
					  ,$chavehash=$_REQUEST["cadastro"]//FIXME
					  ,$login=$_SESSION["loginiwe"]	
					  ,$tipooperacao=1
					  ,$tipousuario=2 //TODO: ler do bd
					  ,$msgalerta
					  ,$metodo=0
					  ,$viewsql=0
					  );	

		
		

	}else{
		
		//MSG DANGER
		$crud->notify($c
					  ,$msger
					  ,$log
					  ,$instrucao
					  ,$resinstrucao=0
					  ,$pathheader
					  ,$cryptoheader="-1"
					  ,$tabelahash="ocorrencia"
					  ,$chavehash=$_REQUEST["cadastro"]//FIXME
					  ,$login=$_SESSION["loginiwe"]	
					  ,$tipooperacao=1
					  ,$tipousuario=2 //TODO: ler do bd
					  ,$msgalerta
					  ,$metodo=0
					  ,$viewsql=0
					  );
		
	}

?>
