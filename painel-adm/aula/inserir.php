<?php 
require_once("../../conexao.php"); 

$tipo = $_POST['tipo'];

$antigo = $_POST['antigo'];

$id = $_POST['txtid2'];

if($tipo == ""){
	echo 'O tipo de Aula é Obrigatório!';
	exit();
}


//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $tipo){
	$query = $pdo->query("SELECT * FROM aula where tipo = '$tipo' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O tipo de Aula já está Cadastrada!';
		exit();
	}
}



if($id == ""){
	$res = $pdo->prepare("INSERT INTO aula SET tipo = :tipo");	


}else{
	$res = $pdo->prepare("UPDATE aula SET tipo = :tipo WHERE id = '$id'");

	
	
}

$res->bindValue(":tipo", $tipo);

$res->execute();


echo 'Salvo com Sucesso!';

?>