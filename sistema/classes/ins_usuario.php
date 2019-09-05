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
	
	
	$pessoa_id = $_REQUEST['login'];
  	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
  	$query = "SELECT id from pessoa where nome like '".$pessoa_id."';";
  	$resultado = @mysqli_query($link,$query);
  	$linha = @mysqli_fetch_assoc($resultado);
  	$id = $linha['id'];
  	$_pessoa_id = $id;
	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(
							'horacadastro'
							,'datacadastro'
							,'cadastrar'
							,'msgdestino'
							,'pessoa_id'
							
							);

	$arkeysignoradas = array(
							'empresa_id'
							,'estagiario_id'
							,'servidor_id'
							,'msgdestino'
							,'pessoa_id'
							);
	

	foreach ($_REQUEST as $ptag => $vtag) {
		
		//echo $ptag."=".$vtag."<p>"; 

		if( ( !in_array($ptag, $arptagsignoradas) ) ){


			

			if( (empty($vtag) || ($vtag=="-1") || ($vtag=="") || ($vtag==NULL) )  ){
			
				$validado = 0;
				
				$msgalerta .= "Preencha o campo: ";

				$msgalerta .=" ".$ptag."</p>";	


			}elseif($ptag=="pessoa_id"){

				$properties[] = "pessoa_id";

				$values[] = $_pessoa_id;					


			}elseif($ptag=="senha"){

				$properties[] = $ptag;

				$values[] = sha1($vtag);					


			}elseif($ptag=="autenticador"){

				if(!is_numeric($vtag)){
					
					$validado = 0;
				
					$msgalerta .= "Preencha o campo $ptag somente com números!"."</p>";

					
				}else{
					
					$properties[] = $ptag;

					$values[] = $vtag;					
				}

			
			}else{

				if( ( !in_array($ptag, $arkeysignoradas) ) ){

					$values[] = $vtag;
			 
					$properties[] = $ptag;
				
				}

			}
		
		}//.fim tagsignoradas	 
		
	

	}//fium foreach
	//.hack
	$properties[] = "pessoa_id";

	$values[] = $_pessoa_id;
	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url='' quando nao precisar criptografia de url
	$pathheader = "../cad_usuario.php?url=''";//"../cad_pessoa.php?url=".doCodifica($codconteudo);

	//echo $validado;
	
	
	
	 
	//echo $validado; exit;  

	//MSG SUCCESS
	if($validado){  
		
		//$maxinputs=12 condiciona a iteracao da funcao create ler ate o 12ndo input ordinalmente rederizado
		//$_REQUEST e um array http
		

		$resinstrucao = $crud->rawCreate($c
									  ,$tabela="login"
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
