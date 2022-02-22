<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];
$id = $_POST['txtid2'];

if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}

if($email == ""){
	echo 'O email é Obrigatório!';
	exit();
}

if($cpf == ""){
	echo 'O CPF é Obrigatório!';
	exit();
}

if (strlen($cpf) != 14) {
	echo 'O CPF digitado não contém os 11 dígitos necessários';
	exit();
}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
else if ($cpf == '000.000.000-00' || 
	$cpf == '111.111.111-11' || 
	$cpf == '222.222.222-22' || 
	$cpf == '333.333.333-33' || 
	$cpf == '444.444.444-44' || 
	$cpf == '555.555.555-55' || 
	$cpf == '666.666.666-66' || 
	$cpf == '777.777.777-77' || 
	$cpf == '888.888.888-88' || 
	$cpf == '999.999.999-99') {
	echo 'O CPF inválido';
	exit();
	 // Calcula os digitos verificadores para verificar se o
	 // CPF é válido
}


if(!$email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL)){
	echo 'Digite um email válido!';
	exit();
}


//VERIFICAR SE O REGISTRO JÁ EXISTE NO BANCO
if($antigo != $cpf){
	$query = $pdo->query("SELECT * FROM secretario where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O CPF já está Cadastrado!';
		exit();
	}
}


//VERIFICAR SE O REGISTRO COM MESMO EMAIL JÁ EXISTE NO BANCO
if($antigo2 != $email){
	$query = $pdo->query("SELECT * FROM secretario where email = '$email' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		echo 'O Email já está Cadastrado!';
		exit();
	}
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO secretario SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone");	

	$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, nivel = :nivel");	
	$res2->bindValue(":senha",preg_replace("/[^0-9]/", "", $cpf));
	$res2->bindValue(":nivel", 'secretario');

}else{
	$res = $pdo->prepare("UPDATE secretario SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone WHERE id = '$id'");

	$res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email WHERE cpf = '$antigo'");	
	
}

$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);

$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $cpf);
$res2->bindValue(":email", $email);


$res->execute();
$res2->execute();

echo 'Salvo com Sucesso!';

?>