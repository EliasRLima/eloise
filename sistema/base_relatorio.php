<?php
error_reporting(0);
	//LAYOUT

	include ('../static/layout/ihtml.html');

	include ('../static/layout/ihead_base_styles.html');

	include ('../static/layout/base_styles_fhead.html');

	//./LAYOUT



	require_once('classes/ExecVerificaSessionClass.php');

	require "classes/classe_criptografia_url.php";

	require "classes/Comunicadora.php";

	require "classes/Normalizadora.php";

	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');

	$c = new comunicadora();
		
	$nr = new Normalizadora();

	$baser = new BaseRelatorio();

	$descrelatorio = "Arquivo em PDF";

	//.CONFIGURACOES BASICAS

	//MENU

	include ('../static/layout/layout_menu_nav.php');

	//.MENU

	//CONTEUDO 


	//NOFIFICACAO

	//utilizar a notificacao somente se houver msg de erro

	//echo $cofisa->notificacao(); 

	//./utilizar a notificacao somente se houver msg de erro

	//./NOFIFICACAO

	?>

	    
	<?php //require "../static/layout/estilos.html";?>   
	     
	<?php require "../static/layout/scripts.html";?>   

	<?php include ('../static/layout/layout_icontent_breadcrumbs.php');  ?>


	 <div class="col-xs-12">
	 <!-- PAGE CONTENT BEGINS -->
	
	<?php
		
		
	if( isset($_POST['nomcursista']) && isset($_POST['filtro']) ){

		?>
		
		<div class="page-header">
		    <h1>
		        <? echo "Relat&oacute;rios [".$descrelatorio."]";?>        
		    </h1>
		</div><!-- /.page-header --> 	

		<?php 


		$filtro = strip_tags($_POST['filtro']); 
		
		$nom = strip_tags($_POST['nomcursista']); 

		$titulo = "REGISTROS DE ACESSOS SASHA";


		$baser->inicializa($c, $nr, $filtro, $nom, $titulo);

	
		?>

		    <!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
		<?php include ('../static/layout/layout_fcontent.php');  ?>

		<?php

		//RODAPE

		include ('../static/layout/footer_fhtml.html'); 

		//.RODAPE


		?>
		<?php




	}
	else{

		require "../static/layout/scripts.html";
		
		echo "<a href='../mnprincipal.php'>voltar</a>";
		               exit("Erro!");
	}


class BaseRelatorio{


	public function inicializa($c, $nr, $filtro, $nom, $titulo){

		///////////////////////////////////////////////////////
		//inicilizacoes
		///////////////////////////////////////////////////////
		
		// inicializa variáveis de controle e totalização
		$colore = FALSE;

		//PARAMETROS PARA QUEBRA DE PAGINA
		$contador = 1;

		$ordem = 1;

		$quebra = 17;

		$contaLinha = 0;

		$corlinha = 0;

		$pgF = 1; 

		$pgI = 0; 
		
		$paginaFinal = 1;

		$matArmazenada="";

		$paginaleg = "";

	    $criaHtml = 0;

	    $criarPDF = 1;			    
	    
	    $totCharCURSO = 55;
		
		$totCharNome = 100;
		
		$limitarResultado = 0; 
    	
    	$linhasLimitadasResultado = 5; //efeito somente se $limitarResultado=1 

    	$ti = 0;

		$index = 0;

		$contaLinha = 1;

    	$dti = '2017-03-13';

		    $hoje = date('Y-m-d');

		///////////////////////////////////////////////////////
		//.inicilizacoes
		///////////////////////////////////////////////////////

		//INSERIR DATA NO FORMATO YYYY-MM-DD

		    $dtf = $hoje;

		/// NO PERIODO DE ".$dti." A ".$dtf;

		$table_titulo = "";

	    if ($criaHtml)
	    
	    	echo "<div align='center'><h1>".$titulo."</h1>";
	    
	    echo "<table border='1'>";

	    $table_titulo .="<tr class='titulo-padrao'>";
	    $table_titulo .="<td align='center'>-</td>";
	    $table_titulo .="<td align='center'>MATRÍCULA</td>";
	    $table_titulo .="<td>TURNO</td>";
	    $table_titulo .="<td align='center'>EVENTO</td>";
	    $table_titulo .="<td>#</td>";
	    $table_titulo .="<td align='center'>DATA|HORA</td>";
	    $table_titulo .="<td align='center'>NOME</td>";
	    $table_titulo .="<td>CURSO</td>";
	    $table_titulo .="</tr>";


	    $select = "SELECT "; 

        if ($limitarResultado)

                $select = " SELECT TOP ".$linhasLimitadasResultado." ";



	    $sql  = $select;
        $sql .=" pk_int_acesso as id";
        $sql .=" ,ace_str_aluno as nome";
        $sql .=" ,ace_dat_data as data";
        $sql .=" ,ace_tmp_hora as hora";
        $sql .=" ,ace_str_matricula as matricula";
        $sql .=" ,ace_int_codaluno";
        $sql .=" ,ace_str_curso";
        $sql .=" ,(select curso from bolsista b where b.cod_aluno=a1.ace_int_codaluno AND b.matricula=a1.ace_str_matricula LIMIT 1) as curso";
        $sql .=" ,(select cod_turno from bolsista b where b.cod_aluno=a1.ace_int_codaluno AND b.matricula=a1.ace_str_matricula LIMIT 1) as turno";  
        //XXX:horario configurado manualmente:CONTROLE_HORARIO EM VEZ DE GRADE
        //TODO:ADAPTAR PARA POSTGRES
        $sql .=" ,(select cast(turno_inicio as Time)||'-'||cast(turno_fim as Time)  as turno_inicio from bolsista b, controle_horario ch where b.cod_aluno=a1.ace_int_codaluno AND b.matricula=a1.ace_str_matricula AND ch.cod_padrao_horario = b.cod_padrao_horario and b.cod_turno=ch.cod_turno) as horario";  
        

        //XXX:./horario configurado manualmente:CONTROLE_HORARIO EM VEZ DE GRADE
        $sql .=" ,(case when ace_int_registro=0 then 'SAIDA' else 'ENTRADA' end) as registro";
        $sql .=" FROM";
        $sql .=" tb_acesso a1";

        // echo $sql; exit;

        if ($filtro==1){ //turma

            $sql .=" ORDER BY turma ASC, data DESC, hora DESC, nome ASC";

        }
        if ($filtro==2){ //data
        	
        	$ex = explode("/", $nom);
            $_dia = $ex[0];
            $_mes = $ex[1];
            $_ano = $ex[2];
            
            $sql .=" WHERE date_part('day',ace_dat_data)=".$_dia." and date_part('month',ace_dat_data)=".$_mes." and date_part('year',ace_dat_data)=".$_ano;
            $sql .=" GROUP BY pk_int_acesso, ace_str_aluno, ace_dat_data, ace_tmp_hora, ace_int_codaluno,ace_int_registro,ace_str_matricula,ace_str_curso";
            $sql .=" order by nome asc, data asc, hora asc";
        }
        if ($filtro==3 and isset($nom) ){//hora

            $sql .=" WHERE ace_tmp_hora like '%".$nom."%'";
            $sql .=" GROUP BY pk_int_acesso, ace_str_aluno, ace_dat_data, ace_tmp_hora, ace_int_codaluno,ace_int_registro,ace_str_matricula,ace_str_curso";
            $sql .=" order by nome asc, data asc, hora asc";
        }
        if ($filtro==4){//acessos

            $sql .=" WHERE ace_str_aluno like '%".strip_tags($nom)."%'";
            $sql .=" GROUP BY pk_int_acesso, ace_str_aluno, ace_dat_data, ace_tmp_hora, ace_int_codaluno,ace_int_registro,ace_str_matricula,ace_str_curso";
            $sql .=" order by nome asc, data asc, hora asc";
        }

        if(!isset($filtro) ){

            echo "<a href='index.php'>voltar</a>";
            exit("Erro!");
        
        }else{


			$result = $c->enviar($sql);

			$res = $c->fetch($sql);
       
        
        }    

		require('report/fpdf/fpdf.php'); 

		$pdf = new FPDF('L', 'pt', 'A4');

		$pdf->AddPage(); // adiciona uma página

		// define a fonte
		$pdf->SetFont('Arial','B',10);

		self::cabecalho($pdf, $res, $utf8, $tituloevento);

		$pdf->Write(30,$titulo,1, 0, 'C', true); 

		$pdf->Ln();

		// cor de preenchimento de texto e espessura da linha
		$pdf->SetFillColor(0,100,0);
		$pdf->SetTextColor(255);
		$pdf->SetLineWidth(1);
		
		$pdf->Ln(30);
		self::subcabecalho($pdf);
		$pdf->Ln();
		
		$pdf->SetFillColor(232,232,232);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial', '', 8);



		$totalLinhas = $c->row($sql);

		if ($totalLinhas>$quebra){

			$paginaFinal = round($totalLinhas/$quebra,0);


			//XXX: contagem de pagina inconsistente.
			// Ex: 5 de 6 em vez de 6 de 6	
			if (true){
				$paginaFinal+=1; 
			}

		}
		//./PARAMETROS PARA QUEBRA DE PAGINA

		// percorre os resultados
		
		if($criaHtml)  echo $table_titulo;


		while ($row = $c->extrair($result))

		{

			$contador++;

			$index++;

			$curso = $row['curso'];
			$nome = $row['nome'];

			$matricula = $row['matricula'];

			if($matricula != $matArmazenada) $index = 1;

			if(strlen($row['curso'])>$totCharCURSO){

				$curso = substr($curso,0,$totCharCURSO);
				$curso .= "...";
			}

			if(strlen($row['nome'])>$totCharNome){

				$nome = substr($nome,0,$totCharNome);
				$nome .= "...";
			}

			$pdf->Cell( 90, 14, str_pad($row['matricula'], 2,"0",STR_PAD_LEFT),         'LR',0,'C',$colore);
			$pdf->Cell(15, 14, $row['turno'] ,  'LR',0,'L',$colore);
			$pdf->Cell(65, 14,$row['registro'],  'LR',0,'C',$colore);
			$pdf->Cell( 15, 14, $index,    'LR',0,'L',$colore);
			$pdf->Cell(85, 14,$nr->normalizaRData($row['data'],5).' | '.$row['hora'],  'LR',0,'C',$colore);
			$pdf->Cell(70, 14,$row['horario'],  'LR',0,'C',$colore);
			$pdf->Cell( 180, 14, $nome,    'LR',0,'L',$colore);
			$pdf->Cell(275, 14, iconv('utf8','iso-8859-1',$curso),  'LR',0,'L',$colore);
		
			++$ti;

			$matArmazenada = $row['matricula'];
			// quebra de linha
			$pdf->Ln();
			// inverte cor de fundo
			$colore = !$colore;

			if($contador == $quebra ){

					$contador = 0; $quebra = 30;

					$pgF++;

					$pdf->Cell(795, 0, '',  1, 0, 'C', true); //barra rodape

					$pdf->Ln(10);

					$pdf->Cell(20, 20, date("d/m/Y").' '.date("H:i:s"),  0, 0, 'L', false);

					$pdf->Cell(795, 20, $paginaleg.'p. '.++$pgI,  0, 0, 'R', false);

					$pdf->AddPage();

					$pdf->Ln();

				    self::subcabecalho($pdf);

					$pdf->Ln();

					$pdf->Ln(0);

				}//fim if

				if($criaHtml){


					$cor = "#C1FFC1";

					 echo "<tr class='$cor'>";
	                 echo "<td class='label'>".$contaLinha++."</td>";
	                 echo "<td class='label'>".$row['matricula']."</td>";
	                 echo "<td class='label' align='center'>".$row['turno']."</td>";
	                 echo "<td class='label' align='center'>".$row['registro']."</td>";
	                 echo "<td class='label' align='center'>".$index."</td>";
	                 echo "<td class='label' align='center'>".$nr->normalizarData($row['data'],5)." | ".$row['hora']."</td>";
	                 echo "<td class='label'>".$row['nome']."</td>";
	                 echo "<td class='label'>".$row['curso']."</td>";
	                 echo "</tr>";


				}


		} //fim while
		echo "</table>";

	    if($criaHtml) echo "</div>";

		// define a fonte dos totais
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(795, 20, 'Total: '.$ti,  1, 0, 'R', true);

		self::legenda("","",$pdf,"");

		$nomear = preg_replace("/[^0-9a-zA-Z\.]+/", "",strtr($titulo, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC"));

		$nomearquivo = md5($nomear); 

		if ($criarPDF){

			$pdf->Output('report/'.iconv('utf-8','iso-8859-1',$nomearquivo).'.pdf', 'F');

			
			echo "<div id='box-botoes'>";
			echo "<a href='report/".$nomearquivo.".pdf' target='_blank' class='btn btn-info'><i class='fa fa-print'></i>&nbsp;Baixar PDF</a>";
			echo "&nbsp;";
			// echo "<a href='mnprincipal.php' class='botao-vermelho'>Voltar</a>";
			echo "</div>";




		}
			?></tr><?


	}//./inicializa

	public function subcabecalho($pdf){


		$pdf->Cell( 90, 20, 'Matricula',    1, 0, 'C', true);
		$pdf->Cell(15, 20, 'T', 1, 0, 'C', true);
		$pdf->Cell(65, 20, 'Evento', 1, 0, 'C', true);
		$pdf->Cell( 15, 20, '#',    1, 0, 'C', true);
		$pdf->Cell(85, 20, 'Data|Hora', 1, 0, 'C', true);
		$pdf->Cell(70, 20, 'HORARIO', 1, 0, 'C', true);
		$pdf->Cell( 180, 20, 'Nome',   1, 0, 'C', true);
		$pdf->Cell(275, 20, 'Curso', 1, 0, 'C', true);
	

	}//.subcabecalho

	public function cabecalho($pdf, $res,$utf8,$tituloevento){

		//Titulo
		$_texto1 = "MINISTÉRIO DA EDUCAÇÃO";
		$_texto2 = "INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DO MARANHÃO";
		$_texto3 = "CAMPUS MONTE CASTELO";
		$_texto4 = $tituloevento;

		$texto1 = $_texto1;
		$texto2 = $_texto2;
		$texto3 = $_texto3;
		$texto4 = $_texto4;

		if($utf8==1){

			$texto1 = iconv('utf-8','iso-8859-1',$_texto1);
			$texto2 = iconv('utf-8','iso-8859-1',$_texto2);
			$texto3 = iconv('utf-8','iso-8859-1',$_texto3);
			$texto4 = iconv('utf-8','iso-8859-1',$_texto4);
		}


		$pdf->SetFont('Arial','B',10);

		$pdf->Ln(30); //espaco em branco

		$pdf->Image('../static/img/brasa.jpg',380,30,0);

		$pdf->Ln(50); // quebra de linha

		//MINISTÉRIO DA EDUCAÇÃO
		$pdf->Cell(0, 14, $texto1,'',1,'C',false);

		//INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DO MARANHÃO
		$pdf->Cell(0, 14, $texto2,'',1,'C',false);
		//CAMPUS MONTE CASTELO
		$pdf->Cell(0,14, $texto3,  '', 1, 'C', false);//espaco em branco
		//titulo do evento
		$pdf->Cell(0,14, $texto4,  0, 0, 'C', false);//espaco em branco

		$pdf->Ln(20); // quebra de linha

		$pdf->SetFillColor(255,255,255);

		$pdf->SetTextColor(0);

		$pdf->SetFont('Arial', '', 10);

		$pdf->Ln(5); // quebra de linha

	}//.cabecalho



	public function paginacao($_pdf, $totalProcessado, $tLinhas, $posicaoCell, $posicaoWrite){

		$_pdf->Cell($posicaoCell, 0, ' ',  0, 0, 'R', false);//espaco em branco

		$_pdf->Write($posicaoWrite, 'Página: '.$totalProcessado,  1, 0, 'C', true);

	
	}//.paginacao

	//funcao de progressao de numeros para controle de registrosexibidos
	//por paginas inicial e continua
	//deve ter como entrada um numero e tamanho do array e retornar um array
	//com uma quantidade dos numero de entrada
	public  function quebraPagina($arTotalRegistros, $linhasDoInicio, $linhasPorPaginas,$debug){

		$totalPaginasArred = 0;

		$i = 0;	$numero = 0; $fator = 0; $arNumeros = array();

		if ($arTotalRegistros % $linhasPorPaginas){

			$totalPaginasArred = round(($arTotalRegistros/$linhasPorPaginas),0);

			$totalPaginas = ($totalPaginasArred + 1);

		}else{

			$totalPaginas = ($arTotalRegistros/$linhasPorPaginas);

		}

		while (++$i<=$totalPaginas){

			if ($i == 1 ) $numero = $linhasDoInicio; else $numero += $fator;

			$arNumeros[$i] = $numero; if ($debug == 1) echo $numero."-"; 

			$fator = $linhasPorPaginas;

		}

		return $arNumeros;
	
	}//./quebraPagina

	public function legenda($contador, $arReg, $pdf, $detalhado){


		$cota = "";

		$textoRodape = "NÚCLEO DE TECNOLOGIA DA INFORMAÇÃO - IFMA CAMPUS MONTE CASTELO - SASHA";

		$pdf->SetFont('Arial','B',10);

		// define a fonte dos totais
		$pdf->SetFont('Arial','',6);

		$pdf->Ln(20);

		$pdf->Cell(795, 0, '',  1, 0, 'C', true); //barra rodape

		$pdf->Ln(10);

		$pdf->Write(1, $textoRodape.' - '.$cota,  1, 0, 'C', true);//nome coordenador

	    //imprime em cada cabecalho de folha
		$pdf->SetFont('Arial','B',10);

		$pdf->ln(15);

		$pdf->SetFillColor(105,105,105);

		$pdf->SetTextColor(0);

		$pdf->SetLineWidth(0);

		$pdf->Ln(25);

		$pdf->Ln(15);

		$pdf->SetFillColor(255,255,255);
		// fim imprime em cada cabecalho de folha

	}//.legenda


} //fim classe 

	


?>


