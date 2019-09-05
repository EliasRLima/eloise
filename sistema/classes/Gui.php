<?php
/*      Gui.php
 *		Extensao de Manipuladora.php
 *
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 *		Definicoes primitivas de SQL para Create(Insert), Read (Select), Update e Delete
 */


include("Apresentadora.php");
error_reporting(0);

//require "classe_criptografia_url.php";

//Crud generico
//Cada tabela podera estender Create(Insert), Read (Select), Update e Delete deste Crud
//ou de Manipuladora caso haja sobrescrita (override)
class Gui extends Apresentadora{



	public function renderTabelaSeletora($c, $inf, $arTitulo, $espacoClassTitulo, $arDetalhes, $espacoClassDetalhes, $tipoPapel, $arSituacaoEstagio){

		$titulo = "";
		$titulo .="<tr>";
		foreach ($arTitulo as $key => $value) {
			# code...
			$titulo .="<td $espacoClassTitulo>$value</td>"; 

		}
		if($tipoPapel==1 || $tipoPapel==5 || $tipoPapel==4)
		
			$titulo .="<td colspan='3' $espacoClassTitulo >Ações</td>";
	            
		$titulo .="</tr>";

		$titulo .= Self::renderDetalhesTabelaSeletora($c,$inf,$arSituacaoEstagio, $arDetalhes,$tipoPapel);

		return $titulo;
	}

	public function renderDetalhesTabelaSeletora($c,$inf, $arSituacaoEstagio, $arDetalhes,$tipoPapel){
		
				$detalhe = "";
	                
	            while($l = $c->extrair($arDetalhes)){
	                
	                ++$ordem;
	                
	                $iconNome = "";
	                $iconEmpresa = "";

	                $detalhe .= "<tr>";

	                $detalhe .= "<td class='center'>".$l['id']."</td>";
	                $id = $l['id'];
	                $urln="_id=$id"; 

	                $filtro =$_GET['_filtro'];
	                //exit($filtro);
	                if($l['tipo_papel']=='3'){
	                	$iconNome = Self::renderIcones($l['tipo_papel'],$link="edi_aluno.php?url=".$inf->doCodifica($urln)."");
	                }
	                else{
	                	$iconNome = Self::renderIcones($l['tipo_papel'],$link="edi_servidor.php?url=".$inf->doCodifica($urln)."");
	                }

	                $detalhe .= "<td>";
	                	$detalhe .= iconv('iso-8859-1', 'utf-8', $l['nome']);
	                $detalhe .= "</td>";
	                
	                $urlem="_id=$l[empresa_id]"; 

	                if($tipoPapel!='7'){
	                	$iconEmpresa = Self::renderIcones(2,$link="relatorio_completo.php?url=".$inf->doCodifica($urln)."");
	                }
			        else{
			        	$iconEmpresa = Self::renderIcones(2,$link="relatorio_curso.php?url=".$inf->doCodifica($urln)."");
			        }
			    	
	                


		            $detalhe .= "<td class='center'>";

		            if($l['tipo_papel']!='4'){

		            	if($l['empresa']=='1'){
		            	$l['empresa'] = "Feminino";
		            }
		            if($l['empresa']=='2'){
		            	$l['empresa'] = "Masculino";
		            }

		            }
		            	

		            $detalhe .= iconv('iso-8859-1', 'utf-8', $l['empresa']);
		            $detalhe .= "</td>";
		            
		            if($tipoPapel==7){
		            	if($l['situacao_estagio']==2){
		            		$l['situacao_estagio'] = "OPCIONAL";
		            	}
		            	if($l['situacao_estagio']==1){
		            		$l['situacao_estagio'] = "OBRIGATORIO";
		            	}
		            }
		            $detalhe .= "<td class='center'>".$l['matricula']."</td>";
		            if($l['tipo_papel']=='3'){
		            	if($l['situacao_estagio']==0){
		            		$l['situacao_estagio'] = "";
		            	}
		            	if($l['situacao_estagio']==1){
		            		$l['situacao_estagio'] = "ANDAMENTO";
		            	}
		            	if($l['situacao_estagio']==2){
		            		$l['situacao_estagio'] = "CONCLUIDO";
		            	}
		            	if($l['situacao_estagio']==3){
		            		$l['situacao_estagio'] = "EM ABERTO";
		            	}
		            	if($l['situacao_estagio']==4){
		            		$l['situacao_estagio'] = "INTERROMPIDO";
		            	}
		            }
		            if($filtro==99){
		            	if($l['situacao_estagio']==0){
		            		$l['situacao_estagio'] = "Desativado";
		            	}
		            	if($l['situacao_estagio']==1){
		            		$l['situacao_estagio'] = "Ativo";
		            	}
		            }
		            $detalhe .= "<td class='center'>".$l['situacao_estagio']."</td>"; 
		            //TODO: ALOCAR EM ALGUMA ROTINA render
		       


		            
	                $detalhe .= "<div class='hidden-sm hidden-xs btn-group'>";
		                
		                $detalhe .= "<td class='center'>";
		                	
		                	//HACK
		                	$path = "";
		                	$urles ="";
		                	if($filtro==4){
		                		$path = "edi_estagio.php"; 
		            			$urles ="_id=$l[id_estagio]";
		                	}elseif($tipoPapel==2){
		                		$path = "edi_empresa.php"; 
		            			$urles ="_id=$l[id]";
		                	}elseif($tipoPapel==3){
		                		$path = "edi_aluno.php"; 
		            			$urles ="_id=$l[id]";
		                	}elseif($tipoPapel==5){
		                		$path = "edi_usuario.php"; 
		            			$urles ="_id=$l[pessoa_id]";
		                	}
		                	elseif($tipoPapel==7){
		                		$path = "edi_curso.php";
		                		$urles = "_id=$l[curso_id]";
		                	}
		                	elseif ($tipoPapel==1) {
		                		$path = "edi_servidor.php"; 
		            			$urles ="_id=$l[id]";
		                	}
		                	//.HACK
		            			
		            		//$urles ="_id=$l[empresa_id]";
		            
		            		$detalhe .= "<a href='$path?url=".$inf->doCodifica($urles)."' class='btn btn-xs btn-success white'>";
			                $detalhe .= "<i class='ace-icon fa fa-pencil bigger-130'>";
			                $detalhe .= "</i>";
			                $detalhe .= "</a>&nbsp;";
		                	

			                
			                
			                if($tipoPapel==5){
			                	
			                	$detalhe .= $iconNome;
			                	

			                }else{
			                	
			                	$detalhe .= $iconNome;
			                	$detalhe .= $iconEmpresa;
			                }

			                //$detalhe .= "<a href='#' class='btn btn-xs btn-danger white'>";
			                //$detalhe .= "<i class='ace-icon fa fa-trash-o bigger-130'>";
			                //$detalhe .= "</i>";
			                //$detalhe .= "</a>";
			                //$detalhe .= Self::renderStatusPessoa($l['tipo_papel'],$link="#");
		                	
			                
		                $detalhe .= "</td>";
	                $detalhe .= "</div>";//.hidden-sm hidden-xs btn-group
	                
	                $detalhe .= "</tr>";
	               
	            }

	            $detalhe .= "</table>";

            	$detalhe .= $ordem." Registro(s)";

	            return $detalhe;


	}

	public function renderSituacaoEstagio($c, $crud){
			//TODO:alocar em rotina
			$arSituacaoEstagio = array();
			
			$id_empresa = "";
			
			//readTipoSituacao
			//$c: conexao;
			//$colunas para clausula select;
			//$tabela: tabela da relacao com tipo_situacao;
			//$chave: tipo_<[servidor; pessoa; estagiario;...]>;
			//$tipoMetodo:  0 - returns set;
			//$tipoMetodo:  1 - returns total row;
			//$tipoMetodo:  2 - returns line - usage: $var_array[<index>];
			//$tipoMetodo:  3 - returns instrucao sql;
			//$filtro:  ja incluido o and
			//$viewsql: 0 - oculta sql; 1 - exibe sql
			$qse = $crud->readTipoSituacao($c, $colunas="id, descricao, valor_char", $tabela="estagio", $chave="situacao_estagio", $tipoMetodo=0, $filtro="", $orderby="ts.valor_char asc", $viewsql=0);


			while($l = $c->extrair($qse)) $arSituacaoEstagio[] = $l[descricao];
				
			return $arSituacaoEstagio;	
			//.TODO:alocar em rotina
	}

	public function renderStatusPessoa($tupla, $link){

		$retorno = "";
		//inscricao em estagio
		if( $tupla == 3 ){
		    $retorno = "<a href='relatorio_menu.php' class='btn btn-xs btn-success white'>";
		    $retorno .= "<i class='ace-icon fa fa-plus bigger-130'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;

		}
		 //estagiando
		if( $tupla == 4 ){
		    $retorno = "<a href='relatorio_menu.php' class='btn btn-xs btn-success white'>";
		    $retorno .= "<i class='ace-icon fa fa-play-circle-o bigger-130'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}


	}
	public function renderStatusEstagio($tupla, $link){

		$retorno = "";
		
		$ar = array(
						1 => "btn btn-xs btn-success white"
						,2 => "btn btn-xs btn-info white"
						,3 => "btn btn-xs btn-warning white"
						,4 => "btn btn-xs btn-danger white"
						,5 => "btn btn-xs btn-success white"
					  );

		

		//andamento
		if( $tupla == 1 ){

		    $retorno  = "<a href='$link' class='$ar[$tupla]'>";
			$retorno .= "<i class='ace-icon fa fa-play-circle-o bigger-130'>";
			$retorno .= "</i>";
			$retorno .= "</a>&nbsp;";

			return $retorno;

		}
		 //concluido
		if( $tupla == 2 ){

		    $retorno  = "<a href='$link' class='$ar[$tupla]'>";
		    $retorno .= "<i class='ace-icon fa fa-check-circle bigger-130'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}
		//em aberto
		if( $tupla == 3 ){

		    $retorno  = "<a href='$link' class='$ar[$tupla]'>";
		    $retorno .= "<i class='ace-icon fa fa-pause-circle bigger-130'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;

		}
		//interrompido
		if( $tupla == 4 ){

		    $retorno  = "<a href='$link' class='$ar[$tupla]'>";
		    $retorno .= "<i class='ace-icon fa fa-stop bigger-130'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}

		//usuario
		if( $tupla == 5 ){

		    $retorno  = "<a href='$link' class='$ar[$tupla]'>";
		    $retorno .= "<i class='ace-icon fa fa-check-circle bigger-130'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}



	}

	public function renderStatusAtivo($tupla, $link, $arHrefClass, $iconClass){

		$retorno = "";
		

		

		//andamento
		if( $tupla == 1 ){

		    $retorno  = "<a href='$link' class='$arHrefClass'>";
			$$retorno .= "<i class='$iconClass'>";
			$retorno .= "</i>";
			$retorno .= "</a>&nbsp;";

			return $retorno;

		}
		 //concluido
		if( $tupla == 2 ){

		    $retorno  = "<a href='$link' class='$arHrefClass'>";
		    $retorno .= "<i class='$iconClass'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}
		//em aberto
		if( $tupla == 3 ){

		    $retorno  = "<a href='$link' class='$arHrefClass'>";
		    $retorno .= "<i class='$iconClass'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;

		}
		//interrompido
		if( $tupla == 4 ){

		    $retorno  = "<a href='$link' class='$arHrefClass'>";
		    $retorno .= "<i class='$iconClass'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}

		//usuario
		if( $tupla == 5 ){

		    $retorno  = "<a href='$link' class='$arHrefClass'>";
		    $retorno .= "<i class='$iconClass'>";
		    $retorno .= "</i>";
		    $retorno .= "</a>&nbsp;";

			return $retorno;
		}



	}

	public function renderIcones($tupla,$link){

		
        if($tupla==3) //candidato

        	return "<a href='$link' class='btn btn-xs btn-warning white'><i class='ace-icon fa fa-user bigger-130'></a></i>&nbsp;";       
           
                
        elseif($tupla==2) //empresa
             return "<a href='$link' class='btn btn-xs btn-info white'><i class='ace-icon fa fa-industry bigger-130'></a></i>&nbsp;";              
           

        elseif($tupla==4) //estagiario
            
             return "<a href='$link' class='btn btn-xs btn-success white'><i class='ace-icon fa fa-male bigger-130'></a></i>&nbsp;";       
           
        elseif($tupla==1) //servidor
            return "<a href='$link' class='btn btn-xs btn-success white'><i class='ace-icon fa fa-university bigger-130'></a></i>&nbsp;";               
           

	}

	public function renderStatico($label, $tag, $class, $id, $name, $value, $placeholder, $icoclass, $type, $size, $maxlength, $evento){
		
		//TODO
		$render = "";
		$render .= "<span class='middle'>";
		$render .= $label;
		$render .=":</span>";		
		$render .= "<div class='row'>";
			$render .= "<div class='col-xs-12 col-sm-12'>";						
				$render .= "<div id='eloise-render' class='input-group input-group-lg'>";
					$render .= "<span class='input-group-addon'>";
						$render .= "<i class='";
						$render .=$icoclass;
						$render .="'>";							
						$render .= "</i>";
					$render .= "</span>";								
						$render .= "<";
						$render .= $tag;
						//input
						$render .= " class='$class' name='$name' id='$id' value='$value' placeholder='$placeholder' type='$type' size='$size' maxlength='$maxlength' $evento/>";
					    //.input
				$render .= "</div>";
			$render .= "</div>";
		$render .= "</div>";		
		$render .= "<hr>";

		return $render;

	}
	//adequado para arrays de componentes
	//$c
	//$label
	//$tag
	//$class
	//$id
	//$name
	//$value
	//$placeholder
	//$icoclass
	//$type
	//$size
	//$maxlength
	//$iteracao: query do banco ou qualquer array para engrenar laco 
	//$tipoiteracao: 0:<select> com value para id da tabela alvo; 1:radio button; 2: <select> com value para valor_char de tipo_situacao
	//$utf8: 0:default; 1: forca decodificacao para utf8;
	//$evento: para onclick, onkeypress, onkeydown ....Uso: $evento="onkeypress='<sua-funcao-javascript>'"
	//utilizar alias 'id' e 'descricao' para as consultas sql para manter o laço 
	public function renderDinamico($c, $label, $tag, $class, $id, $name, $value,  $placeholder, $icoclass, $type, $size, $maxlength,$iteracao,$tipoiteracao, $utf8, $evento){
		//TODO

		$render = "";
		$render .= "<span class='middle'>";
		$render .= $label;
		$render .="</span>";		
		$render .= "<div class='row'>";
			$render .= "<div class='col-xs-12 col-sm-12'>";
				$render .= "<div class='input-group input-group-lg'>";

					if($tipoiteracao==0){
						
						$render .= "<span class='input-group-addon'>";
							$render .= "<i class='";
							$render .=$icoclass;
							$render .="'>";							
							$render .= "</i>";
						$render .= "</span>";		
						$render .= "<select class='$class' name='$name'>";					
								$render .= "<option selected='selected' value='$value'></option>";	


									while($l = $c->extrair($iteracao)){

										//efeito somente com origem em edi_xxxxx
										
										if($value==$l['valor_char']) 

											$evento="selected";
										
										else
											
											$evento="";

										//.efeito somente com origem em edi_xxxxx

										if ($utf8) 

											$render .="<option value='".$l['valor_char']."' $evento >".utf8_encode($l['descricao'])."</option>";							
										
										else
											
											$render .="<option value='".$l['valor_char']."' $evento >".$l['descricao']."</option>";							
									
									}

						$render .= "</select>";			
						
					
					}elseif($tipoiteracao==2){

						$render .= "<span class='input-group-addon'>";
							$render .= "<i class='";
							$render .=$icoclass;
							$render .="'>";							
							$render .= "</i>";
						$render .= "</span>";		
						$render .= "<select class='$class' name='$name' $evento>";					
								$render .= "<option selected='selected' value='$value'></option>";									
									while($m = $c->extrair($iteracao)){

										if ($utf8) 

											$render .="<option value='".$m['id']."'>".utf8_encode($m['descricao'])."</option>";							
										
										else
											
											$render .="<option value='".$m['id']."'>".$m['descricao']."</option>";							
									
									}

						$render .= "</select>";			
						
					
					}else{

						if($tipoiteracao==1){



									while($l = $c->extrair($iteracao)){

										//efeito somente com origem em edi_xxxxx
										if($value==$l['valor_char']) 

											$evento="checked";
										
										else
											
											$evento="";

										//.efeito somente com origem em edi_xxxxx


										if ($utf8){

											$render .="<label>";
											$render .="<input class='ace' type='radio' id='$id' name='$name' value='".$l['valor_char']."' size='50' $evento />";
										
											$render .="<span class='lbl'>&nbsp;&nbsp;".utf8_encode($l['descricao'])."</span>";	
											$render .="</label>&nbsp;&nbsp;";

										} 
										
										else{

											$render .="<label>";
											$render .="<input class='ace' type='radio' id='$id' name='$name' value='".$l['valor_char']."' size='50' $evento />";
										
											$render .="<span class='lbl'>&nbsp;&nbsp;".$l['descricao']."</span>";	
											$render .="</label>&nbsp;&nbsp;";

										}
											
										
									}

						
					
						}

					}


					
				$render .= "</div>";
			$render .= "</div>";
		$render .= "</div>";		
		$render .= "<hr>";

		return $render;

	}

}//fim classe Gui

?>
