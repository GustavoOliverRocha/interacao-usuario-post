<?php 
require_once 'Models/UsuarioModel.php';
require_once 'Models/PostagemModel.php';
/*$oo = ['Madoka','Oriko','Homura','Mami','Kazumi','Jeanne','Suzune','Iroha','Kuroe'];*/
$u = new UsuarioModel();
/*for($i=0;$i<sizeof($oo);$i++)
{
	$u->setNome($oo[$i]);
	$u->setSenha('admin');	
	var_dump($u->inserir());
}*/
//$sonic;
/*$test = [];
$test = $u->listar();
//var_dump($test);
foreach ($test as $sonic) {
	echo $sonic->getId()." ".$sonic->getNome()."<br><br>";


}*/

$n1 = 1;
$ata = [];
$p = new PostagemModel();
/*$u2 = new UsuarioModel();
$u2->setNome("Sd");
$p->teste($u2);	*/
$ata = $p->listar();
$p->setId(4);
$ete = $p->postsCurtidos();
var_dump($ata);
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
	<?php if ($n1 == 1) {
	  ?>
	<button>Botai maneiro</button>
<?php }else{ ?>

	<button>Butao fueio</button><?php } ?>
	<h5 id="success"></h5>
	<div class="container">
		<?php foreach ($ata as $postagem) { ?>
		<div class="row">
			<img src="">
			<h6 id="nomeuser"><?php echo $postagem->getUsuario()->getNome();?></h6>
		</div>
		<div class="row">
			<p><?php echo $postagem->getConteudo(); ?></p>	

		</div>
		<div class="row row-cols-auto">
			<div class="col">
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
		<?php echo "<hr>";} ?>
	</div>
<button type="button" id="example" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
  Tooltip on top
</button>
<button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right">
  Tooltip on right
</button>
<button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom">
  Tooltip on bottom
</button>
<button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="Tooltip on left">
  Tooltip on left
</button>
<!--<div class="container">
	<div class="row">
		<img src="">
		<h6>Fulano</h6>
	</div>
	<div class="row">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>	

	</div>
	<div class="row row-cols-auto">
		<div class="col"><button class="btn btn-outline-primary"><i class="bi-hand-thumbs-up-fill"></i>0</button></div>
		
	</div>
	<div class="row">
		<textarea cols="5" rows="5"></textarea>
	</div>
	<div class="row">
		<div class="col-1 right"><button class="btn btn-outline-primary">Comentar</button></div>
	</div>
</div>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script type="text/javascript">
	$('.curtir').click(function(){
		/*var comment = $('#comment').serializeArray();
		/*$.each(comment, function(i, campo){
      		$("#nomeuser").append(campo.name + ":" + campo.value + " ");
    	});*/
    	/*$.post("index.php",{ comment: document.getElementById('comment').value },function(data,status){
      alert("Data: " + data + "\nStatus: " + status);
    });*/

    	var id_post = $(this).val();
    	var str = document.getElementById("curtir" + id_post).className;
    	var teste = str.substr(str.indexOf("active"));
    	//alert(teste);
          $.ajax({
                url: 'Models/PostagemModel.php?sonic=7',
                data: {id:$(this).val(),id_user: 6},
                success: function (result) {
                    $("#curtir" + id_post).html("<i class=\"bi-hand-thumbs-up-fill\" ></i>&nbsp"+result);
                   if(teste === "active")
                   		$("#curtir" + id_post).removeClass('active');
                   	else
                   		$("#curtir" + id_post).addClass('active');
                }
            });
	});

</script>

</body>
</html>