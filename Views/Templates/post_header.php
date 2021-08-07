<!-- Div da imagem e o nome de usuario no post-->
<div class="row">
	<div class="col-1">
		<img src="https://blogtectoy.com.br/wp-content/uploads/2020/02/sonic-the-hedgehog-2020-3.jpg" width="50px" height="50px">
	</div>
	<div class="col-10">
		<h6 id="nomeuser">
			<?php echo $postagem->getUsuario()->getNome();?>
		</h6>
	</div>
	<?php  if($postagem->getIdUser() == $_SESSION['id_user']){ ?>
	<div class="col-1">
		<!--<button type="button" class="btn btn-outline-primary active" id="editarPostagem" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar este post" value="" data-target="#editPost">
			<i class="bi bi-pencil" ></i>
		</button>-->
			<button type="button" class="btn btn-outline-primary active editarPostagem" value="<?php echo $postagem->getId(); ?>"  data-toggle="modal" data-target="#editPost">
					<i class="bi bi-pencil" ></i>
			</button>
	</div>
	<?php } ?>
</div>