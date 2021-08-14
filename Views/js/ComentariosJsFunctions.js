$('.comentar').click(function(){
	let id_post = $(this).val();
	$.ajax({
		type:'POST',
		url: '?classe=Comentario&metodo=manterComentario',
		data:{
			id_post: id_post,
			comment: $("#comment"+ id_post ).val(),
		},
		success: function(result)
		{
			if(result != '')
			{	
				document.getElementById('comentariosPost'+ id_post).innerHTML = "";
				document.getElementById('comentariosPost'+ id_post).innerHTML = result;
			}
		}

	});
});

$('.editarComent').click(function(){

	let commentTxt = document.getElementById("c"+$(this).val()).innerHTML;
	document.getElementById("c"+$(this).val()).style.display = "none";
	document.getElementById("commentEdit"+$(this).val()).value = commentTxt;
	document.getElementById("divEdit"+$(this).val()).style.display = "initial";
	
});

$(".cancelarEdit").click(function(){
	document.getElementById("divEdit"+$(this).val()).style.display = "none";
	document.getElementById("c"+$(this).val()).style.display = "initial";
});


$('.updateComment').click(function(){
	//Lembre aparentemente o $(this).val() ele tem um escopo
	//Por isso o document.getElementById estava dando erro
	let id_com = $(this).val();
	$.ajax({
		type:'POST',
		url: '?classe=Comentario&metodo=newComment',
		data:{
			id_comment: $(this).val(),
			comment:$("#commentEdit"+$(this).val()).val()
		},
		success: function(result)
		{
			if(result != ''){
				document.getElementById("divEdit"+id_com).style.display = "none";
				document.getElementById("c"+id_com).innerHTML = result;
				document.getElementById("c"+id_com).style.display = "initial";
			}
			else if(result == 'false')
				document.getElementById('success').innerHTML = result;
		}
	});
});



$('.mostrarComments').click(function(){

	$.ajax({
		type:'POST',
		url: '?classe=Comentario&metodo=exibirComentarios',
		data:{
			id_post: $(this).val(),
		},
		success:function(result)
		{
			if(result != '')
				document.getElementById('fullComment').innerHTML = result;
		}
	});
});

$('.deletarComment').click(function(){
	let id = $(this).val();
	$.ajax({
		type:'POST',
		url:'?classe=Comentario&metodo=deletarComment',
		data:{
			id_comment: $(this).val(),
		},
		success:function(result)
		{
			document.getElementById("divComment"+id).innerHTML = "";
		}
	});
});