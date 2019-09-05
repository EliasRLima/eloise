<?php
/*      ins_estagio.php
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
	
	$tamArray =  sizeof($_REQUEST['telefones']);

	if($_REQUEST['telefones']){

		foreach ($_REQUEST['telefones'] as $i => $f){
			

			 if($f != "" || !is_numeric($f) ){


				 if($i<($tamArray-1))

				 	$lista[] = "$i=>$f,";

				 				 
				 else

				 	$lista[] = "$i=>$f"; 

			 }else{


			 	$validado = 0;
				
				$msgalerta .= "Preencha o campo: ";

				$msgalerta .=" Telefones corretamente</p>";	


			 }

		} 
					
		

		$telefones = json_encode($lista);	 

	}

	
	//.ajax telefones

	//ajax: ac_idpessoa.php
			  $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
				$queryEmp = "SELECT id,1 FROM pessoa where nome = '".$_REQUEST['empresa_id']."' and tipo_papel in (2)";
				$resultadoEmp = @mysqli_query($link,$queryEmp);
				$linhaEmp = @mysqli_fetch_assoc($resultadoEmp);

				$queryEst = "SELECT id,1 FROM pessoa where matricula = '".$_REQUEST['estagiario_matricula']."' and tipo_papel in (3)";
				$resultadoEst = @mysqli_query($link,$queryEst);
				$num_rows = @mysqli_num_rows($resultadoEst);
				$linhaEst = @mysqli_fetch_assoc($resultadoEst);

				$querySer = "SELECT id,1 FROM pessoa where nome = '".$_REQUEST['servidor_id']."' and tipo_papel in (1)";
				$resultadoSer = @mysqli_query($link,$querySer);
				$linhaSer = @mysqli_fetch_assoc($resultadoSer);

				


	$empresa_id = $linhaEmp['id']; 
	$estagiario_id = "";
	if($num_rows > 0){
		$estagiario_id = $linhaEst['id'];
	}
	
	$servidor_id = $linhaSer['id'];
	
	$agente_id = $_REQUEST['agente_id']; 

	//echo "Emp:".$empresa_id."estagiario:".$estagiario_id."servidor:".$servidor_id."agente_id:".$agente_id;exit();
	
	
	// echo $_REQUEST['coeficiente']; 
	
	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array(
							'horacadastro'
							,'datacadastro'
							,'cadastrar'
							,'msgdestino'
							,'data_distrato'
							,'data_prorrogado'
							,'data_estagioavaliado'
							,'coeficiente'
							,'_estagiario_id'
							,'estagiario_nome'
							);

	$arkeysignoradas = array(
							'empresa_id'
							,'estagiario_id'
							,'servidor_id'
							,'msgdestino'
							,'data_distrato'
							,'data_prorrogado'
							,'data_estagioavaliado'
							,'coeficiente'
							,'estagiario_nome'
							);
	

	foreach ($_REQUEST as $ptag => $vtag) {
		
		//echo $ptag."=".$vtag."<p>"; 

		if( ( !in_array($ptag, $arptagsignoradas) ) ){


			

			if( (empty($vtag) || ($vtag=="-1") || ($vtag=="") || ($vtag==NULL) )  ){
			
				$validado = 0;
				
				$msgalerta .= "Preencha o campo: ";

				$msgalerta .=" ".$ptag."</p>";	


			}elseif(
					  $ptag=="ano_diploma" 
				   || $ptag=="numero_termo"
				   || $ptag=="carga_horario"
				   
				   ){

				if(!is_numeric($vtag)){
					
					$validado = 0;
				
					$msgalerta .= "Preencha o campo $ptag somente com números!"."</p>";

					
				}else{
					
					$properties[] = $ptag;

					$values[] = $vtag;					
				}


			}elseif(
					  $ptag=="data_inicio" 
				   || $ptag=="data_termino"
				   || $ptag=="data_distrato"
				   || $ptag=="data_prorrogado"
				   || $ptag=="data_estagioavaliado"
				   
				   ){
				
				$dataValida = $nr->normalizarData($vtag,4);


				if($dataValida){

					$properties[] = $ptag;

					$values[] = $nr->normalizarData($vtag,16);
				}
					
				
				else{	
				
					$validado = 0;
				
					$msgalerta .= "Campo $ptag com formato de data inválido!"."</p>";

					
				}


			}elseif($ptag=="empresa_id"){


				$properties[] = "empresa_id";
			 
				$values[] = $empresa_id;

				//HACK: LIMITAR AS ESTRANGEIRAS	
				//$c: conexao
				//$tabela
				//$colunas
				//$values
				$jaExiste = $crud->readChaves($c, "empresa", "id", $empresa_id, "id=$empresa_id", $viewsql=0);

				if (!$jaExiste)

					$validado = $crud->createChaves($c, "empresa", "id, pessoa_id", "$empresa_id,$empresa_id",$viewsql=0);
			 

				// echo $values[3]; exit;

			}elseif($ptag=="estagiario_matricula"){

				if($estagiario_id != "")
				{
					$properties[] = "estagiario_id";
					$values[] = $estagiario_id;
				}
				else{

					$validado = 0;
					$msgalerta .= "Matricula nao foi localizada!"."</p>";
				}		 


			}elseif($ptag=="servidor_id"){

				$properties[] = "servidor_id";
			 
				$values[] = $servidor_id;


			}elseif($ptag=="_setor_id"){

				$properties[] = "setor_id";
			 
				$values[] = $setor_id;

				//HACK: LIMITAR AS ESTRANGEIRAS	

			 	//TODO: AVALIAR NECESSIDA DE $jaExiste aqui
				$validado = $crud->createChaves(
			 									$c
			 									,"empresa", "id, pessoa_id, setor_id"
			 								    ,"$servidor_id,$servidor_id, $setor_id"
			 								    ,$viewsql=1
			 								    );


			

			
			}else{

				if( ( !in_array($ptag, $arkeysignoradas) ) ){

					$values[] = $vtag;
			 
					$properties[] = $ptag;
				
				}

			}
		
		}//.fim tagsignoradas	 

	

	}//fium foreach

	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url='' quando nao precisar criptografia de url
	$pathheader = "../cad_estagio.php?url=''";//"../cad_pessoa.php?url=".doCodifica($codconteudo);

	//echo $validado;
	
	
	
	 
	//echo $validado; exit;  

	//MSG SUCCESS
	if($validado){  
		
		//$maxinputs=12 condiciona a iteracao da funcao create ler ate o 12ndo input ordinalmente rederizado
		//$_REQUEST e um array http
		

		$resinstrucao = $crud->rawCreate($c
									  ,$tabela="estagio"
									  ,$colunas=$properties
									  ,$campo=$values
									  ,$filtro=""
									  ,$opcao=1
									  ,$retorno=1
									  ,$viewsql=1
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
