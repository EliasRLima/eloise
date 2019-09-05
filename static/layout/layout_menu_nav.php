<?php

//retirado

$c = new Comunicadora();

$instrucao = "SELECT ";
$instrucao .= " autenticador";
$instrucao .= " FROM";
$instrucao .= " login";
$instrucao .= " WHERE";
$instrucao .= " nivel in (1)";



//provisorio descobrir onde esta a data
//$dia=date('d'); $mes=date('m');; $ano=date('Y');
//provisorio descobrir onde esta a data


$q  = $c->enviar($instrucao);

$arSA = array();

$i = 0;

while($l = $c->extrair($q))

    $arSA[] = $l['autenticador'];  

require "classes/Informadora.php"; 

$inf = new Informadora();


?>
<link rel="stylesheet" href="../static/css/fonts/MonteCristo/font.css"/>
<style>
.eloise{font-family: 'MonteCristo',Arial, Tahoma, sans-serif; font-size: 48px; color:#FFFFFF;}
</style>
  <body class="no-skin" onload="setFocus();">
    <div id="navbar" class="navbar navbar-default          ace-save-state">
      <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
          <span class="sr-only">Toggle sidebar</span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
          <a href="sm_aluno.php" class="navbar-brand"> <!-- seletora.php?url=eJyLT8vMKSnKtzXRiS9ILEjNsTUBAD%2F3Bm8%3D -->
            <small>
              <i class="fa fa-snowflake-o"></i>
              <label class="eloise">Eloise</label>
            </small>
          </a>
        </div>

         <?php 

     

               ?>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
          
          <ul class="nav ace-nav">


            <li class="light-blue dropdown-modal">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                
                <span class="user-info">
                  <small>Usu&aacute;rio:</small>
                  <?php echo utf8_encode($_SESSION['dispname']); ?>
                </span>

                <i class="ace-icon fa fa-caret-down"></i>
              </a>

              <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li>
                  <a href="iwe/sair.php">
                    <i class="ace-icon fa fa-power-off"></i>
                    Logout                    
                  </a>
                </li>
              </ul>
            </li>


          </ul>
        </div>
      </div><!-- /.navbar-container -->
    </div>