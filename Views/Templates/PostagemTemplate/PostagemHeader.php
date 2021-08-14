<!-- Nesta div contem a foto do usuario,o nome dele -->
<div class="row">
	<div class="col-1">
		<img src="Views/img/outrosUsuarios.png" width="50px" height="50px">
	</div>
	<div class="col-10">
		<h6 id="nomeuser">
			<?php echo $postagem->getUsuario()->getNome();?>
		</h6>
	</div>

	<!-- Caso esta postagem tenha sido feita pelo usuario que logou
		será renderizado um botão dropdown contendo as opções de editar e deletar o post -->
		
	<?php  if($postagem->getIdUser() == $_SESSION['id_user']){ ?>
	<div class="col-1">
		<button type="button" class="btn btn-outline-secondary  dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="bi bi-three-dots-vertical" ></i>
		</button>
		<div class="dropdown-menu">
			<button class="dropdown-item editarPostagem" value="<?php echo $postagem->getId(); ?>" data-toggle="modal" data-target="#editPost">
				Editar Postagem
			</button>
			<button class="dropdown-item deletarPost" value="<?php echo $postagem->getId(); ?>">
				Deletar Postagem
			</button>
		</div>
	</div>
	<?php } ?>
</div>