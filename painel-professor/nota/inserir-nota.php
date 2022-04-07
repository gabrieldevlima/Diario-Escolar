<?php
require_once("../../conexao.php");

$nota = $_POST['nota'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$aluno = $_POST['aluno'];
@$tipo = $_POST['tipo'];

if ($nota == null or $nota == " ") {
	echo 'A nota é Obrigatória!';
	exit();
}

$query = $pdo->query("SELECT * FROM turmas where id = '$turma' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);


for ($i = 0; $i < count($res); $i++) {
	foreach ($res[$i] as $key => $value) {
	}

	$serie = $res[0]['serie'];
}
if ($serie >= 3) {

	$query = $pdo->query("SELECT * FROM notas where turma = '$turma' and periodo = '$periodo' and aluno = '$aluno' order by id asc ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_notas = 0;
	$total_rec = 0;
	$total_pf = 0;
	$soma1 = 0;
	$soma2 = 0;
	$rec2 = 0;
	$rec1 = 0;
	for ($i = 0; $i < count($res); $i++) {
		foreach ($res[$i] as $key => $value) {
		}

		$nota1 = $res[$i]['nota'];
		$tipo1 = $res[$i]['tipo'];
		$id_nota = $res[$i]['id'];


		if ($tipo1 != 'Recuperação' and $tipo1 != 'Prova Final') {
			$total_notas = $total_notas + 1;
			if ($i < 4) {
				$soma1 = $soma1 + floatval($nota1);
			} else {
				$soma2 = $soma2 + floatval($nota1);
			}
		}

		if ($tipo1 == 'Recuperação' and $i >= 8 and $total_rec == 0) {
			$total_rec = $total_rec + 1;
		}

		if ($tipo1 == 'Recuperação') {
			$total_rec = $total_rec + 1;
		}

		if ($tipo1 == 'Prova Final') {
			$total_pf = $total_pf + 1;
		}

		if ($i == 4 and $tipo1 == 'Recuperação') {
			$rec1 = $nota1;
		}
		if ($i > 4 and $tipo1 == 'Recuperação') {
			$rec2 = $nota1;
		}
	}

	if ($total_notas == 4 and $tipo == 'Avaliativa Mensal' and $soma1 < 24 and $total_rec == 0) {
		echo 'Você só pode inserir uma nota de tipo "Avaliativa Mensal" após ter inserido a nota de tipo "Recuperação" pois o aluno não atingiu os 24 pontos do semestre!!';
		exit();
	}

	if ($i <= 4 and $soma1 >= 24 and $total_rec == 0 and $tipo == 'Recuperação') {
		echo 'Você só pode inserir uma nota de tipo "Recuperação" somente se o aluno não atingir o total de 24 pontos no semestre';
		exit();
	}

	if ($soma2 >= 24 and $total_rec == 1 and $tipo == 'Recuperação') {
		echo 'Você só pode inserir uma nota de tipo "Recuperação" somente se o aluno não atingir o total de 24 pontos no semestre';
		exit();
	}

	if ($total_notas == 8 and ($tipo != 'Recuperação' and $tipo != 'Prova Final')) {
		echo 'Você já inseriu as 8 notas Avaliativa Mensal deste aluno!';
		exit();
	}

	if ($total_notas < 4 and $tipo == 'Recuperação') {
		echo 'Para registrar uma nota de tipo "Recuperação" é necessário ter inserido as 4 notas do aluno!!';
		exit();
	}

	if ($total_notas < 8 and $tipo == 'Prova Final') {
		echo 'Para registrar uma nota de tipo "Prova Final" é necessário ter inserido as 8 notas do aluno!';
		exit();
	}
	if ($total_notas >= 8 and $tipo == 'Prova Final' and ($soma1 + $soma2 >= 48)) {
		echo 'Para registrar uma nota de tipo "Prova Final" é necessário que o aluno não tenha atingido o mínimo de 48 pontos!';
		exit();
	}

	if ($total_notas >= 8 and $tipo == 'Prova Final' and ((($rec1 * 4) + $soma2 >= 48) or (($rec2 * 4) + $soma1 >= 48) or (($rec2 * 4) + ($rec1 * 4) >= 48))) {
		echo 'Para registrar uma nota de tipo "Prova Final" é necessário que o aluno não tenha atingido o mínimo de 48 pontos!';
		exit();
	}

	if ($total_notas >= 8 and $total_rec >= 1 and $tipo == 'Prova Final' and (($rec2 * 4 + $soma1) >= 48)) {
		echo 'Para registrar uma nota de tipo "Prova Final" é necessário que o aluno não tenha atingido o mínimo de 48 pontos!';
		exit();
	}

	if ($total_notas < 8 and $tipo == 'Recuperação' and $total_rec > 0) {
		echo 'Para registrar uma nota de tipo "Recuperação" é necessário ter inserido as 8 notas do aluno!';
		exit();
	}

	if ($total_rec >= 2 and $tipo == 'Recuperação') {
		echo 'O sistema só permite a inserção de no máximo 1 nota de tipo "Recuperação" por semestre!';
		exit();
	}

	if ($total_pf >= 1 and $tipo == 'Prova Final') {
		echo 'O sistema só permite a inserção de no máximo 1 nota de tipo "Prova Final"!';
		exit();
	}

	if (($rec1 * 4) + $soma2 >= 48 and $tipo == 'Prova Final') {
		echo 'Para registrar uma nota de tipo "Prova Final" é necessário que o aluno não tenha atingido o mínimo de 48 pontos!';
		exit();
	}

	$total_notas = 0;
	$total_rec = 0;
	$total_pf = 0;
	$soma1 = 0;
	$soma2 = 0;
	$rec2 = 0;
	$rec1 = 0;
}else {
    $tipo = 'Conceito';
}

$query = $pdo->query("SELECT * FROM turmas where id = '$turma' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($res); $i++) {
	foreach ($res[$i] as $key => $value) {
	}

	$professor = $res[0]['professor'];
}

$res = $pdo->prepare("INSERT INTO notas SET turma = :turma, nota = :nota, periodo = :periodo, professor = :professor, aluno = :aluno, tipo = :tipo");

$res->bindValue(":nota", $nota);
$res->bindValue(":turma", $turma);
$res->bindValue(":periodo", $periodo);
$res->bindValue(":professor", $professor);
$res->bindValue(":aluno", $aluno);
$res->bindValue(":tipo", $tipo);

$res->execute();

echo 'Salvo com Sucesso!';
