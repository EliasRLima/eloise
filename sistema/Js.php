<html>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function mensagem() {
   var matricula = document.getElementById('inser').value;
   // document.getElementById('retornador').innerHTML =  matricula;
        $.post("Js_aux.php",
        {
          name: matricula
        },
        function(data,status){
            if(status == "success"){
            	document.getElementById('retornador').innerHTML = data;
            }
            else{
            	document.getElementById('retornador').innerHTML = "falha inesperada ao procurar nome";
            }	
        });
}

</script>
<!--<script type="text/javascript">

	function mensagem() {

        var rua = $('#inser').val();
        var urlmanual = "Js_aux.php.php";
        $.post(urlmanual, {"inser" : inser} ,function(result) {
            var div = document.getElementById('retornador');
            div.innerHTML = result;
            alert (result);
        });
       
   	}
</script>-->

<input id="inser" onBlur="mensagem()" type="text"></input>

<button onclick="mensagem()">Matricula para nome?</button>
<p id="retornador"></p>




</body>
</html>

