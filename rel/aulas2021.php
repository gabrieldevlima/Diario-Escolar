<?php

require_once("../conexao.php");
@session_start();

$id = $_GET['id'];


$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '$id'");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

@$id_escola= $res_t[0]['sala'];

$query_s = $pdo->query("SELECT * FROM salas where id = '$id_escola'");
$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

@$nome_escola= $res_s[0]['sala'];


if(strpos($nome_escola, 'U. E. FRANCISCO JOSÉ DOS SANTOS') !== false){
	$html = file_get_contents($url."rel/aulas_francisco_html2021.php?id=$id");
	echo $html;
}

if(strpos($nome_escola, 'CRECHE MUNICIPAL PROFª MARIA MADALENA') !== false){
	$html = file_get_contents($url."rel/aulas_creche_html2021.php?id=$id");
	echo $html;
}

if(strpos($nome_escola, 'E. M. NÚCLEO DA ALEGRIA') !== false){
	$html = file_get_contents($url."rel/aulas_nucleo_html2021.php?id=$id");
	echo $html;
}

if(strpos($nome_escola, 'E. M. NOVO HORIZONTE') !== false){
	$html = file_get_contents($url."rel/aulas_horizonte_html2021.php?id=$id");
	echo $html;
}
if(strpos($nome_escola, 'E. M. SÃO JOSÉ') !== false){
	$html = file_get_contents($url."rel/aulas_saojose_html2021.php?id=$id");
	echo $html;
}




?>
