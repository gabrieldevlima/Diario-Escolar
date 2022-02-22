<?php

require_once("../conexao.php");
@session_start();


$id = $_GET['id'];

$query_t = $pdo->query("SELECT * FROM turmas where id = '$id'");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

@$id_escola = $res_t[0]['sala'];
@$serie = $res_t[0]['serie'];
@$disc = $res_t[0]['disciplina'];


$query_t = $pdo->query("SELECT * FROM salas where id = '$id_escola'");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

@$nome_escola = $res_t[0]['sala'];

$query_d = $pdo->query("SELECT * FROM disciplinas where id = '$disc'");
$res_d = $query_d->fetchAll(PDO::FETCH_ASSOC);

@$nome_disc = $res_d[0]['nome'];


if (strpos($nome_escola, 'U. E. FRANCISCO JOSÉ DOS SANTOS') !== false) {
	$html = file_get_contents($url . "rel/rendimento_francisco_html.php?id=$id");
	echo $html;
}

if (strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false and $serie >= 3) {
	$html = file_get_contents($url . "rel/rendimento_saojose_html.php?id=$id");
	echo $html;
} else if (strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false and $nome_disc == 'E. INFANTIL') {
	$html = file_get_contents($url . "rel/rendimento_infan_saojose_html.php?id=$id");
	echo $html;
} else if (strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false and $serie <= 2 and $serie > 0) {
	$html = file_get_contents($url . "rel/rendimento_menor_saojose_html.php?id=$id");
	echo $html;
}

if (strpos($nome_escola, 'E. M. NOVO HORIZONTE') !== false and $serie < 3) {
	$html = file_get_contents($url . "rel/rendimento_novohorizonte_menor_html.php?id=$id");
	echo $html;
}

if (strpos($nome_escola, 'E. M. NOVO HORIZONTE') !== false and $serie >= 3) {
	$html = file_get_contents($url . "rel/rendimento_novohorizonte_html.php?id=$id");
	echo $html;
}

if (strpos($nome_escola, 'E. M. NÚCLEO DA ALEGRIA') !== false) {
	$html = file_get_contents($url . "rel/rendimento_nucleo_html.php?id=$id");
	echo $html;
}

if (strpos($nome_escola, 'CRECHE MUNICIPAL PROFª MARIA MADALENA') !== false and $serie < 3) {
	$html = file_get_contents($url . "rel/rendimento_creche_html.php?id=$id");
	echo $html;
}