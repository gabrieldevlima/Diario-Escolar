<?php

require_once("../conexao.php");
@session_start();


$aluno = $_GET['id'];

$query_m = $pdo->query("SELECT * FROM matriculas2021 where aluno = '$aluno'");
$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
@$turma = $res_m[0]['turma'];

$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '$turma'");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

@$escola = $res_t[0]['sala'];
@$serie = $res_t[0]['serie'];
@$disc = $res_t[0]['disciplina'];


$query_s = $pdo->query("SELECT * FROM salas where id = '$escola'");
$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

@$nome_escola = $res_s[0]['sala'];

$query_d = $pdo->query("SELECT * FROM disciplinas where id = '$disc'");
$res_d = $query_d->fetchAll(PDO::FETCH_ASSOC);

@$nome_disc = $res_d[0]['nome'];


if (strpos($nome_escola, 'U. E. FRANCISCO JOSÉ DOS SANTOS') !== false) {
	$html = file_get_contents($url . "rel/boletim_francisco_html2021.php?id=$aluno");
	echo $html;
}

if (strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false and $serie >= 3) {
	$html = file_get_contents($url . "rel/boletim_saojose_html2021.php?id=$aluno");
	echo $html;
} else if (strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false and $nome_disc == 'E. INFANTIL') {
	$html = file_get_contents($url . "rel/boletim_infan_saojose_html2021.php?id=$aluno");
	echo $html;
} else if (strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false and $serie < 3) {
	$html = file_get_contents($url . "rel/boletim_menor_saojose_html2021.php?id=$aluno");
	echo $html;
}

if (strpos($nome_escola, 'E. M. NOVO HORIZONTE') !== false and $serie >= 3) {
	$html = file_get_contents($url . "rel/boletim_novohorizonte_html2021.php?id=$aluno");
	echo $html;
}


if (strpos($nome_escola, 'E. M. NOVO HORIZONTE') !== false and $serie < 3) {
	$html = file_get_contents($url . "rel/boletim_novohorizonte_menor_html2021.php?id=$aluno");
	echo $html;
}

if (strpos($nome_escola, 'E. M. NÚCLEO DA ALEGRIA') !== false) {
	$html = file_get_contents($url . "rel/boletim_nucleo_html2021.php?id=$aluno");
	echo $html;
}

if (strpos($nome_escola, 'CRECHE MUNICIPAL PROFª MARIA MADALENA') !== false) {
	$html = file_get_contents($url . "rel/boletim_creche_html2021.php?id=$aluno");
	echo $html;
}
