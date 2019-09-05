<?
/*
 *      Normalizadora.php
 *
 *      Desenvolvedor:
 *
 *      Osevaldo Farias <osevaldo@ifma.edu.br>
 *
 *      Copyright 2013
 *
 *      Instituto Federal do Maranhao
 *      Diretoria de Tecnologia da Informacao
 *      Nucleo de Desenvolvimento de Sistemas de Informacao
 *      http://www.ifma.edu.br/dgti
 *
 */

//require './../../../verifica_sessao.php';

error_reporting(0);
class Normalizadora{


	public function normalizarData($dt,$formato)

	{

		//1: "YYYYDDMM"

		if ($formato==1){

			$dia = substr($dt,0,2);

			$mes = substr($dt,3,2);

			$ano = substr($dt,6,4);

			$data = $ano."".$mes."".$dia;

			return $data;

		}//2:"DDMMYYYY"

		else if($formato==2){

			$dia = substr($dt,0,2);

			$mes = substr($dt,3,2);

			$ano = substr($dt,6,4);

			$data = $dia."".$mes."".$ano;

			return $data;

		}
		//3:"DD-MM-YYYY"
		else if($formato==3){

			$dia = substr($dt,0,2);

			$mes = substr($dt,3,2);

			$ano = substr($dt,6,4);

			$data = $dia."-".$mes."-".$ano;

			return $data;

		}
		//4:"data Ok!/data invalida"
		else if ($formato==4){



			$dia = substr($dt,0,2);

			$mes = substr($dt,3,2);

			$ano = substr($dt,6,4);



			return checkdate($mes,$dia,$ano);

			

		}
		//5:"DD/MM/YYY"
		else if ($formato==5){


			$data = date("d/m/Y", strtotime($dt));

			return $data;
		}

		//6:"YYYY-MM-DD"
		else if($formato == 6){

			$data = date('d/m/Y H:i:s', strtotime($dt));

			$data = str_replace("/","",$data);

			$dia = substr($data,0,2);

			$mes = substr($data,2,2);

			$ano = substr($data,4,4);

			$resaux = $ano."-".$mes."-".$dia;

			$res = $resaux;

			return $res;

		}
		//7:"DD/MM/YYYY"
		if ($formato == 7){

			$dt = $data;

			$dia = substr($dt,0,2);

			$mes = substr($dt,2,2);

			$ano = substr($dt,4,4);

			$res = $dia."/".$mes."/".$ano;

			return $res;

		}
		//8:DDMMYYYY
		if($formato == 8){

			$dt = $data;

			$dt = date('d/m/Y H:i:s', strtotime($data));

			$dia = substr($dt,0,2);

			$mes = substr($dt,3,3);

			$ano = substr($dt,5,5);

			$resaux = $dia.$mes.$ano;

			$res = str_replace("/","",$resaux);

			return $res;

		}
		//9:"DD-MM-YYYY"
		else if ($formato==9){


			$data = date("d-m-Y", strtotime($dt));

			return $data;
		}
		//10:"YYYY-MM-DD"
		else if ($formato==10){


			$data = date("Y-m-d", strtotime($dt));

			return $data;
		}
		//11:"YYYY-MM-DD"
		else if($formato == 11){

			$data = date('Y/m/d H:i:s', strtotime($dt));

			$data = str_replace("/","",$data);

			$dia = substr($data,0,2);

			$mes = substr($data,2,2);

			$ano = substr($data,4,4);

			$resaux = $ano."-".$mes."-".$dia;

			$res = $resaux;

			return $res;

		}
		//12:"YYYY-MM-DD"
		else if($formato == 12){

			$data = date('Y-m-d H:i:s', strtotime($dt));

			$data = str_replace("/","",$data);

			$dia = substr($data,0,2);

			$mes = substr($data,2,2);

			$ano = substr($data,4,4);

			$resaux = $ano."-".$mes."-".$dia;

			$res = $resaux;

			return $res;

		}

		//13:"NOME_MES"
		else if($formato == 13){

			$data = date('d/m/Y H:i:s', strtotime($dt));

			$data = str_replace("/","",$data);

			$dia = substr($data,0,2);

			$mes = substr($data,2,2);

			$ano = substr($data,4,4);

			switch (date($mes)) {

					case "01":    $mes = Janeiro;     break;
					case "02":    $mes = Fevereiro;   break;
					case "03":    $mes = Março;       break;
					case "04":    $mes = Abril;       break;
					case "05":    $mes = Maio;        break;
					case "06":    $mes = Junho;       break;
					case "07":    $mes = Julho;       break;
					case "08":    $mes = Agosto;      break;
					case "09":    $mes = Setembro;    break;
					case "10":    $mes = Outubro;     break;
					case "11":    $mes = Novembro;    break;
					case "12":    $mes = Dezembro;    break;

			 }

			 $res = $mes;

			 return $res;
	   }
	   //14:"SOMENTE_DIA"
		else if($formato == 14){

			$data = date('d/m/Y H:i:s', strtotime($dt));

			$data = str_replace("/","",$data);

			$dia = substr($data,0,2);

			$mes = substr($data,2,2);

			$ano = substr($data,4,4);


			 $res = $dia;

			 return $res;
	   }
	   //15:"SOMENTE_ANO"
		else if($formato == 15){

			$data = date('d/m/Y H:i:s', strtotime($dt));

			$data = str_replace("/","",$data);

			$dia = substr($data,0,2);

			$mes = substr($data,2,2);

			$ano = substr($data,4,4);


			 $res = $ano;

			 return $res;
	   }
	   //16:"YYYY-MM-DD"
		else if($formato == 16){

			$dia = substr($dt,0,2);

			$mes = substr($dt,3,2);

			$ano = substr($dt,6,4);


			// $data = date('d/m/Y', strtotime($dt));

			// $data = str_replace("/","",$data);

			// $dia = substr($data,0,2);

			// $mes = substr($data,2,2);

			// $ano = substr($data,4,4);

			$resaux = $ano."-".$mes."-".$dia;

			$res = $resaux;

			return $res;

		}

	}//fim formataData

	public function normalizarCPF($cpf){


		$cpf = str_replace(".","",$cpf);

		$cpf = str_replace("-","",$cpf);

		return $cpf;


	}

	public function normalizarID($id){


		$id = str_replace(".","",$id);

		$id = str_replace("-","",$id);

		return $id;

	}

	public function normalizarCEP($cep){


		$cep = str_replace("-","",$cep);

		return $cep;


	}

	public function normalizarGrau($grau){

		$codgrau  = "";

		if ($grau != ""){

			if ($grau == "E")

				$codgrau = 1;

			elseif ($grau == "M" || $grau == "T" || $grau == "C" )

				$codgrau = 2;

			elseif ($grau == "S" || $grau == "P")

				$codgrau = 3;


		}

		return $codgrau;

	}

	//metodo generico para mascaras
	//pode ser usado para CPF, CEP, TELEFONE
	//Ex: '###.###.###-##', '#####-###'
	public function normalizaMascara($mascara,$string){

	   $string = str_replace(" ","",$string);

	   for($i=0;$i<strlen($string);$i++)

		   {

			  $mascara[strpos($mascara,"#")] = $string[$i];

		   }

	   return $mascara;
	}

	public function normalizaString($frase){

		$frase = preg_replace("([\s/^:-@])", "_",strtr($frase, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC"));

		return $frase;
	}

	public function limpaMascara($frase){

		$frase = ereg_replace("[-/^a-zA-Z_.]", "",strtr($frase, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));

		return $frase;
	}

	public function normalizaCodificacao($txt, $codificacao){

		if ($codificacao == -1)

			$retorno = $txt;

		if ($codificacao == 0)

			$retorno = iconv('UTF-8','ISO-8859-1',$txt);

		if ($codificacao == 1)

			$retorno = iconv('ISO-8859-1','UTF-8',$txt);

		//MSSQL
		if ($codificacao == 2)

			$retorno = iconv('ISO-8859-1', 'UTF-8//TRANSLIT',$txt);

		//MSSQL
		if ($codificacao == 3)

			$retorno = iconv('UTF-8//TRANSLIT', 'ISO-8859-1',$txt);

		return $retorno;

	}

	public function normalizaPreenchimento($numero, $qtdpreenchimento, $preenchimento, $direcao){

		$numeroCompletado = "";

		if ($direcao == 0){

			$numeroCompletado = str_pad($numero, $qtdpreenchimento, $preenchimento, STR_PAD_LEFT);  // retorno "00000006119 "

		}elseif($direcao == 1){

			$numeroCompletado = str_pad($numero, $qtdpreenchimento, $preenchimento);  				// retorno "61190000000"

		}

		return $numeroCompletado;

	}

	public function anti_sql_injection($str) {

	    if (!is_numeric($str)) {

			$str = get_magic_quotes_gpc() ? stripslashes($str) : $str;

			$str = function_exists('pg_escape_string') ? pg_escape_string($str) : pg_escape_string($str);

	    }

	    return $str;
	}

	public function validaDigito($texto){


		$er = '/[^0-9]/'; //encontra qualquer caracter que nao seja digito

		if (preg_match($er,$texto)) $retorno = 0; else	$retorno = 1;


		return $retorno;

	}

	public function injectionPerson($texto){

			$txt = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|or|#|=|\*|\\\\)/"),"-" ,$texto);

	}

	//validar cpf pode retornar str(cpf) sem mascara ou logico
	public function validarCPF($str) {
		if (!preg_match('|^(\d{3})\.?(\d{3})\.?(\d{3})\-?(\d{2})$|', $str, $matches))
		return 0;

		array_shift($matches);
		$str = implode('', $matches);

		for ($i=0; $i < 10; $i++)
			if ($str == str_repeat($i, 11))
		return 0;

		for ($t=9; $t < 11; $t++) {
			for ($d=0, $c=0; $c < $t; $c++)
				$d += $str[$c] * ($t + 1 - $c);

			$d = ((10 * $d) % 11) % 10;
			if ($str[$c] != $d)
				return 0;
		}

		return 1;
	}

	public function dvMod11($valor){

		$lim = 9;

		$fat = 0;

		$mod = 11;

		$somaProd = 0;

		//dv1

		$valor = strval($valor); //echo $valor; exit;

		for($i=0;$i<strlen($valor);$i++){

			if ($fat <= $lim){

				$prod = (++$fat * $valor[$i]);

				$somaProd += $prod;
			}
		}

		$quociente = ($somaProd % $mod);

		if ($quociente==10) $quociente = 0;

		$dv1 = $quociente;


		//dv2

		//inicializacao das variaveis
		$quociente = 0;

		$valor 	  .= $dv1;

		$valor = strval($valor);

		$lim 	   = 9;

		$fat 	   = 0;

		$somaProd  = 0;

		$prod 	   = 0;

		$mod 	   = 11;

		for($j=0;$j<strlen($valor);$j++){

			if ($fat <= $lim){

				$prod = ($fat++ * $valor[$j]);

				$somaProd += $prod;
			}

		}

		$quociente = ($somaProd % $mod);

		if ($quociente==10) $quociente = 0;

		$dv2 = $quociente;

		$dv = $dv1.$dv2;

		return $dv;

	}
	//utilizar no extraset
	public function msword_conversion($str){
		$str = str_replace(chr(130), ',', $str);    // baseline single quote
		$str = str_replace(chr(131), 'NLG', $str);  // florin
		$str = str_replace(chr(132), '"', $str);    // baseline double quote
		$str = str_replace(chr(133), '...', $str);  // ellipsis
		$str = str_replace(chr(134), '**', $str);   // dagger (a second footnote)
		$str = str_replace(chr(135), '***', $str);  // double dagger (a third footnote)
		$str = str_replace(chr(136), '^', $str);    // circumflex accent
		$str = str_replace(chr(137), 'o/oo', $str); // permile
		$str = str_replace(chr(138), 'Sh', $str);   // S Hacek
		$str = str_replace(chr(139), '<', $str);    // left single guillemet
		// $str = str_replace(chr(140), 'OE', $str);   // OE ligature
		$str = str_replace(chr(145), "'", $str);    // left single quote
		$str = str_replace(chr(146), "'", $str);    // right single quote
		// $str = str_replace(chr(147), '"', $str);    // left double quote
		// $str = str_replace(chr(148), '"', $str);    // right double quote
		$str = str_replace(chr(149), '-', $str);    // bullet
		$str = str_replace(chr(150), '-–', $str);    // endash
		$str = str_replace(chr(151), '--', $str);   // emdash
		// $str = str_replace(chr(152), '~', $str);    // tilde accent
		// $str = str_replace(chr(153), '(TM)', $str); // trademark ligature
		$str = str_replace(chr(154), 'sh', $str);   // s Hacek
		$str = str_replace(chr(155), '>', $str);    // right single guillemet
		// $str = str_replace(chr(156), 'oe', $str);   // oe ligature
		$str = str_replace(chr(159), 'Y', $str);    // Y Dieresis
		$str = str_replace('°C', '&deg;C', $str);    // Celcius is used quite a lot so it makes sense to add this in
		$str = str_replace('£', '&pound;', $str);
		$str = str_replace("'", "'", $str);
		$str = str_replace('"', '"', $str);
		$str = str_replace('–', '&ndash;', $str); //Faros:Verificar se resolve o problema de codificacao

		return $str;
	}

	public function normalizaEnvioEmail($email){

		/*
		$email_1 = $email_;

		$email_i = substr($email_,0,1); echo $email_i;

		$email_2 = substr($email_,-15,15); echo $email_2; exit;

		$email_r = str_replace("*",$email_1);  echo $email_r; exit;
		*/

		//return $email_hided;

	}

}

?>
