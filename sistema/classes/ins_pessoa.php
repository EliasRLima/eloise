<?php
/*      ins_pessoa.php
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
	
	include("Log.php");	
	
	$c = new comunicadora();
	
	$nr = new Normalizadora();

	$crud = new Crud();

	$log = new Log();

	$msger = new Mensageira();

	

	//echo $crud->create($c,$tabela="servidor",$colunas="pessoa_id, matricula, tipo_servidor",$campo=$_REQUEST,$opcao=1,$maxinputs=3,$retorno=0,$viewsql=0); 
	
	// echo $crud->update($c,$tabela="servidor",$colunas=array("pessoa_id","matricula"),$campo=$_REQUEST,$filtro="where pessoa_id=".$_REQUEST['nome'],$opcao=1,$inputini=0, $inputfim=2,$retorno=0,$viewsql=1); 


	//echo $crud->read($c,$tabela="servidor",$colunas=array("pessoa_id","matricula"),$campo=$_REQUEST,$filtro="where pessoa_id=".$_REQUEST['nome'],$opcao=1,$inputini=0, $inputfim=2,$retorno=0,$viewsql=1); 


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
	$pessoa_id = $_REQUEST['aux_pessoa_id'];
	$cadastro = $_REQUEST['tipo_papel'];
	if($cadastro == 1){
		$mx = 13;
	}
	else{
		$mx = 14;
	}
	//tentaiva I
	//$observacao = $_REQUEST['observacao'];
	//$data_cadastro = $_REQUEST['data_cadastro'];
	//$data_atualizacao = $_REQUEST['data_atualizacao'];
	//$nomefantasia = $_REQUEST['nomefantasia'];
	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryUPD = "insert into servidor(id,pessoa_id,matricula) select id,id,cadastro from pessoa where tipo_papel = 1 and id not in (select id from servidor);";
	$queryUPD2 = "insert into estagiario(id,pessoa_id) select id,id from pessoa where id not in (select id from estagiario) and tipo_papel in (3);";
	@mysqli_query($link,$queryUPD);
	@mysqli_query($link,$queryUPD2);
	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array('tipo_cadastro','horacadastro','data_cadastro','aux_pessoa_id','observacao','data_atualizacao','nomefantasia','areasInteresse','telefones','data_nascimento','cadastrar','msgdestino');

	//if (in_array("horacadastro", $artagssemcontrole)) {echo "==>";exit("acchei");}

	foreach ($_REQUEST as $ptag => $vtag) {
		
		
		if($ptag=="data_nascimento" && empty($vtag)){

			//converte de DD/MM/YYYY para YYYY-DD-MM
			$values[] = $nr->normalizarData($vtag,16);

			//facilita a localizacao da mensagem de 'Operacao nao realizada', se da crud ou da notify
			// iniciando a orientacao no primeiro alerta de validacao
			//
			

			$msgalerta .= "Preencha o campo:";
			
			$validado = 0;

			$msgalerta .=" ".$ptag." com o formato DD/MM/YYYY</p>";



		}else{
			if($ptag=="data_nascimento" && empty($vtag)){

			//converte de DD/MM/YYYY para YYYY-DD-MM
			$values[] = $nr->normalizarData($vtag,16);
			$properties[] = $ptag;	
			//facilita a localizacao da mensagem de 'Operacao nao realizada', se da crud ou da notify
			// iniciando a orientacao no primeiro alerta de validacao
			//
			

			$msgalerta .= "Preencha o campo:";
			
			$validado = 0;

			$msgalerta .=" ".$ptag." com o formato DD/MM/YYYY</p>";



			}

			elseif( (empty($vtag) || ($vtag=="-1") ) && ( !in_array($ptag, $arptagsignoradas) ) ){

				$validado = 0;
				
				$msgalerta .= "Preencha o campo: ";

				$msgalerta .=" ".$ptag."</p>";	


			}elseif($ptag=="aux_pessoa_id" && !empty($vtag)){
				
				$values[] = $pessoa_id; 
			
			//TODO: ver como aceitar somente numeros nos telefones com json
			}elseif($ptag=="telefones" && !empty($vtag)){
				
				$values[] = $telefones; 
			
			}
			elseif ($ptag=="tipo_cadastro" && empty($vtag)) {
				if($cadastro=='1'){
					$values[] = 1;
				}
				else if($cadastro=='3'){
					
					$values[] = 3;
				}
			}
			elseif($ptag=="data_nascimento" && !empty($vtag)){
				
				$values[] = $nr->normalizarData($vtag,16); 

			//}elseif($ptag=="observacao" && !empty($vtag)){
				//$values[] = $observacao;
			//}
			//elseif($ptag=="data_cadastro" && !empty($vtag)){
				//$values = $datacadastro;
			//}
			//elseif($ptag=="" && !empty($vtag)){
				//$values = $dataAtualizacaoCadastro;
			//}
			//elseif($ptag=="nomefantasia" && !empty($vtag)){
				//$values = $nomefantasia;
			}else{

				$values[] = $vtag;
					
			} 


		

		} 


	}//fium foreach

	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url='' quando nao precisar criptografia de url
	if($cadastro==1){
		$pathheader = "../cad_servidor.php?url=''";//"../cad_pessoa.php?url=".doCodifica($codconteudo);
	}
	else{
		$pathheader = "../cad_aluno.php?url=''";//"../cad_pessoa.php?url=".doCodifica($codconteudo);
	}
	//MSG SUCCESS
	if($validado){  
		//$maxinputs=12 condiciona a iteracao da funcao create ler ate o 12ndo input ordinalmente rederizado
		//$_REQUEST e um array http
		$resinstrucao =  $crud->create($c,$tabela="pessoa",$colunas=$_REQUEST,$tuplas=$values,$opcao=1,$maxinputs=$mx,$retorno=1,$viewsql=0); 
		
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
