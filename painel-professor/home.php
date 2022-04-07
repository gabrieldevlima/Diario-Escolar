<?php
@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];
if (@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'professor') {
	echo "<script language='javascript'> window.location='../index.php' </script>";
	exit();
}

require_once("../conexao.php");


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual . "-" . $mes_atual . "-01";



$query = $pdo->query("SELECT * FROM professores where cpf = '$cpf_usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_prof = $res[0]['id'];

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalDisc = @count($res);

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' and data_final >= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalAndamento = @count($res);

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' and data_final < curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$totalConcluidas = @count($res);

$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' and data_final >= curDate() and serie >= 3");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_notas = 0;
$qtd_notas = 0;
$soma_notas = 0;
$notas_aluno = 0;
$qtd_aprovados = 0;
$qtd_matriculas = 0;
for ($i = 0; $i < count($res); $i++) {
	foreach ($res[$i] as $key => $value) {
	}

	$id_turma = $res[$i]['id'];

	$query2 = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	for ($j = 0; $j < count($res2); $j++) {
		foreach ($res2[$j] as $key => $value) {
		}
		$aluno = $res2[$j]['aluno'];
		$query_notas = $pdo->query("SELECT * FROM notas where aluno = '$aluno' and turma = '$id_turma'");
		$res_notas = $query_notas->fetchAll(PDO::FETCH_ASSOC);
		for ($c = 0; $c < count($res_notas); $c++) {
			foreach ($res_notas[$c] as $key => $value) {
			}
			$notas_aluno += $res_notas[$c]['nota'];
			$soma_notas += $res_notas[$c]['nota'];
			$total_notas++;
			$qtd_notas++;
		}
		$media_individual = $notas_aluno / $qtd_notas;
		if ($media_individual >= 6) {
			$qtd_aprovados++;
		}
		$notas_aluno = 0;
		$media_individual = 0;
		$qtd_notas = 0;
	}
	$qtd_matriculas += count($res2);
}

$media = $soma_notas / $total_notas;
$qtd_aprovados = $qtd_aprovados * 100;
$indice_aprovados = $qtd_aprovados / $qtd_matriculas;

$query_aula = $pdo->query("SELECT * FROM aulas where turma = '$id_turma'");
$res_aula = $query_aula->fetchAll(PDO::FETCH_ASSOC);
$total_aulas = @count($res_aula);


?>


<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Componentes Ministradas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalDisc ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-book fa-2x text-info"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-secondary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total de Aulas Registradas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_aulas ?> </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-list-alt fa-2x text-secondary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Média Geral dos Alunos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php
						if ($media > 0){
							echo number_format($media, 2);
						}else {
							echo 'Informação Indisponível';
						}	 ?> </div>

					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-signal fa-2x text-warning"></i>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Percentual de Alunos na Média</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php
						if ($indice_aprovados > 0){
							echo number_format($indice_aprovados, 2) . '%';
						}else {
							echo 'Informação Indisponível';
						}  ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-percent fa-2x text-success"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>




<div class="row">

	<?php

	$query = $pdo->query("SELECT * FROM professores where cpf = '$cpf_usuario' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_prof = $res[0]['id'];

	$query = $pdo->query("SELECT * FROM turmas where professor = '$id_prof' order by data_final desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	for ($i = 0; $i < count($res); $i++) {
		foreach ($res[$i] as $key => $value) {
		}
		$disciplina = $res[$i]['disciplina'];
		$horario = $res[$i]['horario'];
		$dia = $res[$i]['dia'];
		$ano = $res[$i]['ano'];
		$data_final = $res[$i]['data_final'];
		$id_turma = $res[$i]['id'];
		$turmal = $res[$i]['letraturma'];
		$serie = $res[$i]['serie'];
        $escola = $res[$i]['sala'];

        $query_escola = $pdo->query("SELECT * FROM salas where id = '$escola' ");
		$res_escola = $query_escola->fetchAll(PDO::FETCH_ASSOC);

		$nome_escola = $res_escola[0]['sala'];

		$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

		$query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
		$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);

		$nome_disc = $res_resp[0]['nome'];


		if ($data_final < date('Y-m-d')) {
			$classe_card = 'text-success';
		} else {
			$classe_card = 'text-danger';
		}

	?>

		<div class="col-xl-3 col-md-6 mb-4">
			<a style="text-decoration : none" class="text-dark" href="index.php?pag=turma&id=<?php echo $id_turma ?>" title="Informações da Turma">
				<div class="card <?php echo $classe_card ?> shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold  <?php echo $classe_card ?> text-uppercase"><?php echo $nome_disc ?></div>
								<div class="text-xs text-secondary"><?php echo $serie . " " . $turmal ?> </div>
								<div class="text-xs text-secondary"><?php echo $horario ?> <br> <?php echo $dia ?> </div>
                                <div class="font-weight-bold text-xs text-secondary"><?php echo $nome_escola ?></div>
							</div>
							<div class="col-auto" align="center">
								<i class="far fa-calendar-alt fa-2x  <?php echo $classe_card ?>"></i><br>
								<span class="text-xs"><?php echo $data_finalF ?></span>
							</div>
						</div>
					</div>
				</div>
			</a>
		</div>



	<?php } ?>

</div>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5544089876216624" crossorigin="anonymous"></script>
