<?php

require_once './Models/UsuarioModel.php';
require_once './Libs/ViewRender.php';
class UsuarioController
{
	public function login()
	{
		$obj_view = new ViewRender('./Views/loginUsuario.php');
		if(isset($_REQUEST['nm_user'],$_REQUEST['senha']))
		{
			$obj_user = new UsuarioModel();
			$obj_user->setNome($_REQUEST['nm_user']);
			$obj_user->setSenha($_REQUEST['senha']);
			if($obj_user->logar())
			{
				session_start();
				$_SESSION['id_user'] = $obj_user->getId();
				$_SESSION['nm_user'] = $obj_user->getNome();
				$_SESSION['nm_pessoal'] = $obj_user->getNomePessoal();
				$_SESSION['nm_foto'] = $obj_user->getNomeFoto();
				RouteController::redirect('?classe=Postagem&metodo=listarPostagens');
			}
			else
			{
				echo "Login ou senha erados";
			}

		}
		$obj_view->showPage();
	}

    public function deslogar()
    {
        session_start();
        session_unset();
        session_destroy();
        session_register_shutdown();
        
        if(!DataValidator::isLogado() && session_status()==1)
            RouteController::redirect("?classe=Usuario&metodo=login");
        else    
            exit("ERROR: não deslogou as sessões estão".isset($_SESSION['usuario'],$_SESSION['senha'],$_SESSION['id'])."<br>".var_dump(session_status()));
    }  

    public function manterUsuario()
    {

    	$obj_view = new ViewRender('./Views/cadastroUsuario.phtml');
    	if(count($_POST) > 0)
    	{
    		$tem_erros = DataValidator::testInputsCadastroUsuario();
    		if(!$tem_erros)
    		{
	    		$obj_user = new UsuarioModel();
	    		$obj_user->setNome(DataValidator::cleanData($_POST['nm_user']));
	    		$obj_user->setNomePessoal(DataValidator::cleanData($_POST['nm_pessoal']));
	    		$obj_user->setSenha(DataValidator::cleanData($_POST['senha'])); 		
	    		if($obj_user->inserir())
	    		{	
	    			echo "";
	    			return;
	    		}
	    		else
	    			exit("Houve um erro");
    		}
    		else
    		{
    			foreach($tem_erros as $err)
    				echo $err."<br>";
    			return;
    		}
    	}
    	$obj_view->showPage();
    }

    public function configu()
    {
    	session_start();
    	$obj_view = new ViewRender('./Views/UsuarioConfig.phtml');
    	if(count($_FILES) > 0)
    	{
    		$tem_erros = DataValidator::tratarImg();
    		if(!$tem_erros)
    		{
    			$obj_user = new UsuarioModel();
    			$arq_foto = $_FILES["foto"];
    			
    			$obj_user->setId($_SESSION['id_user']);
    			$obj_user->setNomeFoto($arq_foto['name']);
    			if($obj_user->inserirFoto() && $this->inserirImg())
    				$_SESSION['nm_foto'] = $obj_user->getNomeFoto();
    		}
    		else
    		{
    			foreach($tem_erros as $err)
    				echo "<p style='color:red'>".$err."</p>";
    		}
    			
    	}
    	$obj_view->showPage();
    	//var_dump($_FILES["foto"]);
    	
    }

    private function inserirImg()
    {
    	$diretorio = "Views/img/fotosPerfil/".$_SESSION['id_user']."/".$_FILES["foto"]['name'];
    	$img = $_FILES["foto"]['tmp_name'];
    	if(!is_dir("Views/img/fotosPerfil/".$_SESSION['id_user']."/"))
			mkdir("Views/img/fotosPerfil/".$_SESSION['id_user']."/");
		if(copy($img,$diretorio))
			return true;
		else
			return false;
    }
}