<?php
require_once("../conexao.php");
@session_start();

$id = $_GET['id'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));


//DADOS DA MATRÍCULA


$query_r = $pdo->query("SELECT * FROM turmas2021 where id = '$id' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_r[0]['disciplina'];
$data_inicio = $res_r[0]['data_inicio'];
$data_final = $res_r[0]['data_final'];


//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_final);
$intervalo = $d1->diff($d2);
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);

$query_r = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$nome_disciplina = $res_r[0]['nome'];

?>

<!DOCTYPE html>
<html id="tabela" lang="pt-br">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<head>
	<title>Ficha de Rendimento</title>

	<style>
		@page {
			margin: 0px;
			margin-bottom: 30px;

		}


		.footer {
			margin-top: 20px;
			width: 100%;
			background-color: #ebebeb;
			padding: 10px;
		}

		.cabecalho {
			background-color: #ffffff;
			padding: 10px;
			margin-bottom: 30px;
			width: 100%;
			height: 100px;
		}

		.titulo {
			display: inline-block;
			margin: 0;
			font-size: 16px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;

		}

		.img {
			display: inline-block;
		}


		.subtitulo {
			margin: 5px;
			font-size: 14px;
			font-family: Arial, Helvetica, sans-serif;
		}

		.areaTotais {
			border: 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right: 25px;
			margin-left: 25px;
			position: absolute;
			right: 20;
		}

		.areaTotal {
			border: 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right: 25px;
			margin-left: 25px;
			background-color: #f9f9f9;
			margin-top: 2px;
		}

		.pgto {
			margin: 1px;
		}

		.fonte13 {
			font-size: 13px;
		}

		.esquerda {
			display: inline;
			width: 50%;
			float: left;
		}

		.direita {
			display: inline;
			width: 50%;
			float: right;
		}

		.table {
			padding: 15px;
			font-family: Verdana, sans-serif;
			margin-top: 20px;
			font-size: 12px;
		}

		.texto-tabela {
			font-size: 12px;
		}


		.esquerda_float {

			margin-bottom: 10px;
			float: left;
			display: inline;
		}


		.titulos {
			margin-top: 10px;
			margin-left: 10px;
		}

		.image h2 {
			margin-top: -10px;
		}

		.margem-direita {
			margin-right: 80px;
		}

		hr {
			margin: 8px;
			padding: 1px;
		}

		th,
		td {
			text-align: center;
		}

		.container {
			padding-left: 50px;
			padding-right: 50px;
			padding-bottom: 50px;
		}
	</style>

</head>

<body>
	<?php

		$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '" . $id . "' ");
		$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

		$escola = $res_t[0]['sala'];
		$componente = $res_t[0]['disciplina'];
		$professor = $res_t[0]['professor'];
		$anoensino = $res_t[0]['serie'];
		$letraturma = $res_t[0]['letraturma'];
		$turno = $res_t[0]['turno'];
		$ano = $res_t[0]['ano'];


		$query_p = $pdo->query("SELECT * FROM professores2021 where id = '$professor'");
		$res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);

		$nome_prof = $res_p[0]['nome'];

		$query_s = $pdo->query("SELECT * FROM salas where id = '$escola'");
		$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

		$nome_escola = $res_s[0]['sala'];

		$query_c = $pdo->query("SELECT * FROM disciplinas where id = '$componente'");
		$res_c = $query_c->fetchAll(PDO::FETCH_ASSOC);

		$nome_componente = $res_c[0]['nome'];

	 ?>

	<div class="cabecalho">

		<div class="row titulos">
			<div class="col-sm-2 esquerda_float image">
				<img src="../img/logo-saojose.png" width="170px">
			</div>
			<div class="col-sm-10 esquerda_float">
				<h2 class="titulo"><b><?php echo strtoupper($nome_sec) ?></b></h2>
				<h6 class="subtitulo"><?php echo 'Unidade Escolar: ' . $nome_escola ?></h6>
				<h6 class="subtitulo"><?php echo 'Componente Curricular: ' . $nome_componente ?></h6>
				<h6 class="subtitulo"><?php echo 'Curso: <b> Educação infantil </b> &nbsp&nbsp&nbsp Ano de Ensino: <b>'  . $anoensino . '</b>&nbsp&nbsp&nbsp&nbsp Turma: <b>' . $letraturma . '</b>&nbsp&nbsp&nbsp Turno: <b>' . $turno . '</b>&nbsp&nbsp&nbsp Ano: <b>' . $ano . '</b>' ?></h6>
				<h6 class="subtitulo"><?php echo 'PROFESSOR(A): ' . $nome_prof ?></h6>
				<div style="float: right; margin-right: 5rem;margin-top: -10rem;">
					<img src="../img/logo2.png" width="200px">
				</div>
			</div>
		</div>


	</div>

	<div class="container">

		<div class="row">
			<div class="col-sm-7 esquerda">
			</div>
			<div class="col-sm-5 direita" align="right">
				<big> <small> Data: <?php echo $data_hoje; ?></small> </big>
			</div>
		</div>

		<hr>

		<p align="center"><b>FICHA DE RENDIMENTO DO ALUNO</b></p>
		<br><br>

		<div class="card shadow mb-4">

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ALUNO</th>
								<th>1º</th>
								<th>2º</th>
								<th>3º</th>
								<th>4º</th>
								<th>5º</th>
								<th>6º</th>
								<th>7º</th>
								<th>8º</th>
							</tr>
						</thead>

						<tbody>

							<?php

							$query = $pdo->query("SELECT * FROM matriculas2021 where turma = '$id' order by aluno");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$cont_colunas = 0;
							for ($i = 0; $i < count($res); $i++) {
								foreach ($res[$i] as $key => $value) {
								}
								echo '<tr>';

								$aluno = $res[$i]['aluno'];
								$id_m = $res[$i]['id'];
								$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '" . $id . "' ");
								$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

								$escola = $res_t[0]['sala'];

								$query_s = $pdo->query("SELECT * FROM salas where id = '$escola'");
								$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

								$nome_escola = $res_s[0]['sala'];

								$query_r = $pdo->query("SELECT * FROM alunos2021 where id = '" . $aluno . "' ");
								$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                                if(count($res_r) < 1){
                                    $pdo->query("DELETE FROM matriculas2021 WHERE id = '$aluno'");
                                    continue;
                                }

								$nome_aluno = $res_r[0]['nome'];
								echo '<td style="text-align: left">' . $nome_aluno . '</td>';

								$query_n = $pdo->query("SELECT * FROM notas2021 where  aluno = '" . $aluno . "' and turma = '" . $id . "'");
								$res_n = $query_n->fetchAll(PDO::FETCH_ASSOC);
								for ($j = 0; $j < count($res_n); $j++) {
									foreach ($res_n[$j] as $key => $value) {
									}
									$nota_aluno = $res_n[$j]['nota'];
									echo '<td>' . $nota_aluno . '</td>';
								}

							?>
							<?php } ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</body>

<p style="text-align:center">
	<input class="btn btn-light" type="button" value="Gerar PDF" onclick="funcao_pdf()">
</p>

</html>

<script>
	function funcao_pdf() {
		var pegar_dados = document.getElementById('tabela').innerHTML;

		var janela = window.open('', '', 'width=100px', 'heigth=80px');
		janela.document.write('<htm><head>');
		janela.document.write('<title>PDF</title></head>');
		janela.document.write('<body style="font-family: Arial; font-size: 12px;"');
		janela.document.write(pegar_dados);
		janela.document.write('</body></html>');
		janela.print();
	}
</script>