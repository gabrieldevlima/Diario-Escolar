<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$data = $_POST['data'];
$aula = $_POST['aula'];
$turma = $_POST['turma'];

if ($nome == "") {
	echo 'O Conteúdo é Obrigatório!';
	exit();
}

if ($data == "") {
	echo 'A Data é Obrigatório!';
	exit();
}

if ($aula == "") {
	echo 'O tipo de Aula é Obrigatório!';
	exit();
}

$query = $pdo->query("SELECT * FROM turmas where id = '$turma' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);


for ($i = 0; $i < count($res); $i++) {
	foreach ($res[$i] as $key => $value) {
	}

	$professor = $res[0]['professor'];
}

$res = $pdo->prepare("INSERT INTO aulas SET turma = :turma, nome = :nome, data = :data,  aula = :aula, professor = :professor");


$res->bindValue(":nome", $nome);
$res->bindValue(":data", $data);
$res->bindValue(":aula", $aula);
$res->bindValue(":turma", $turma);
$res->bindValue(":professor", $professor);

$res->execute();


echo 'Salvo com Sucesso!';
