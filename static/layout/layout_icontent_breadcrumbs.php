
<?php

//HACK:BANCO
$iso = 1;

$utf = 0;

if ($iso==1)

  header ('Content-type: text/html; charset=ISO-8859-1');

elseif($utf==1) 
  
  header ('Content-type: text/html; charset=UTF-8');

?>



    <div class="main-container ace-save-state" id="main-container">
      <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
      </script>

      <div id="sidebar" class="sidebar responsive ace-save-state">
        <script type="text/javascript">
          try{ace.settings.loadState('sidebar')}catch(e){}
        </script>

        <ul class="nav nav-list">
          <?php if (in_array($_SESSION["loginiwe"],$arSA)   ) { ?>
          <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-plus-circle"></i>
              <span class="menu-text">
                Cadastrar
              </span>

              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
              <li class="">
               <?php $url="_filtro=4";?>
                <a href="cad_aluno.php">
                  <i class="menu-icon fa fa-caret-right"></i>
                  Aluno
                </a>

                <b class="arrow"></b>
              </li>

              <li class="">
               <?php $url="_filtro=4";?>
                <a href="cad_servidor.php">
                  <i class="menu-icon fa fa-caret-right"></i>
                  Servidor
                </a>
                <b class="arrow"></b>
              </li>
              <li class="">
               <?php $url="_filtro=4";?>
                <a href="cad_empresa.php">
                  <i class="menu-icon fa fa-caret-right"></i>
                  Empresa
                </a>

                <b class="arrow"></b>
              </li>              
              
              <li class="">
              <?php $url="_filtro=2";?>
                <a href="cad_estagio.php?url=<?php echo $inf->doCodifica($url)?>">
                  <i class="menu-icon fa fa-caret-right"></i>

                  Est&aacute;gio
                  <b class="arrow"></b>
                </a>

                <b class="arrow"></b>

              </li>

            </ul>
          </li>

           
          <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-pencil"></i>
              <span class="menu-text">
                Editar
              </span>
              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

              <li class="">
                   <?php $url="_filtro=4,_papel=3";?>
                    <a href="sm_busca_estagiario.php"> <!-- seletora.php?url=<?php echo $inf->doCodifica($url)?> -->
                      <i class="menu-icon fa fa-caret-right"></i>
                      Est&aacute;gio
                    </a>

                    <b class="arrow"></b>
                  </li>                
              <li class="">

              <li class="">
                  <?php //$url="_filtro=3,_papel=1";?>
                    <a href="sm_servidor.php"><!--seletora.php?url=<?php echo $inf->doCodifica($url)?>-->
                      <i class="menu-icon fa fa-caret-right"></i>
                      Servidor
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>

                  </li>
              <li class="">
                <a href="sm_empresa.php">
                  <i class="menu-icon fa fa-caret-right"></i>

                  Empresa
                  <b class="arrow"></b>
                </a>

                <b class="arrow"></b>

              </li>
              <li class="">
                <a href="sm_aluno.php">
                  <i class="menu-icon fa fa-caret-right"></i>

                  Aluno
                  <b class="arrow"></b>
                </a>

                <b class="arrow"></b>

              </li>
            </ul>

          </li>

          <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-envelope-square"></i>
              <span class="menu-text">
                Ocorr&ecirc;ncia
              </span>
              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

              <li class="">
                    <a href="cad_ocorrencia.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Nova
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>

                  </li>
              <li class="">
                    <a href="sm_ocorrencia.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Buscar
                    </a>

                    <b class="arrow"></b>
                  </li>                
              
            </ul>

          </li>

          <!--<li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-bus"></i>
              <span class="menu-text">
                Visitas
              </span>
              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

              <li class="">
                    <a href="cad_visita.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Nova
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>

              </li>
              <li class="">
                    <a href="sm_visita.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Buscar
                    </a>

                    <b class="arrow"></b>
              </li>                
              
            </ul>

          </li>-->
          <?php } ?>   
          <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-clipboard"></i>
              <span class="menu-text">Pesquisas</span>
              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

              <li class="">
                    <a href="sm_aluno.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Aluno
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>
              </li>

              <li class="">
                    <a href="sm_grupo.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Grupo de aluno
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>
              </li>

              <li class="">
                    <a href="sm_turma.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Turma
                    </a>

                    <b class="arrow"></b>
              </li> 

              <li class="">
                    <a href="sm_estagio.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Estagio
                    </a>

                    <b class="arrow"></b>
              </li>

              <li class="">
                    <a href="sm_egressos.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Egressos
                    </a>

                    <b class="arrow"></b>
              </li>

              <li class="">
                    <a href="sm_quantitativo.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Quantitativo
                    </a>

                    <b class="arrow"></b>
              </li>               

            </ul>

          </li>
          
         <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-cog"></i>
              <span class="menu-text">Configuracoes</span>
              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
              <?php if (in_array($_SESSION["loginiwe"],$arSA)   ) { ?>
              <li class="">
                    <a href="">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Turma: Cadastar
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>
              </li>

             <!-- <li class="">
                    <a href="buscar_turma.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Editar turma
                      <b class="arrow"></b>
                    </a>

                    <b class="arrow"></b>
              </li>-->

              <li class="">
                    <a href="sm_busca_novo_inativo.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Pessoa: Desativar
                    </a>

                    <b class="arrow"></b>
              </li> 

              <li class="">
                    <a href="sm_busca_inativo.php">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Pessoa: Reativar
                    </a>

                    <b class="arrow"></b>
              </li> 

              <li class="">
                <a href="cad_usuario.php">
                  <i class="menu-icon fa fa-caret-right"></i>
                   Usuario: Cadastrar
                </a>

                <b class="arrow"></b>
              </li>
              <?php $urled = "_filtro=99,_papel=5"; ?>
              <li class="">
                <a href="seletora.php?url=<?php echo $inf->doCodifica($urled);?>">
                  <i class="menu-icon fa fa-caret-right"></i>
                   Usuario: Editar
                </a>

                <b class="arrow"></b>
              </li>               
              <?php } ?>
               <li class="">
                 <a href="trocarSenha.php">
                  <i class="menu-icon fa fa-caret-right"></i>
                  <span class="menu-text">Alterar senha </span>
            </a>

            <b class="arrow"></b>
          </li>
            </ul>

          </li>
          
        
         <li class="">
            <a href="iwe/sair.php">
              <i class="menu-icon fa fa-power-off"></i>
              <span class="menu-text">Sair </span>
            </a>

            <b class="arrow"></b>
          </li>
 
        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
          <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
      </div>




      <div class="main-content">
        <div class="main-content-inner">
         
          <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <?php //$url="_filtro=4,_papel=4";?>
                    <a href="sm_aluno.php"><!-- seletora.php?url=<?php echo $inf->doCodifica($url)?> -->
                      <!-- <i class="fa fa-user"></i> -->
                      In&iacute;cio
                    </a>
              </li>
            </ul><!-- /.breadcrumb -->

            <?/*<div class="nav-search" id="nav-search">
              
            <form name="frmBusca" method="post" action="../sistema/Para_buscar.php" method = "post">
                <input type="text" name="palavra" style="width:120px;font-size: 13px;height: 30px" maxlength="5" placeholder="Busca por ID" /><!--RECEBENDO APENAS 5 CARACTERES, MAX 99.999 CADASTROS-->
                <input type="submit"  value="Buscar" />
            </form>
            </div><!-- /.nav-search -->
          </div>*/?>

          <div class="page-content">

            <div class="row">

