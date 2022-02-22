<?php 
require_once("conexao.php");
@session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];

$query = $pdo->prepare("SELECT * FROM usuarios where email = :email and senha = :senha");
$query->bindValue(":senha", $senha);
$query->bindValue(":email", $email);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

	$_SESSION['id_usuario'] = $res[0]['id'];
	$_SESSION['nome_usuario'] = $res[0]['nome'];
	$_SESSION['cpf_usuario'] = $res[0]['cpf'];
	$_SESSION['nivel_usuario'] = $res[0]['nivel'];

	$nivel = $res[0]['nivel'];

	if($nivel == 'Admin'){
		echo "<script language='javascript'> window.location='painel-adm' </script>";
	}

	if($nivel == 'professor'){
		echo "<script language='javascript'> window.location='painel-professor' </script>";
	}

	if($nivel == 'secretario'){
		echo "<script language='javascript'> window.location='painel-secretario' </script>";
	}

	if($nivel == 'coordenadiretor'){
		echo "<script language='javascript'> window.location='painel-coordenadiretor' </script>";
	}

	if($nivel == 'auxadministrativo'){
		echo "<script language='javascript'> window.location='painel-auxiliaradministrativo' </script>";
	}
	
}else{
	echo "<script language='javascript'> window.alert('E-mail ou Senha incorreta!') </script>";
	echo "<script language='javascript'> window.location='index.php' </script>";	
}


?>