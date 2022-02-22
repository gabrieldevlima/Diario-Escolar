<?php

require_once("../conexao.php");
@session_start();

$id = $_GET['id'];
$mes = $_GET['mes'];

$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '$id'");
$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

$id_escola= $res_t[0]['sala'];

if($id_escola == 12){
	$html = file_get_contents($url."rel/frequencia_francisco_html2021.php?id=$id&mes=$mes");
	echo $html;
}else if($id_escola == 13){
	$html = file_get_contents($url."rel/frequencia_creche_html2021.php?id=$id&mes=$mes");
	echo $html;
} else if($id_escola == 14){
	$html = file_get_contents($url."rel/frequencia_nucleo_html2021.php?id=$id&mes=$mes");
	echo $html;
} else if($id_escola == 15){
	$html = file_get_contents($url."rel/frequencia_horizonte_html2021.php?id=$id&mes=$mes");
	echo $html;
} else if($id_escola == 16){
	$html = file_get_contents($url."rel/frequencia_saojose_html2021.php?id=$id&mes=$mes");
	echo $html;
}




?>
