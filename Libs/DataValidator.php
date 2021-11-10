<?php

class DataValidator
{
	static function isLogado()
	{
		if(session_status() == 1)
			session_start();
		if(isset($_SESSION['id_user'],$_SESSION['nm_user']))
			return true;
		session_unset();
        session_destroy();
        return false;
	}

	static function cleanData($data)
	{
		$data = trim($data);
  		$data = stripslashes($data);
   		$data = htmlspecialchars($data);
   		return $data;
	}

	static function testInputsCadastroUsuario()
	{
		$temErros = false;
		$nm_erros = [];
		/**
		 * Caso os campos estejam vazios.
		 * 
		 **/
		if(strlen($_REQUEST['nm_user']) < 1)
		{
			$temErros = true;
			$nm_erros["nm_user"] = "Campo nome de usuario vazio";
		}
		if(strlen($_REQUEST['nm_pessoal']) < 1)
		{
			$temErros = true;
			$nm_erros["nm_pessoal"] = "Campo nome vazio";
		}
		if(strlen($_REQUEST['senha']) < 1)
		{
			$temErros = true;
			$nm_erros["senha"] = "Campo senha vazio";
		}

		//Caso os campos excedam o numero de caracteres
		if(strlen($_REQUEST['nm_user']) > 30)
		{
			$temErros = true;
			$nm_erros["nm_user"] = "Nome de Usuario excede os 30 caracteres.";
		}
		if(strlen($_REQUEST['nm_pessoal']) > 60)
		{
			$temErros = true;
			$nm_erros["nm_pessoal"] = "Nome Pessoal excede os 30 caracteres.";
		}
		if(strlen($_REQUEST['senha']) > 30)
		{
			$temErros = true;
			$nm_erros["senha"] = "Senha excede o maximo de caracteres";
		}

		//Caso as senhas não batam
		if(strlen($_REQUEST['confirm_senha']) < 1)
		{
			$temErros = true;
			$nm_erros["senha_confirm"] = "Confirme a Senha";
		}
		else if($_REQUEST['confirm_senha'] != $_REQUEST['senha'])
		{
			$temErros = true;
			$nm_erros["senha"] = "As senhas não batem.";
		}

		if($temErros)
			return $nm_erros;
		else
			return false;

	}

	static function tratarImg()
	{
		$temErros = false;
		$nm_erros = [];
		//$largura = "255";
		//$altura = "255";
		if(empty($_FILES['foto']['name']))
		{
			$temErros = true;
			$nm_erros['arquivo'] = "Selecione uma imagem.";
		}
		if(strlen($_FILES['foto']['name']) > 80)
		{
			$temErros = true;
			$nm_erros['nome'] = "Nome da imagem excede os 80 caracteres.";
		}
		if($_FILES['foto']["size"] > 1000000)
		{
			$temErros = true;
			$nm_erros['tamanho'] = "Imagem excede ".((1000000/1000)/1000)." Mb";
		}
		if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $_FILES['foto']["type"]))
		{
			$temErros = true;
            $nm_erros['tipo'] = "Insira uma imagem valida.";
		}

		if($temErros)
			return $nm_erros;
		else
			return false;
	}
}