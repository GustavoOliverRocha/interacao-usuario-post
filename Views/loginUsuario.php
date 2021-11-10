<!DOCTYPE html>
<html>
<?php require_once "Templates/head.php"; ?>
<body>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-3">
			<?php 
				if(isset($_GET['sucess']))
					echo '<p class="text-success">Cadastro Realizado com Sucesso</p>';
			?>
			<form method="POST" action="">
				<div class="row">
					<input type="text" class="form-control-lg" placeholder="Usuario ou e-mail" name="nm_user">
				</div>
				<div class="row">
					<input type="password" class="form-control-lg" placeholder="Senha" name="senha">
				</div><br>
				<div class="row d-grid gap-2 col-6 mx-auto">
					<button type="submit" class="btn btn-outline-primary">Logar</button>
				</div>
				<div class="row">
					<p>Não está cadastrado?<a href="?classe=Usuario&metodo=manterUsuario">Cadastre-se</a></p>

					<p>Esqueceu a senha?<a href="">Recupere-a</a></p>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>