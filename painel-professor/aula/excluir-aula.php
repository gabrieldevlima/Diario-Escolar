<?php
require_once("../../conexao.php");

$id = $_POST['id'];

$query_2 = $pdo->query("SELECT * FROM aulas where id = '$id' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$turma = $res_2[0]['turma'];

$query = $pdo->query("SELECT * FROM turmas where id = '$turma' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$serie = $res[0]['serie'];
$escola = $res[0]['sala'];
if ($escola == 12) {
    if ($serie == 4) {
        $pdo->query("DELETE FROM frequencia_francisco_4 WHERE aula = '$id'");
    } else if ($serie == 5) {
        $pdo->query("DELETE FROM frequencia_francisco_5 WHERE aula = '$id'");
    } else if ($serie == 6) {
        $pdo->query("DELETE FROM frequencia_francisco_6 WHERE aula = '$id'");
    } else if ($serie == 7) {
        $pdo->query("DELETE FROM frequencia_francisco_7 WHERE aula = '$id'");
    } else if ($serie == 8) {
        $pdo->query("DELETE FROM frequencia_francisco_8 WHERE aula = '$id'");
    } else if ($serie == 9) {
        $pdo->query("DELETE FROM frequencia_francisco_9 WHERE aula = '$id'");
    }
} else if ($escola == 13) {
    $pdo->query("DELETE FROM frequencia_creche WHERE aula = '$id'");
} else if ($escola == 14) {
    $pdo->query("DELETE FROM frequencia_nucleo WHERE aula = '$id'");
} else if ($escola == 15) {
    $pdo->query("DELETE FROM frequencia_horizonte WHERE aula = '$id'");
} else {
    $pdo->query("DELETE FROM frequencia_jose WHERE aula = '$id'");
}


$pdo->query("DELETE FROM aulas WHERE id = '$id'");

$pdo->query("DELETE FROM validadas WHERE aulas = '$id'");

echo 'Excluído com Sucesso!';
