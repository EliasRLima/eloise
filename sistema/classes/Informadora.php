<?php
/*
 *      Informadora.php
 *
 *
 *      Desenvolvedor:
 *
 *      Copyright
 *
 *      Instituto Federal do Maranhao - Campus Monte Castelo
 */



class Informadora{


	
	
	//$al 	    = "";0: sucesso; 1: error; 2: alerta; 3: informacao	
	//$msg 	    = "";	
	//$classmsg = "alert alert-danger";		
	//$href     = "";
	//$txtHef   = "";		
	//$header   = "";
	public function nav_notificacao( $al
									 ,$msg
									 ,$classmsg		
									 ,$href
									 ,$txtHef		
									 ,$header
									){

		
		switch ($al) {
			case 0:
				$classmsg = "alert alert-success";		
				break;
			case 1:
				$classmsg = "alert alert-danger";		
				break;
			case 2:
				$classmsg = "alert alert-warning";		
				break;
			case 3:
				$classmsg = "alert alert-info";		
				break;
			
			default:
				$classmsg = "alert alert-default";		
				break;
		}

        // <!-- <div class="container-fluid"> -->
        //     <!-- <div class="row">             -->
        //     <!-- <div class="col-lg-12"> -->
        //             <!-- <div class="panel-body"> -->
		?>
                        <div class="<?php echo $classmsg; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $msg; ?> <b class="alert-link"><?php echo $_GET['msg']; //$txtHef (Alterado por Elias) ?></b>

                            <?php header("Location: {$header}"); ?>
                      </div>
        <?php
        //             <!-- </div> -->
        //             <!-- .panel-body -->                
        //     <!-- </div> -->
        // <!-- </div>  -->
	}

	//rota
	//$arFiltro: Filtro com os filtros. Ex.: "_filtro="=>99",",_papel="=>5
	//$viewFiltro: 0: default; 1: exibe sem cryptografia
	//returns: url criptografada
	public function rota($arFiltro,$destino, $viewCaminho){

		$url = "";

		foreach ($arFiltro as $filtro => $valor) {
			
			$url .= $filtro.$valor;	

			if($viewCaminho){

				echo $url."<p>";
				echo $destino.Self::doCodifica($url)."<p>";
				
			} 


		}

		return $destino.Self::doCodifica($url);
	
	}
	
	//Creditos: Douglas Brito de Medeiros 2003
	public function doCodifica($string){

    	return $limpa = urlencode(base64_encode(gzcompress($string)));
		
	}    

	//Creditos: Douglas Brito de Medeiros 2003
	public function doDecodifica($string){
	    //print_r($string);
	    $descomprime = @gzuncompress( base64_decode( $string ) );
	    //print_r ($descomprime);
	    
		if( !$descomprime )
	    {
		   
	        exit("<center>N&atilde;o foi poss&iacute;vel obter endere&ccedil;o.</center>");
	    }
	    $html = htmlentities( $descomprime );
	    $url = parse_url($html);
	    $parametros = explode(",", $url['path']);
	    
		
	    for($i=0;$i<count($parametros);$i++)
	    {        
	        $valor = explode("=", trim( urldecode( strip_tags( $parametros[$i] ) ) ) );
	        $_GET[ $valor[0] ] = $valor[1];        
	        $_GET[ $valor[0] ];
	    }
    
	}


	
		

	

}

?>
