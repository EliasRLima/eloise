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

	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryUPD = "insert into empresa(id,pessoa_id) select id,id from pessoa where id not in (select id from empresa) and tipo_papel in (2);";
	@mysqli_query($link,$queryUPD);
	//.ajax telefones

	//ajax: ac_idpessoa.php
	//tentaiva I
	//$observacao = $_REQUEST['observacao'];
	//$datacadastro = $_REQUEST['datacadastro'];
	//$dataAtualizacaoCadastro = $_REQUEST['dataAtualizacaoCadastro'];
	//$nome_fantasia = $_REQUEST['nome_fantasia'];


	//$ptag: prorpriedade da tag html. Ex.: name="<nome_do_campo>"
	//$vtag: value da prorpriedade da tag html . Ex.: value="<valor>"
	
	//propriedades das tags html ignoradas para controle
	$arptagsignoradas = array('horacadastro','data_cadastro','pessoa_contato','aux_pessoa_id','observacao','data_atualizacao','nome_fantasia','areas_interesse','telefones','sexo','data_nascimento');

	//if (in_array("horacadastro", $artagssemcontrole)) {echo "==>";exit("acchei");}

	foreach ($_REQUEST as $ptag => $vtag) {
		
		
		    if( (empty($vtag) || ($vtag=="-1") ) && ( !in_array($ptag, $arptagsignoradas) ) ){

				$validado = 0;
				
				$msgalerta .= "Preencha o campo: ";

				$msgalerta .=" ".$ptag."</p>";	


			}elseif($ptag=="telefones" && !empty($vtag)){
				
				$values[] = $telefones; 
			
			}else $values[] = $vtag;

		

		 


	}//fium foreach

	//./TODO: ENVIAR PARA METODO DE VALIDACAO

	$instrucao = "";

	//XXX: virgula ou & de notify por dificultar a decriptografia 
	//TODO: CRIAR rotina que substitua o ? por , ou por &
	//EXEMPLO:edi_pessoa.php?url=_id=9?al=0&msg=Opera%C3%A7%C3%A3o%20realizada!
	//HACK: ?url='' quando nao precisar criptografia de url
	$pathheader = "../cad_empresa.php?url=''";//"../cad_pessoa.php?url=".doCodifica($codconteudo);

	//MSG SUCCESS
	if($validado){  
		
		//$maxinputs=12 condiciona a iteracao da funcao create ler ate o 12ndo input ordinalmente rederizado
		//$_REQUEST e um array http
		$resinstrucao =  $crud->create($c,$tabela="pessoa",$colunas=$_REQUEST,$tuplas=$values,$opcao=1,$maxinputs=14,$retorno=1,$viewsql=0); 
		
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
					  ,$viewsql=1
					  );
		
	}

?>
