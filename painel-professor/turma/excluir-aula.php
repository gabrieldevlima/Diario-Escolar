<?php 
require_once("../../conexao.php"); 

$id = $_POST['idaula'];


$pdo->query("DELETE FROM aulas WHERE id = '$id'");

$pdo->query("DELETE FROM validadas WHERE aulas = '$id'");

$pdo->query("DELETE FROM chamadas WHERE aula = '$id'"); 

echo 'Excluído com Sucesso!';

?>