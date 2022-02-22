<?php
require_once("../../conexao.php");

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];
$aluno = @$_POST['aluno'];

$query = $pdo->query("SELECT * FROM notas where turma = '$turma' and periodo = '$periodo' and aluno = '$aluno' order by tipo asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_notas = 0;
for ($i = 0; $i < count($res); $i++) {
	foreach ($res[$i] as $key => $value) {
	}

	$nota = $res[$i]['nota'];
	$tipo = $res[$i]['tipo'];
	$id_nota = $res[$i]['id'];
	$nota = str_replace(",",".", $nota);

	if ($tipo == 'Recuperação' or $tipo == 'Prova Final') {
		echo '(' . $tipo .') Nota: ' . $nota . ' <a onclick="deletarNota(' . $id_nota . ')" href="#" title="Deletar Nota"><i class="far fa-trash-alt ml-2 text-danger"></i></a> <br>';
	}else if($tipo == ' ' or $tipo == 'Avaliativa Mensal') {
		$total_notas++;
		echo ($total_notas) . 'º - Avaliação: ' . $nota . ' <a onclick="deletarNota(' . $id_nota . ')" href="#" title="Deletar Nota"><i class="far fa-trash-alt ml-2 text-danger"></i></a> <br>';
	} else {
		$total_notas++;
		echo ($total_notas) .'º - Avaliação: ' . $nota . ' <a onclick="deletarNota(' . $id_nota . ')" href="#" title="Deletar Nota"><i class="far fa-trash-alt ml-2 text-danger"></i></a> <br>';
	}
}
?>



<script type="text/javascript">
	var total_notas = "<?= $total_notas ?>";

	$("#total_notas").text(total_notas);
</script>