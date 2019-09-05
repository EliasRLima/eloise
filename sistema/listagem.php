
<?php
//HACK:O BANCO
// header ('Content-type: text/html; charset=UTF-8');
// header ('Content-type: text/html; charset=ISO-8859-1');



            require "classes/ExecVerificaSessionClass.php";

            require "../static/layout/scripts.html";

           ?>

            <style>
            .descricao{
                display: none;
            }
            .foto-aluno:hover .descricao{
                display: block;
            }
            .icone-foto:hover .descricao{
                display: none;

            }

            </style>

            <script type="text/javascript"> 

            $(document).ready(function(){

                $("#detalhe").hover(function(e){
                    e.preventDefault();

                     var url = $('#detalhe').text();
                    
                        $.ajax({
                             type: "get"
                             , url: "detalhamento.php"
                             , data: "codaluno="+url
                             , beforeSend: function(){
                             } 
                             , complete: function(){ 

                             }  
                             
                             , success: function(data){ 
                                $('#lista').html(data);                    
                             }                     
                             
                             , error: function(){ 
                             }  
                            
                        }); //.ajax

                    });

                  



                });//.ready


            </script>

            <?php

            //XXX: o estilo em cascata da classe mensageira esta influenciando a fonte
            require "classes/Comunicadora.php"; 

            require "classes/Normalizadora.php";
            
            require "classes/Crud.php";

            require "classes/CPessoa.php";
            
            require "classes/Gui.php";
            
            require "classes/Informadora.php";

            $c = new comunicadora();
            
            $nr = new Normalizadora();

            $cpessoa = new CPessoa();
            
            $crud = new Crud();
            
            $gui = new Gui();
            
            $inf = new Informadora();


            $nmform = "Ead";

            $limitarResultado = 0;

            $linhasLimitadasResultado = 5;

            $titform = 
         
            $select = "SELECT "; 

            if ($limitarResultado)

                    $select = " SELECT TOP ".$linhasLimitadasResultado." ";

            //origem relatorio    
            $nom = strip_tags($_GET['_nomcursista']); 
         
            $filtro = strip_tags($_GET['_filtro']);
            //.origem relatorio    
            //XXX
            //origem supervisionar
            $subfiltro = strip_tags($_GET['_papel']);  

            
            //.origem supervisionar

            
            $sqlcolunas ="";
            $sqlfiltro ="";
            
            if($filtro==4){//pessoa
                    
                $sqlcolunas =" id, nome, tipo_cadastro, tipo_papel";
                $sqlfiltro  =" tipo_cadastro in(1)";
                $sqlfiltro .=" and tipo_papel in($subfiltro)";
                $sqlfiltro .=" and nome like '%".strip_tags(utf8_encode($nom))."%'";
            
            }
            if($filtro==2){ //empresa
                
                $sqlcolunas =" id, nome, tipo_cadastro, tipo_papel";
                $sqlfiltro  ="  tipo_cadastro in(2)";
                $sqlfiltro .=" and tipo_papel in($subfiltro)";
                $sqlfiltro .=" and nome like '%".strip_tags(utf8_encode($nom))."%'";
            
            }

            //LINK RECORRENTE
            if ($filtro==1){

                $sqlcolunas =" id, nome, tipo_cadastro, tipo_papel";
                // $sqlfiltro  ="  tipo_cadastro in(2)";
                $sqlfiltro .="  tipo_papel in($subfiltro)";
                // $sqlfiltro .=" and nome like '".strip_tags(utf8_encode($nom))."%'";  
                $sqlfiltro .=" and nome like '".strip_tags($nom)."%'";  
               
                
            }


           


            if(!isset($filtro) ){

                echo "<a href='index.php'>voltar</a>";
                exit("Erro!");
            }    

            else{                

                //readPessoaLine
                //$c: conexao;
                //$crud: ;
                //$colunas: ;
                //$tabela: tabela da relacao com tipo_situacao;
                //$tipoMetodo:  0 - returns set;
                //$tipoMetodo:  1 - returns total row;
                //$tipoMetodo:  2 - returns line - usage: $var_array[<index_array>];
                //$tipoMetodo:  3 - returns instrucao sql;
                //$filtro:  DEFAULT: $filtro="". Instrucao sql livre para concatenar no final de $intrucao:NAO USAR WHERE;
                //$viewsql: 0 - oculta sql; 1 - exibe sql
                $consulta = $cpessoa->readPessoa($c, $crud, $colunas=$sqlcolunas, $tabela="pessoa", $tipoMetodo=0, $filtro=$sqlfiltro, $viewsql=0);

            }
                
                $table_titulo = "";

                echo "<table id='dynamic-table' class='table table-bordered table-hover'>";

                $table_titulo .="<tr>";
                $table_titulo .="<td>ID</td>";
                $table_titulo .="<td class='center'>Nome</td>";
                $table_titulo .="<td colspan='3' class='center'>Ações</td>";
                $table_titulo .="</tr>";

                echo $table_titulo;
                
                $nomcursista = "";

                while($l = $c->extrair($consulta)){
                    
                    ++$ordem;
                    
                    $iconTipo = "";

                    echo "<tr>";

                    echo "<td>".$l['id']."</td>";
                    
                    // echo "<td>".iconv('iso-8859-1', 'utf-8', $l['nome'])."</td>";
                    // echo "<td>";
                    // echo "<div class='action-buttons'>";
                    // echo "<a href='#' class='green bigger-140 show-details-btn' title='Show Details'>";
                    //     echo "<i class='ace-icon fa fa-angle-double-down'></i>";
                    //     echo "<span class='sr-only'>Details</span>";
                    // echo "</a>";
                    // echo "</div>";
                    // echo "</td>";

                    $iconTipo = $gui->renderIcones($l['tipo_papel']);    

                    echo "<td>";

                    echo $iconTipo;

                    $url="_filtro=1,_papel=3,consulta=".utf8_encode($l['nome']);
                    
                    echo "<a href='relatorios.php?url=".$inf->doCodifica($url)."'>".utf8_encode($l['nome'])."</a></td>";
                    
                    echo "<div class='hidden-sm hidden-xs btn-group'>";
                        echo "<td class='center'>";

                            $url="_id=".$l['id'];

                            echo "<a href='edi_pessoa.php?url=".$inf->doCodifica($url)."' class='btn btn-xs btn-success white'>";
                            echo "<i class='ace-icon fa fa-pencil bigger-130'>";
                            echo "</i>";
                            echo "</a>&nbsp;";
                            // echo "<a href='#' class='btn btn-xs btn-danger white'>";
                            //echo "<i class='ace-icon fa fa-trash-o bigger-130'>"; //desativado para habilitar sistema
                          echo "</i>";
                          echo "</a>&nbsp;";

                            echo $gui->renderStatusPessoa($l['tipo_papel']);
                           
                        echo "</td>";
                    echo "</div>";//.hidden-sm hidden-xs btn-group
                    
                    echo "</tr>";
                   
                }

                echo "</table>";

            echo $ordem." Registro(s)";


            
?>
