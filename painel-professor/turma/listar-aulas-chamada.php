<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];


$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' order by data ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome = $res[$i]['nome'];
	$data = $res[$i]['data'];
	$arquivo = $res[$i]['arquivo'];
	$id_aula = $res[$i]['id'];


	


	echo 'Aula '. ($i+1)  . '&thinsp; -' .'<a href="index.php?pag=turma&funcao=fazerchamada&id='. $turma .'&id_periodo='.$periodo .'&id_aula='. $id_aula .'" title="Realizar Frequência"><i class="far fa-calendar ml-2 text-info fa-lg"></i></a> ' . '&thinsp; - '. $nome ;

	 $query2 = $pdo->query("SELECT * FROM chamadas where aula = '$id_aula' ");
     $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
     

	if(@count($res2) > 0){
		echo '<i class="far fa-check-square ml-2 text-success fa-lg"></i>';
		echo '<br>';
		echo '<br>';
	}else{
		echo '<br>';
		echo '<br>';
	}


}
	?>
