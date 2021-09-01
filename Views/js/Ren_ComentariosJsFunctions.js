
/**
* ren = renderizados
* Funções para os comentarios renderizados
* Por algum motivo o jquery não funciona com tags renderizadas manualmente
* pelo PHP(ajax) ou o proprio Javascript
* após a pagina estar pronta
*/
function deletarC($yui)
{
	alert($($yui).val());
	let id = $($yui).val();
	$.ajax({
		type:'POST',
		url:'?classe=Comentario&metodo=deletarComment',
		data:{
			id_comment: $($yui).val(),
		},
		success:function(result)
		{
				document.getElementById("divComment"+id).innerHTML = "";
		}
	});

}
function editarC($id)
{
	let commentTxt = document.getElementById("com_ren_"+$($id).val()).innerHTML;
	document.getElementById("com_ren_"+$($id).val()).style.display = "none";
	document.getElementById("ren_commentEdit"+$($id).val()).value = commentTxt;
	document.getElementById("ren_divEdit"+$($id).val()).style.display = "initial";
}
function editarC2($e)
{
	document.getElementById("ren_divEdit"+$($e).val()).style.display = "none";
	document.getElementById("com_ren_"+$($e).val()).style.display = "initial";
}
function editarC3($e)
{
	
//Lembre aparentemente o $(this).val() ele tem um escopo
//Por isso o document.getElementById estava dando erro
let id_com = $($e).val();
$.ajax({
	type:'POST',
	url: '?classe=Comentario&metodo=newComment',
	data:{
		id_comment: $($e).val(),
		comment:$("#ren_commentEdit"+$($e).val()).val()
	},
	success: function(result)
	{
		if(result != ''){
			document.getElementById("ren_divEdit"+id_com).style.display = "none";
			document.getElementById("com_ren_"+id_com).innerHTML = result;
			document.getElementById("com_ren_"+id_com).style.display = "initial";
			document.getElementById("c"+id_com).innerHTML = result;
		}
		else if(result == 'false')
			document.getElementById('success').innerHTML = result;
	}
});
}