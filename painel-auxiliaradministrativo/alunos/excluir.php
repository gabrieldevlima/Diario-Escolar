<?php
require_once("../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM alunos where id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$pdo->query("DELETE FROM alunos WHERE id = '$id'");

echo 'Excluído com Sucesso!';

?>
