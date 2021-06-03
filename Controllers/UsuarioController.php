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
}