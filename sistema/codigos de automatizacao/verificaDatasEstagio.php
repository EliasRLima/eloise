 <?php

 	$link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
	$queryd = "SELECT YEAR(CURDATE()) as ano,DAY(CURDATE()) as dia,MONTH(CURDATE()) as mes;";
	$qdata = @mysqli_query($link,$queryd);
	$data = @mysqli_fetch_assoc($qdata);
	$data = $data['ano']."-".$data['mes']."-".$data['dia'];


				$query = "select id,situacao_estagio,data_termino,data_inicio,(select nome from pessoa where id = estagiario_id) as estagiario,(select nome from pessoa where id = empresa_id) as empresa from estagio";

				//echo $query;exit();
				$resultado = @mysqli_query($link,$query);
				$num_rows = @mysqli_num_rows($resultado);
				$linha = @mysqli_fetch_assoc($resultado);
				?>
				<?
				// se o número de resultados for maior que zero, mostra os dados
				if($num_rows > 0) {
				// inicia o loop que vai mostrar todos os dados	
					?>
					<p>
						<h3>Numero de estagios localizados: <?echo $num_rows;?></h3>
					</p>
					<p>
						<?if($num_rows >30){
						?><h5>Maximo de 30 resultados, tente ser mais especifico</h5><?
						}?>
					</p>
					<head>
					<style>
					table, th, td {
    				border: 1px solid black;
    				border-collapse: collapse;
					}
					th, td {
   					 padding: 5px;
					}
					th {
  					  text-align: left;
					}
					</style>
					</head>
					<table width="100%">
					<tr>
  			 			 <th>Estagi&aacute;rio</th>
   			 			 <th>Empresa</th>
   			 			 <th>Situacao</th>
   			 			 <th>Andamento</th>
   			 			 <th>Finalizado</th>
  					</tr> <?
  					$controlador = 0;
				do {
					?>
  					<tr>
  						<td><?=$linha['estagiario']?></td>
  						<td><?=$linha['empresa']?></td>
  						<td><?=$linha['situacao_estagio']?></td>
  						<td><?if(strtotime($data) > strtotime($linha['data_inicio']) and strtotime($data) < strtotime($linha['data_termino'])){
  							echo "1";
  						}?></td>
  						<td><?if(strtotime($data) > strtotime($linha['data_termino'])){
  							echo "1";
  						}?></td>			
  					</tr>
						<?
						$controlador+=1;

				}while ($linha = @mysqli_fetch_assoc($resultado) and $controlador <30);
					# code...
				?></table><?
			}
				else{
					?><p></p><?
					echo "Estagio nao localizado!";
				}
				?>