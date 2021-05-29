<?php 
require_once 'Models/UsuarioModel.php';
require_once 'Controllers/PostagemController.php';
$ata = [];
$p = new PostagemController();
$ata = $p->listarPostagens();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
<h5 id="success"></h5>
<div class="container">
	<div class="col-8">
		<div class="row ">
			<div class="col-1"><img src="https://blogtectoy.com.br/wp-content/uploads/2020/02/sonic-the-hedgehog-2020-3.jpg" width="50px" height="50px">
			</div>
			<div class="col-7">
				<textarea  class="form-control" placeholder="Que se ta pensando amigo?" aria-label="With textarea" rows="2" name="postagem" id="postagem" style="font-size: 27px;resize: none;"></textarea>
				<button id="postar">Postar</button>
			</div>
		</div>

		<?php foreach ($ata as $postagem) { ?>
		<div class="row">
			<div class="row">
				<div class="col-1"><img src="https://blogtectoy.com.br/wp-content/uploads/2020/02/sonic-the-hedgehog-2020-3.jpg" width="50px" height="50px">
				</div>
				<div class="col-1">
				<h6 id="nomeuser"><?php echo $postagem->getUsuario()->getNome();?></h6>
				</div>
			</div>
			<div class="row">
				<p><?php echo $postagem->getConteudo(); ?></p>	
			</div>
			<div class="row row-cols-auto">
				<div class="col">
					<!--Dependendo se o Like tiver ativo ou não ele vai renderizar uma das aberturas da tag button que é a do Like-->
					<?php if($postagem->getNum_Like() == 1){?>
					<button class="btn btn-outline-primary curtir active" id="curtir<?php echo $postagem->getId();?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Usuarios" value="<?php echo $postagem->getId();?>">

					<?php }else{?>

					<button class="btn btn-outline-primary curtir" id="curtir<?php echo $postagem->getId();?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Usuarios" value="<?php echo $postagem->getId();?>">
						<?php }?>
						<i class="bi-hand-thumbs-up-fill" ></i>
						<?php echo $postagem->getTotLike(); ?>
					</button>
				</div>
			</div>
			<div class="row">
				<textarea cols="5" rows="5" id="comment" name="comment"></textarea>
			</div>
			<div class="row">
				<div class="col-1 right"><button class="btn btn-outline-primary">Comentar</button></div>
			</div>
			
		</div>
		<?php echo "<br><br><hr>";} ?>
	</div>	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script type="text/javascript">
	$('.curtir').click(function(){
    	var id_post = $(this).val();
    	var str = document.getElementById("curtir" + id_post).className;
    	var teste = str.substr(str.indexOf("active"));

          $.ajax({
          		type:'POST',
                url: 'Controllers/PostagemController.php?sonic=7',
                data: {
                	id_post:$(this).val(),
                	id_user: 6
                },
                success: function (result) {
                    $("#curtir" + id_post).html("<i class=\"bi-hand-thumbs-up-fill\" ></i>&nbsp"+result);
                   if(teste === "active")
                   		$("#curtir" + id_post).removeClass('active');
                   	else
                   		$("#curtir" + id_post).addClass('active');
                }
            });
	});
	$('#postar').click(function(){
		$.ajax({
			type:'POST',
			url: 'Controllers/PostagemController.php',
			data:{
				id_user:6,
				nm_postagem:$("#postagem").val()
			},
			success: function(result)
			{
				document.getElementById('success').innerHTML = result;
			}
		});
	});

</script>

</body>
</html>