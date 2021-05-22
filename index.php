<?php 
require_once 'Models/UsuarioModel.php';
$u = new UsuarioModel();
$u->setNome('admin');
$u->setSenha('admin');
$u->logar();
?>