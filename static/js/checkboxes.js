function marca_desmarca()
{
	var e = document.getElementsByTagName("input");
	var master = document.getElementById("checkbox_master");	
	var bool;

	if (master.value == "Marcar Todos") // if (master.checked == true) // <-- substituir "IF" para var master.checked sempre true.
	{ bool = true; 	master.value="Desmarcar Todos"; 	}
	else
	{ bool = false; master.value="Marcar Todos"; 	}

	for(var i=1;i<e.length;i++)
	{
		if (e[i].type=="checkbox")
		{
			e[i].checked = bool;
		}	
	}
	master.checked = false; // se var master.checked for sempre true -> apagar esta linha
}

