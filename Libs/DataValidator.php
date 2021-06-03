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
}