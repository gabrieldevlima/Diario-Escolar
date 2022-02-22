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
	$id_aula = $res[$i]['id'];

	$dataF = implode('/', array_reverse(explode('-', $data)));

	$query2 = $pdo->query("SELECT * FROM validadas where aulas = '$id_aula' ");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

	if(@count($res2) > 0){
		echo '<a onclick="deletarAula('.$id_aula.')" href="#" title="deletar aula"><i style="margin-right:5px" class="far fa-trash-alt fa-lg ml-2 text-danger"></i></a> <a onclick="upload('.$id_aula.')" href="#"><i  ml-2 text-primary"></i></a> <a style="color:green; font-weight: bolder;"> Aula '. ($i+1) . ' - '. $nome . ' - '. $dataF . '</a>';
		echo '<br><br>';
	}else{
		echo '<a onclick="deletarAula('.$id_aula.')" href="#" title="deletar aula"><i style="margin-right:5px" class="far fa-trash-alt fa-lg ml-2 text-danger"></i></a> <a onclick="upload('.$id_aula.')" href="#"><i  ml-2 text-primary"></i></a> Aula '. ($i+1) . ' - '. $nome . ' - '. $dataF;
		echo '<br><br>';
	}
	


}
?>

