<?php
/*      upd_estagio.php
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


	$id_estagio = strip_tags($_REQUEST['id_estagio']); 

	$pessoa_id = strip_tags($_REQUEST['estagiario_id']); 


	$tuplas ="
				id
				, nome
				 ";

	$filtro = "nome like '".strip_tags(utf8_encode($_REQUEST['_empresa_id']))."'";

	$qem = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro, $viewsql=0);

	//echo $qem['id']; exit;

	//$empresa_id        = strip_tags($_REQUEST['_empresa_id']);
	$empID = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro="nome like '%".$_REQUEST['empresa_id']."%' and tipo_papel in (2)", $viewsql=0);
	$empresa_id       = $empID['id'];
	//exit("Emp:".$empresa_id); 

	$estID = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro="matricula like '%".$_REQUEST['estagiario_matricula']."%' and tipo_papel in (3)", $viewsql=0);
	$estagiario_id   = $estID['id'];//strip_tags($_REQUEST['_estagiario_id']);

	$servID = $cpessoa->readPessoa($c, $crud, $colunas=$tuplas, $tabela="pessoa", $tipoMetodo=2, $filtro="nome like '%".$_REQUEST['servidor_id']."%' and tipo_papel in (1)", $viewsql=0);
	$servidor_id       = $servID['id'];//strip_tags($_REQUEST['_servidor_id']);

	$checked = 0;
	if($servidor_id == "" or $servidor_id == null or $estagiario_id == "" or $estagiario_id == null or $empresa_id == "" or $empresa_id == null)
	{
		$checked = 1;
	}

	//$agente_id     	   = $qes[agente_id];

	//$situacao_estagio  = $qes[situacao_estagio];
	
	//$tipo_pne          = $qes[tipo_pne];



	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(
							'horacadastro'
							,'datacadastro'
							,'atualizar'
							,'msgdestino'
							,'id_estagio'
							,'servidor_id'
							);

	$auxest = 0;
	$auxemp = 0;

	foreach ($_REQUEST as $ptag => $vtag) {
			

		if( !empty($ptag) ){


			//TODO:COLOCAR EM ROTINA

				if( ($ptag=="empresa_id" || $ptag=="_empresa_id") && !in_array($ptag, $arptagsignoradas) ){

					$values[] = $empresa_id;
				 	//exit("value is ".$empresa_id);
				 	$properties[] = "empresa_id";

				 	if($empresa_id == "" and $auxemp == 0){
				 		$auxemp = 1;
				 		$validado = 0;
						$msgalerta .= "Empresa nao foi preenchida corretamente!"."</p>";
				 	}


				}elseif( ($ptag=="estagiario_matricula" ) && !in_array($ptag, $arptagsignoradas) ){
					
					$values[] = $estagiario_id; 

					$properties[] = "estagiario_id";

					if($estagiario_id == "" and $auxest == 0){
						$auxest = 1;
				 		$validado = 0;
						$msgalerta .= "Estagiario nao foi preenchido corretamente!"."</p>";
				 	}
				
				}
				
				elseif(
						(
							   $ptag=="data_inicio"
							|| $ptag=="data_termino"
							|| $ptag=="data_prorrogado"
							|| $ptag=="data_distrato"
							|| $ptag=="data_estagioavaliado"

						)	
						&& (!in_array($ptag, $arptagsignoradas) ) ){
					
					
					$values[] = $nr->normalizarData($vtag,16); 

					$properties[] = $ptag; 
				
				}elseif( !in_array($ptag, $arptagsignoradas) ){

				 $values[] = $vtag;
				 
				 $properties[] = $ptag;
				 

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

	$url = "_id=".$id_estagio; 
	
	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url=''
	$pathheader = "../edi_estagio.php?url=".$inf->doCodifica($url);
	
	//MSG SUCCESS
	if($validado and $checked==0){  

		//$_REQUEST e um array http
		$resinstrucao = $crud->update($c
									  ,$tabela="estagio"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$id_estagio
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)-3
									  ,$retorno=1
									  ,$viewsql=1
									  );

		$instrucao = $crud->update($c
									  ,$tabela="estagio"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$id_estagio
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)-3
									  ,$retorno=0
									  ,$viewsql=2 //0:default; 1:exibe e interrompe a execucao; 2: returns a instrucao sql
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
