<?php
/*      ins_usuario.php
 *		
 *		
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 *		
 */



	require "ExecVerificaSessionClass.php";
	
	require "Comunicadora.php";

	require "Normalizadora.php";

	include("CrudEstagio.php");	
	
	include("Log.php");	
	
	$c = new comunicadora();
	
	$nr = new Normalizadora();

	$crud = new CrudEstagio();

	$log = new Log();

	$msger = new Mensageira();

	


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

	//TODO:COLOCAR EM ROTINA
	//ajax telefones
	$lista = array();	

	$telefones = "";
	
	
	$pessoa_nome = $_REQUEST['estagiario_id'];
  	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
  	$query = "SELECT id from pessoa where matricula like '".$pessoa_nome."' and id in (select id from estagiario);";
  	$resultado = @mysqli_query($link,$query);
  	$num_rows = @mysqli_num_rows($resultado);
 	if($num_rows != 1){
 		if($num_rows < 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Estagiario nao localizado!');window.location.href='cad_ocorrencia.php'</script>";
 		}
 		if($num_rows > 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Mais de um estagiario localizado!');window.location.href='cad_ocorrencia.php'</script>";
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
 			echo"<script language='javascript' type='text/javascript'>alert('Servidor nao localizado!');window.location.href='cad_ocorrencia.php'</script>";
 		}
 		if($num_rows > 1){
 			echo"<script language='javascript' type='text/javascript'>alert('Mais de um servidor localizado!');window.location.href='cad_ocorrencia.php'</script>";
 		}
 	}
 	$linha = @mysqli_fetch_assoc($resultado);
  	$idServidor = $linha['id'];
	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(

							'msgdestino'
							,'cadastrar'
							
							);

	$arkeysignoradas = array(

							'msgdestino'
							,'cadastrar'

							);
	

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
	//.hack
	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url='' quando nao precisar criptografia de url
	$pathheader = "../cad_ocorrencia.php?url=''";//"../cad_pessoa.php?url=".doCodifica($codconteudo);

	//echo $validado;
	
	
	
	 
	//echo $validado; exit;  

	//MSG SUCCESS
	if($validado){  
		
		//$maxinputs=12 condiciona a iteracao da funcao create ler ate o 12ndo input ordinalmente rederizado
		//$_REQUEST e um array http
		

		$resinstrucao = $crud->rawCreate($c
									  ,$tabela="ocorrencia"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro=""
									  ,$opcao=1
									  ,$retorno=1
									  ,$viewsql=0
									  );

		

		//exit;

		//XXX:NAO ESTA RECUPERANDO A INSTRUCAO SQL

		// $resinstrucao = $crud->rawCreate($c
		// 							  ,$tabela="estagio"
		// 							  ,$colunas=$properties
		// 							  ,$campo=$values
		// 							  ,$filtro=""
		// 							  ,$opcao=1
		// 							  ,$retorno=1
		// 							  ,$viewsql=3
		// 							  );


		
		//concretizacao notify alertas e gravacao de log
		//$c: conexao;
		//$msger
		//$log
		//$instrucao: sql principal e o mesmo que sera gravado no log
		//$resinstrucao: retorno da instrucao se gravou ou nao
		//$pathheader: caminho de redirecionamento da mensagem de alerta
		//$cryptoheader: opcional DEFULT "-1" para criptografar as variaveis get do redirecionamento
		//$tabelahash: tabela que tem campo hash como bloqueador de duplicidade de insert
		//$chavehash: dados a serem utilizados para compor a chave unica de hash. Exemplo: chave primaria e/ou CPF e/ou nome e/ou matricula e/ou CNPJ
		//$tipooperacao: definidos na tipo_situacao
		//$tipousuario: definidos na tipo_situacao
		//$msgalerta: orientacao das mensagens de sucesso, alerta e erro
		//$metodo: 0 - returns enviar; DEFAULT
		//$metodo: 1 - returns row;
		//$metodo: 2 - returns fetch;
		//$metodo: 3 - returns string sql;
		//$viewsql:0 - oculta sql; 1 - exibe sql
		
		//CADASTRO 			tipo_operacao 1
		//EDICAO   			tipo_operacao 2
		//DELECAO  			tipo_operacao 3
		//---------------------------------
		//ADMINISTRADOR 	tipo_usuario  1
		//OPERADOR 			tipo_usuario  2
		//VISUALIZADOR 		tipo_usuario  3
		//exit("aqui");
		//XXX:NAO TA GRAVANDO LOG
		$crud->notify($c
					  ,$msger
					  ,$log
					  ,$instrucao
					  ,$resinstrucao
					  ,$pathheader
					  ,$cryptoheader="-1"
					  ,$tabelahash="pessoa"
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
					  ,$tabelahash="pessoa"
					  ,$chavehash=$_REQUEST["cadastro"]//FIXME
					  ,$login=$_SESSION["loginiwe"]	
					  ,$tipooperacao=1
					  ,$tipousuario=2 //TODO: ler do bd
					  ,$msgalerta
					  ,$metodo=0
					  ,$viewsql=1
					  );
		
	}

?>
