<?php
/*      upd_pessoa.php
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



	//ajax: ac_idpessoa.php
	$id = $_REQUEST['id'];
	//$data = $_REQUEST['data_atualizacao_cadastro'];
	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
	$qdata = @mysqli_query($link,$queryd);
	$data = @mysqli_fetch_assoc($qdata);
	$data = $data['ano']."-".$data['mes']."-".$data['dia'];
	//echo $data;exit(); 

	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(
							'horacadastro'
							,'datacadastro'
							,'Atualizar'
							,'msgdestino'
							,'id'
							,'_pessoa_id'
							,'pessoa_id'
							,'data_atualizacao_cadastro'
							,'telefones'
							// ,'aux_pessoa_id'
							// ,'telefones'
							
							);

	//autorelacionamento

			  
	//TODO: PASSAR PARA CA O ID DO CONTATO

	

	//.autorelacionamento




	foreach ($_REQUEST as $ptag => $vtag) {
			

		if(!in_array($ptag, $arptagsignoradas) && !empty($vtag)){


			//TODO:COLOCAR EM ROTINA
				//ajax telefones
				$lista = array();	

				$telefones = "";
				
				$tamArray =  sizeof($_REQUEST['telefones']);
				
				if($_REQUEST['telefones']){

					foreach ($_REQUEST['telefones'] as $i => $f){
						

						 if($f != "" || !is_numeric($f)){


							 if($i<($tamArray-1))

							 	$lista[] = "$i=>$f,";

							 				 
							 else

							 	$lista[] = "$i=>$f"; 

						 }else{


						 	$validado = 0;
							
							$msgalerta .= "Preencha o campo: ";

							$msgalerta .=" Telefones corretamente</p>";	


						 }

					}//.foreach telefones 
								
					

					$telefones = json_encode($lista);	 

				} //.if telefones
				

				//.ajax telefones  
				if($ptag=="telefones"){
					
					
					$values[] = $telefones;	

				}
				else{
				 $values[] = $vtag;
				 
				 $properties[] = $ptag;
				 

				} //.else
			
		
		}//.if tagsignoradas

	}//fim foreach ptag vtag
	

	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	$url = "_id=".$id; 
	
	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url=''
	$pathheader = "../edi_pessoa.php?url=".$inf->doCodifica($url);
	if($_REQUEST['tipo_papel']==3){
		$pathheader = "../edi_aluno.php?url=".$inf->doCodifica($url);
	}
	
	
	//MSG SUCCESS
	if($validado){  
		
		//$_REQUEST e um array http
		$resinstrucao = $crud->update($c
									  ,$tabela="pessoa"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$id
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)-1
									  ,$retorno=1
									  ,$viewsql=0
									  );

		$instrucao = $crud->update($c
									  ,$tabela="pessoa"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro="where id=".$id
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=sizeof($properties)-1
									  ,$retorno=0
									  ,$viewsql=2 //0:default; 1:exibe e interrompe a execucao; 2: returns a instrucao sql
									  );							   
		
		//$select = "update pessoa set data_atualizacao_cadastro = '".$data."' where id = '";
  		//$select .= $id;
 		//$select .="';";
 		//echo "=>".$select;exit();
 		//$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
 	    //@mysqli_query($link,$select);
		$coluna = array();
		$coluna[] = "data_atualizacao_cadastro";

		$valor = array();
		$valor[] = "".$data."";

 	    $data = $crud->update($c
									  ,$tabela="pessoa"
									  ,$colunas=$coluna
									  ,$campo=$valor
									  ,$filtro="where id=".$id
									  ,$opcao=1
									  ,$inputini=0
									  ,$inputfim=1
									  ,$retorno=0
									  ,$viewsql=0 //0:default; 1:exibe e interrompe a execucao; 2: returns a instrucao sql
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
