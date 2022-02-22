<?php
require_once("../conexao.php");
@session_start();

$aluno = $_GET['id'];


//DADOS DA MATRÍCULA


//RECUPERAR O TOTAL DE MESES ENTRE DATAS

?>

<!DOCTYPE html>
<html id="tabela" lang="pt-br">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<head>
		<title>BOLETIM ESCOLAR</title>

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
		$query = $pdo->query("SELECT * FROM matriculas2021 where aluno = '$aluno' order by id");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);

		for ($i = 0; $i < count($res); $i++) {
			foreach ($res[$i] as $key => $value) {
			}

			$turma = $res[$i]['turma'];

			$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '" . $turma . "' ");
			$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

			$escola = $res_t[0]['sala'];
			$serie = $res_t[0]['serie'];
			$letra = $res_t[0]['letraturma'];
			$turno = $res_t[0]['turno'];
			$ano = $res_t[0]['ano'];

			$query_s = $pdo->query("SELECT * FROM salas where id = '$escola'");
			$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

			$nome_escola = $res_s[0]['sala'];

			$query_r = $pdo->query("SELECT * FROM alunos2021 where id = '" . $aluno . "' ");
			$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

			$nome_aluno = $res_r[0]['nome'];
		} ?>

		<div class="cabecalho">

			<div class="row titulos">
				<div class="col-sm-2 esquerda_float image">
					<img src="../img/logo-creche.png" width="200px">
				</div>
				<div class="col-sm-10 esquerda_float">
					<h2 class="titulo"><b><?php echo 'PREFEITURA MUNICIPAL DE SANTA ROSA DO PIAUÍ - PI' ?></b></h2><br>
					<h2 class="titulo"><b><?php echo 'SEMED SANTA ROSA DO PIAUÍ' ?></b></h2>
					<h6 class="subtitulo"><?php echo 'CRECHE MUNICIPAL: PROFª MARIA MADALENA SOARES DA ROCHA ANDRADE'?></h6>
					<h6 class="subtitulo"><?php echo 'CURSO: EDUCAÇÃO INFANTIL &nbsp&nbsp&nbsp&nbsp Série: ' . $serie . '&nbsp&nbsp&nbsp&nbsp Turma: ' . $letra . '&nbsp&nbsp&nbsp&nbsp Turno: ' . $turno . '&nbsp&nbsp&nbsp&nbsp Ano: ' . $ano ?></h6>
					<h6 class="subtitulo"><?php echo 'ALUNO(A): <b>' . strtoupper($nome_aluno) . '</b>' ?></h6>
					<div style="float: right; margin-right: 22rem;margin-top: -10rem;">
						<img src="../img/logo2.png" width="100px">
					</div>
				</div>
			</div>


		</div>

		<div class="container">

			<hr>
			<p align="center"><b>BOLETIM ESCOLAR</b></p>
			<br>

			<p align="right"><b>Legenda:</b> D = Desenvolvimento ED = Em Desenvolvimento CD = Continua em Desenvolvimento</p>

			<div class="card shadow mb-4">

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>COMPONENTE</th>
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

								$query = $pdo->query("SELECT * FROM matriculas2021 where aluno = '$aluno' order by turma");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$cont_colunas = 0;
								for ($i = 0; $i < count($res); $i++) {
									foreach ($res[$i] as $key => $value) {
									}
									echo '<tr>';

									$aluno = $res[$i]['aluno'];
									$id_m = $res[$i]['id'];
									$turma = $res[$i]['turma'];
									$query_t = $pdo->query("SELECT * FROM turmas2021 where id = '" . $turma . "' ");
									$res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

									$escola = $res_t[0]['sala'];
									$disciplina = $res_t[0]['disciplina'];

									$query_d = $pdo->query("SELECT * FROM disciplinas where id = '" . $disciplina . "' ");
									$res_d = $query_d->fetchAll(PDO::FETCH_ASSOC);
									$nome = $res_d[0]['nome'];
									echo '<td>' . $nome . '</td>';
									$query_s = $pdo->query("SELECT * FROM salas where id = '$escola'");
									$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

									$nome_escola = $res_s[0]['sala'];

									$query_n = $pdo->query("SELECT * FROM notas2021 where  aluno = '" . $aluno . "' and turma = '" . $turma . "'");
									$res_n = $query_n->fetchAll(PDO::FETCH_ASSOC);
									for ($j = 0; $j < count($res_n); $j++) {
										foreach ($res_n[$j] as $key => $value) {
										}
										$tipo = $res_n[$j]['tipo'];
										$conta_notas = $j;
										$nota_aluno = $res_n[$j]['nota'];
										$nota_aluno = str_replace(",", ".", $nota_aluno);
										echo '<td>' . $nota_aluno . '</td>';
										$cont_colunas++;
									}

									$c = 8 - $cont_colunas;
									while ($c > 0) {
										echo '<td> </td>';
										$c--;
									}

									$cont_colunas = 0;

								?>
								<?php } ?>



							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

		<div>
		<p align="center">
			_____________________________________________
			<br>
			(Assinatura do Diretor) <br><br><br>
			_____________________________________________
			<br>
			(Assinatura dos pais ou responsáveis)
		</p>



		</div>

</body>

</html>

<p style="text-align:center">
	<input class="btn btn-light" type="button" value="Gerar PDF" onclick="funcao_pdf()">
</p>

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
