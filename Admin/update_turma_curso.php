
<?php
 $link = @mysqli_connect('LocalHost','root','','eloisebd') or die("sem conexao");
 
 $queryE = "select id,t.CodigoTurma,(select descricao from curso where id = t.Curso) as NomeCurso,t.Curso from turma_curso t;";
 $resultadoE = @mysqli_query($link,$queryE);
 $num_rowsE = @mysqli_num_rows($resultadoE);
 $linhaE = @mysqli_fetch_assoc($resultadoE); 

				if($num_rowsE > 0) {

					do {

						$query = "update turma_curso e set e.decricao =\"".$linhaE['CodigoTurma']." - ".$linhaE['NomeCurso']."\" where id =".$linhaE['id'].";";
						echo $query; //exit();
						$resultado = @mysqli_query($link,$query);
						echo $query;
						?><br></br><?
					}while($linhaE = @mysqli_fetch_assoc($resultadoE));
					// fim do if 
					}
				else{
					echo "Sem turma localizada";?><br></br><?
					}

?>