<?php

@session_start();
$pag = "turma";

require_once("../conexao.php");

$id_turma = $_GET['id'];

$query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_2[0]['disciplina'];
$dia = $res_2[0]['dia'];
$ano = $res_2[0]['ano'];
$turmal = $res_2[0]['letraturma'];
$serie = $res_2[0]['serie'];
$escola = $res_2[0]['sala'];
$data_final = $res_2[0]['data_final'];

$data_finalF = implode('/', array_reverse(explode('-', $data_final)));


$query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
$nome_disc = $res_resp[0]['nome'];

$query_resp = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
$total_alunos = @count($res_resp);

$query_esc = $pdo->query("SELECT * FROM salas where id = '$escola' ");
$res_esc = $query_esc->fetchAll(PDO::FETCH_ASSOC);
$nome_escola = $res_esc[0]['sala'];

$query_resp = $pdo->query("SELECT * FROM aulas where turma = '$id_turma'");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
$total_aulas = @count($res_resp);
?>

<h6 style="font-weight: bold;"><?php echo $nome_disc . '  -  ' .  $serie . '  ' . $turmal . '   -  ' . $nome_escola ?></h6>
<hr>

<small>
  <div class="mb-3">
    <span class="mr-3"><i><b>Dias de Aula </b> <?php echo $dia ?></i></span>
    <span class="mr-3"><i><b>Ano Início </b> <?php echo $ano ?></i></span>
    <span class="mr-3"><i><b>Data da Conclusão </b> <?php echo $data_finalF ?></i></span>
  </div>
</small>

<hr>

<div class="row">

<div class="col-xl-4 col-md-6 mb-4">
    <a style="text-decoration : none" class="text-dark" href="index.php?pag=aula&funcao=aulas&id=<?php echo $id_turma ?>&aulas=sim" title="Lançar Aulas">
      <div class="card text-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold  text-info text-uppercase">AULAS</div>
              <div class="text-xs text-secondary"> REGISTROS DE AULAS</div>
            </div>
            <div class="col-auto" align="center">
              <i class="fas fa-chalkboard-teacher fa-3x  text-info"></i><br>
              <span class="text-xs"></span>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <a style="text-decoration : none" class="text-dark" href="index.php?pag=frequencia&funcao=chamada&id=<?php echo $id_turma ?>&chamada=sim" title="Registrar Frequência">
      <div class="card text-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold  text-warning text-uppercase">FREQUÊNCIA</div>
              <div class="text-xs text-secondary"> <?php echo $total_alunos ?> ALUNOS DA TURMA</div>
            </div>
            <div class="col-auto" align="center">
              <i class="far fa-calendar-alt fa-3x  text-warning"></i><br>
              <span class="text-xs"></span>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <a style="text-decoration : none" class="text-dark" href="index.php?pag=nota&funcao=notas&id=<?php echo $id_turma ?>&notas=sim" title="Registrar Nota">
      <div class="card text-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold  text-success text-uppercase">NOTAS OU CONCEITO</div>
              <div class="text-xs text-secondary"> LANÇAR NOTAS OU CONCEITO </div>
            </div>
            <div class="col-auto" align="center">
              <i class="fas fa-file-invoice fa-3x  text-success"></i><br>
              <span class="text-xs"></span>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5544089876216624" crossorigin="anonymous"></script>
