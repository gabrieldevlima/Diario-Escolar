<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];
$datanasc = $_POST['datanasc'];

$id = $_POST['txtid2'];


//RECUPERAR A DATA PARA VERIFICAR SE O ALUNO É MENOR DE IDADE



//VERIFICAR SE O RESPONSÁVEL ESTÁ CADASTRADO


if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}

if($datanasc == ""){
	echo 'O Data de Nascimento do aluno é Obrigatório!';
	exit();
}




//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO





//SCRIPT PARA SUBIR FOTO NO BANCO


if($id == ""){
	$res = $pdo->prepare("INSERT INTO alunos SET nome = :nome, datanasc = :datanasc");	


}else{
	
	$res = $pdo->prepare("UPDATE alunos SET nome = :nome, datanasc = :datanasc WHERE id = '$id'");	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":datanasc", $datanasc);


$res->execute();


echo 'Salvo com Sucesso!';

?>