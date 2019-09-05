<?php
/*      Apresentadora.php
 *		Abstracoes para uso em interfaces de usuario.php
 *
 *      Desenvolvedor:
 *
 *      Instituto Federal do Maranhao
 *		Definicoes primitivas de SQL para Create(Insert), Read (Select), Update e Delete
 */

error_reporting(0);

Abstract class Apresentadora{


	//TODO:PERMITIR FLAG PARA CADASTRO E EDICAO
	abstract function renderStatico($label, $tag, $class, $id, $name, $value, $placeholder, $icoclass, $type, $size, $maxlength, $evento);
	
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
	//$tipoiteracao: 0:<select>; 1:radio button 
	//$utf8: 0:default; 1: forca decodificacao para utf8
	//$evento: para onclick, onkeypress, onkeydown ....Uso: $evento="onkeypress='<sua-funcao-javascript>'"
	//utilizar alias 'id' e 'descricao' para as consultas sql para manter o laço 
	abstract function renderDinamico($c, $label, $tag, $class, $id, $name, $value, $placeholder, $icoclass, $type, $size, $maxlength, $iteracao, $tipoiteracao,$utf8, $evento);
	


	
	
}//fim classe View

?>
