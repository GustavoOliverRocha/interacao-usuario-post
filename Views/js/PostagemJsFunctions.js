$('.curtir').click(function(){
	let id_post = $(this).val();
	let str = document.getElementById("curtir" + id_post).className;
	let teste = str.substr(str.indexOf("active"));

  $.ajax({
  		type:'POST',
        url: '?classe=Postagem&metodo=curtirPostagem',
        data: {
        	id_post:$(this).val()
        },
        success: function (result){
        	if(result != '')
        	{
        		$("#curtir" + id_post).html("<i class=\"bi-hand-thumbs-up-fill\" ></i>&nbsp"+result);
                if(teste === "active")
                   	$("#curtir" + id_post).removeClass('active');
                else
                   	$("#curtir" + id_post).addClass('active');
        	}
        }
    });
});

$('#postar').click(function(){
	$.ajax({
		type:'POST',
		url: '?classe=Postagem&metodo=manterPostagem',
		data:{
			nm_postagem:$("#postagem").val()
		},
		success: function(result)
		{
			if(result != '')
				location.reload();
			else if(result == 'false')
				document.getElementById('success').innerHTML = result;
		}
	});
});

$('.editarPostagem').click(function(){
	let id_post = $(this).val();
	let txt = document.getElementById("txtPost"+id_post).innerHTML;
	document.getElementById("postEditavel").value = txt;
	document.getElementById("updatePost").value = $(this).val();

});

$('#updatePost').click(function(){
	$.ajax({
		type:'POST',
		url: '?classe=Postagem&metodo=manterPostagem&id_postagem=' + $(this).val(),
		data:{
			nm_postagem:$("#postEditavel").val()
		},
		success: function(result)
		{
			if(result != '')
				location.reload();
			
			else if(result == 'false')
				document.getElementById('success').innerHTML = result;
		}
	});
});

$('.deletarPost').click(function(){
	let id = $(this).val();
	$.ajax({
		type:'POST',
		url: '?classe=Postagem&metodo=deletarPostagem&id_post='+id,
		success:function(result)
		{
			if(result != '')
				location.reload();//document.getElementById('fullComment').innerHTML = result;
		}
	});
});