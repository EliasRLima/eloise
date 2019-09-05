
<?php
//HACK:O BANCO
// header ('Content-type: text/html; charset=UTF-8');
// header ('Content-type: text/html; charset=ISO-8859-1');
?>

    <style>
   /* .descricao{
        display: none;
    }
    .foto-aluno:hover .descricao{
        display: block;
    }
    .icone-foto:hover .descricao{
        display: none;

    }*/

    </style>

<?php


            require "classes/ExecVerificaSessionClass.php";

            require "classes/classe_criptografia_url.php";

            require "../static/layout/cabecalho.html";

            require "../static/layout/iniciohead.html";

            require "../static/layout/iniciopg.html";

            require "../static/layout/estilos.html";

            ?><link rel="stylesheet" type="text/css" href="../static/layout/css/tables.css"/><?

            require "../static/layout/scripts.html";

            require "classes/Comunicadora.php"; //atencao que o estilo em cascata da classe mensageira esta influenciando a fonte

            require "classes/Normalizadora.php";


            $nmform = "Ead";

            $limitarResultado = 1;

            $linhasLimitadasResultado = 1;

           
            $select = "SELECT "; 

            if ($limitarResultado)

                    $select = " SELECT TOP ".$linhasLimitadasResultado." ";

            // doDecodifica($_GET['url']);

            $filtro = $_GET['codaluno']; //echo "->".$filtro; exit;

            $c = new comunicadora();

            $nr = new Normalizadora();


            $idetalhe  = $select;
           
            $idetalhe .=" WHERE .. =".$filtro;

            if(!isset($filtro) ){

                echo "<a href='index.php'>voltar</a>";
                exit("Erro!");
            }    

            else
                //echo $idetalhe; exit;
                $consulta = $c->enviar($idetalhe);

            $ordem = 0;


            $table_titulo = "";

            echo "<br/>";
            echo "<center>Detalhes</center>";
            echo "<table border='0'>";

            $table_titulo .="<tr class='titulo-padrao'>";
            $table_titulo .="</tr>";

            echo $table_titulo;



            while($l = $c->extrair($consulta)){

                $itxi = $select;                
                $itxi = "";                
             

                if(($ordem % 2) == 0){

                     $cor = 'row1';

                     if ($l['DETALHE']==2) $cor .= ' alerta'; else if ($l['DETALHE']>=3) $cor .= ' excedido';

                }
                else{
                     $cor = 'row2';

                     if ($l['DETALHE']==2) $cor .= ' alerta'; else if ($l['DETALHE']>=3) $cor .= ' excedido';

                }

                ++$ordem;

                $url="codaluno=".$l['ID'];

                
                echo "<tr class='$cor'>";
                echo "<td class='label' align='center'>".$l['MATRICULA']."</td>";
                

                echo "</tr>";
            }
            echo "</table>";
       

            
        ?>
