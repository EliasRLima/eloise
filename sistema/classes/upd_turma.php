<?php
/*      upd_usuario.php
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


	
	$pessoa_id = strip_tags($_REQUEST['_pessoa_id']); 
	
	$login_id = strip_tags($_REQUEST['_login_id']); 


	$tuplas ="
				id
				, nome
				 ";

	$filtro = "nome like '".strip_tags(utf8_encode($pessoa_id))."'";

	$qem = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro, $viewsql=0);


	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(
							'horacadastro'
							,'datacadastro'
							,'atualizar'
							,'msgdestino'
							,'id_estagio'
							,'_login_id'
							);

	



	foreach ($_REQUEST as $ptag => $vtag) {
			

		if( !empty($ptag) ){


			//TODO:COLOCAR EM ROTINA
		if($ptag=="_pessoa_id"  && !in_array($ptag, $arptagsignoradas)){
			
			 $properties[] = "pessoa_id";
			 
			 $values[] = $vtag;
				 


		}	
		elseif(!in_array($ptag, $arptagsignoradas) ){

				 $properties[] = $ptag;
				 
				 $values[] = $vtag;
				 
				 

				} //.else
			
		
		}//.if tagsignoradas

		else{

			$validado = 0;
					
			$msgalerta .= "Preencha o campo: ";

			$msgalerta .="$ptag</p>";
		}

	}//fim foreach ptag vtag
	

	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	$url = "_id=".$pessoa_id; 
	
	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url=''
	$resource = $inf->doCodifica($url);
	$pathheader = "../edi_usuario.php?url=".$resource;
	
	//MSG SUCCESS
	if($validado){  

		//$_REQUEST e um array http
		$resinstrucao = $crud->update($c
									  ,$tabela="turma_curso"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$login_id
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)
									  ,$retorno=1
									  ,$viewsql=1
									  );

		$instrucao = $crud->update($c
									  ,$tabela="turma_curso"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$login_id
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)
									  ,$retorno=0
									  ,$viewsql=1 //0:default; 1:exibe e interrompe a execucao; 2: returns a instrucao sql
									  );							   
		
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
					  ,$viewsql=0
					  );
		
	}

?>
