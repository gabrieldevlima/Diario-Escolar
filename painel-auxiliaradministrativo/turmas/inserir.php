<?php
require_once("../../conexao.php");

$disciplina = $_POST['disciplina'];
$sala = $_POST['sala'];
$professor = $_POST['professor'];
$data_inicio = $_POST['data_inicio'];
$data_final = $_POST['data_final'];
$turno = $_POST['turno'];
$letraturma = $_POST['letraturma'];
$dia = $_POST['dia'];
$ano = $_POST['ano'];
$serie = $_POST['serie'];

$id = $_POST['txtid2'];

if($disciplina == ""){
	echo 'O Componente curricular é obrigatório';
	exit();
}

if($ano == ""){
	echo 'O ano é obrigatório';
	exit();
}
if($sala == ""){
	echo 'A escola é obrigatório';
	exit();
}

if($professor == ""){
	echo 'O professor é obrigatório';
	exit();
}

if($serie == ""){
	echo 'O Ano de Ensino é curricular é obrigatório';
	exit();
}


if($id == ""){
	$res = $pdo->prepare("INSERT INTO turmas SET disciplina = :disciplina, sala = :sala, professor = :professor, data_inicio = :data_inicio, data_final = :data_final, turno = :turno, letraturma = :letraturma, dia = :dia, ano = :ano, serie = :serie");

}else{
	$res = $pdo->prepare("UPDATE turmas SET disciplina = :disciplina, sala = :sala, professor = :professor, data_inicio = :data_inicio, data_final = :data_final, turno = :turno, letraturma = :letraturma, dia = :dia, ano = :ano , serie = :serie WHERE id = '$id'");

}

$res->bindValue(":disciplina", $disciplina);
$res->bindValue(":sala", $sala);
$res->bindValue(":professor", $professor);
$res->bindValue(":data_inicio", $data_inicio);
$res->bindValue(":data_final", $data_final);
$res->bindValue(":turno", $turno);
$res->bindValue(":letraturma", $letraturma);
$res->bindValue(":dia", $dia);
$res->bindValue(":ano", $ano);
$res->bindValue(":serie", $serie);


$res->execute();


echo 'Salvo com Sucesso!';

?>
