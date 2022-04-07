<?php
@session_start();
$pag = "frequencia";

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
$professor = $res_2[0]['professor'];

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

<div class="modal" id="modal-chamada-aulas" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?><small><a style="text-decoration : none" target="_self" title="Gerar Relatório de Frequência" href="index.php?pag=frequencia&funcao=relfrequencia&id=<?php echo $id_turma ?>"><span class="ml-3">Relatório</span></a></small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="minhaTabela" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nº</th>
                      <th>Conteúdo</th>
                      <th>Data</th>
                      <th>Frequência</th>
                      <th>Status</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $turma = $_GET['id'];
                    $query = $pdo->query("SELECT * FROM aulas where turma = '$turma' order by data");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                      foreach ($res[$i] as $key => $value) {
                      }
                      $cont = $i + 1;
                      $nome = $res[$i]['nome'];
                      $data = $res[$i]['data'];
                      $dataF = implode('/', array_reverse(explode('-', $data)));

                      $id_aula = $res[$i]['id'];
                      echo '<tr>';
                      echo '<td style="text-align: center;">' . $cont . '</td>';
                      echo '<td style="text-align: center;">' . $nome . '</td>';
                      echo '<td style="text-align: center;">' . $dataF . '</td>';
                      echo '<td style="text-align: center;"><a href="index.php?pag=frequencia&funcao=fazerchamada&id=' . $_GET['id'] . '&id_aula=' . $id_aula . '" title="Realizar Frequência"><i class="far fa-calendar ml-2 text-info fa-lg"></i></a></td>';

                      if ($escola == 12) {
                        if ($serie == 4) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_4 where aula = '$id_aula' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 5) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_5 where aula = '$id_aula' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 6) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_6 where aula = '$id_aula' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 7) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_7 where aula = '$id_aula' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 8) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_8 where aula = '$id_aula' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 9) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_9 where aula = '$id_aula' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        }
                      } else if ($escola == 13) {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_creche where aula = '$id_aula' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      } else if ($escola == 14) {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_nucleo where aula = '$id_aula' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      } else if ($escola == 15) {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_horizonte where aula = '$id_aula' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      } else {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_jose where aula = '$id_aula' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      }
                      if (@count($res_2) > 0) {
                        echo '<td style="text-align: center; color: Green;font-weight: bold;"> Realizada </td>';
                      } else {
                        echo '<td style="text-align: center; color: Red;font-weight: bold;"> Pendente </td>';
                      }
                      echo '</tr>';
                    }   ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

      </div>
      </small>

      <div align="center" id="mensagem_chamada" class="">

      </div>

    </div>

  </div>
</div>
</div>

<div class="modal" id="modal-chamada" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5><a target="_self" href="index.php?pag=frequencia&funcao=chamada&id=<?php echo $id_turma ?>&chamada=sim"><span class="fa fa-arrow-left text-secondary"></i>&nbsp;&nbsp;</span></a></h5>
        <h5 class="modal-title">Realizar Frequência </h5>
      </div>
      <form id="form3" method="POST">
        <div class="modal-body">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Código</th>
                      <th>Ações</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php

                    $query = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma' order by id asc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                      foreach ($res[$i] as $key => $value) {
                      }

                      $aluno = $res[$i]['aluno'];

                      $query_r = $pdo->query("SELECT * FROM alunos where id = '$aluno' order by nome asc");
                      $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                      $nome = $res_r[0]['nome'];
                      $id_aluno = $res_r[0]['id'];

                      $id_turma_chamada = $_GET['id'];
                      $id_aluno_chamada = $id_aluno;
                      $id_aula_chamada = $_GET['id_aula'];

                      if ($escola == 12) {
                        if ($serie == 4) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_4 where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 5) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_5 where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 6) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_6 where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 7) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_7 where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 8) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_8 where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        } else if ($serie == 9) {
                          $query_2 = $pdo->query("SELECT * FROM frequencia_francisco_9 where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        }
                      } else if ($escola == 13) {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_creche where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                        $presenca = $res_2[0]['presenca'];
                      } else if ($escola == 14) {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_nucleo where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      } else if ($escola == 15) {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_horizonte where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      } else {
                        $query_2 = $pdo->query("SELECT * FROM frequencia_jose where turma = '$_GET[id]' and aluno = '$id_aluno' and aula = '$_GET[id_aula]' ");
                        $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                      }

                      $presenca = $res_2[0]['presenca'];

                      if ($presenca == 'P') {
                        $classe_chamada = 'text-success';
                      } else if ($presenca == 'F') {
                        $classe_chamada = 'text-danger';
                      } else {
                        $classe_chamada = 'text-info';
                      }

                    ?>


                      <tr>
                        <td>
                          <?php echo $nome ?>
                        </td>

                        <td><?php echo $id_aluno ?></td>

                        <td>
                          <a href="index.php?pag=<?php echo $pag ?>&funcao=presenca&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>" class='text-success mr-1' title='Presente'><i class='far fa-check-circle'></i></a>

                          <a href="index.php?pag=<?php echo $pag ?>&funcao=falta&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>" class='text-danger mr-1' title='Falta'><i class='far fa-circle'></i></a>


                          <a href="index.php?pag=<?php echo $pag ?>&funcao=justificado&id_aluno=<?php echo $id_aluno ?>&id_aula=<?php echo $_GET['id_aula'] ?>&id=<?php echo $_GET['id'] ?>" class='text-info mr-1' title='Justificar Falta'><i class='fas fa-question-circle fa-1x'></i></a>

                          <?php if ($presenca != "") { ?>
                            - <span class="<?php echo $classe_chamada ?>"><?php echo $presenca ?></span>
                          <?php } ?>

                        </td>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modal-frequencias" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Relatórios de Frequências Mensal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=01&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Jan </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=02&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Fev </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=03&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Mar </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=04&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Abr </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=05&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Mai </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=06&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Jun </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=07&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Jul </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=08&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Ago </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=09&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Set </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=10&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Out </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=11&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Nov </i></span></a>
        <a style="margin-left:10px" target="_blank" title="Gerar Relatório de Frequência" href="../rel/frequencia.php?mes=12&id=<?php echo  @$_GET['id'] ?>"><span class="ml-2"><i> Dez </i></span></a>

        </span>

        <hr style="margin:5px">

      </div>
    </div>
  </div>
</div>

<?php

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "chamada") {
  echo "<script>$('#modal-chamada-aulas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "relfrequencia") {
  echo "<script>$('#modal-frequencias').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "fazerchamada") {
  $id_aula_nova_chamada = $_GET['id_aula'];
  $id_turma_nova_chamada = $_GET['id'];

  $query = $pdo->query("SELECT * FROM aulas where id = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(count($res) > 0){

    if ($escola == 12) {
        if ($serie == 4) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_4 where aula = '$id_aula_nova_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 5) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_5 where aula = '$id_aula_nova_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 6) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_6 where aula = '$id_aula_nova_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 7) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_7 where aula = '$id_aula_nova_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 8) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_8 where aula = '$id_aula_nova_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 9) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_9 where aula = '$id_aula_nova_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }
      } else if ($escola == 13) {
        $query = $pdo->query("SELECT * FROM frequencia_creche where aula = '$id_aula_nova_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 14) {
        $query = $pdo->query("SELECT * FROM frequencia_nucleo where aula = '$id_aula_nova_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 15) {
        $query = $pdo->query("SELECT * FROM frequencia_horizonte where aula = '$id_aula_nova_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
        $query = $pdo->query("SELECT * FROM frequencia_jose where aula = '$id_aula_nova_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      if (@count($res) == 0) {
        $query_m = $pdo->query("SELECT * FROM matriculas where turma = '$id_turma_nova_chamada' order by id asc");
        $res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($res_m); $i++) {
          foreach ($res_m[$i] as $key => $value) {
          }
          $aluno = $res_m[$i]['aluno'];
          if ($escola == 12) {
            if ($serie == 4) {
              $pdo->query("INSERT INTO frequencia_francisco_4 SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
            } else if ($serie == 5) {
              $pdo->query("INSERT INTO frequencia_francisco_5 SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
            } else if ($serie == 6) {
              $pdo->query("INSERT INTO frequencia_francisco_6 SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
            } else if ($serie == 7) {
              $pdo->query("INSERT INTO frequencia_francisco_7 SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
            } else if ($serie == 8) {
              $pdo->query("INSERT INTO frequencia_francisco_8 SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
            } else if ($serie == 9) {
              $pdo->query("INSERT INTO frequencia_francisco_9 SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
            }
          } else if ($escola == 13) {
            $pdo->query("INSERT INTO frequencia_creche SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($escola == 14) {
            $pdo->query("INSERT INTO frequencia_nucleo SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($escola == 15) {
            $pdo->query("INSERT INTO frequencia_horizonte SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else {
            $pdo->query("INSERT INTO frequencia_jose SET turma = '$id_turma_nova_chamada', aluno =  '$aluno', aula = '$id_aula_nova_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          }
        }
      }

  }

  echo "<script>$('#modal-chamada').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "presenca") {

  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];

  $query = $pdo->query("SELECT * FROM aulas where id = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(count($res) > 0){
    if ($escola == 12) {
        if ($serie == 4) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_4 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 5) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_5 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 6) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_6 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 7) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_7 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 8) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_8 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 9) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_9 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }
      } else if ($escola == 13) {
        $query = $pdo->query("SELECT * FROM frequencia_creche where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 14) {
        $query = $pdo->query("SELECT * FROM frequencia_nucleo where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 15) {
        $query = $pdo->query("SELECT * FROM frequencia_horizonte where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
        $query = $pdo->query("SELECT * FROM frequencia_jose where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      if (@count($res) > 0) {
        $id_chamada = $res[0]['id'];

        if ($escola == 12) {
          if ($serie == 4) {
            $pdo->query("UPDATE frequencia_francisco_4 SET presenca = 'P' where id = '$id_chamada'");
          } else if ($serie == 5) {
            $pdo->query("UPDATE frequencia_francisco_5 SET presenca = 'P' where id = '$id_chamada'");
          } else if ($serie == 6) {
            $pdo->query("UPDATE frequencia_francisco_6 SET presenca = 'P' where id = '$id_chamada'");
          } else if ($serie == 7) {
            $pdo->query("UPDATE frequencia_francisco_7 SET presenca = 'P' where id = '$id_chamada'");
          } else if ($serie == 8) {
            $pdo->query("UPDATE frequencia_francisco_8 SET presenca = 'P' where id = '$id_chamada'");
          } else if ($serie == 9) {
            $pdo->query("UPDATE frequencia_francisco_9 SET presenca = 'P' where id = '$id_chamada'");
          }
        } else if ($escola == 13) {
          $pdo->query("UPDATE frequencia_creche SET presenca = 'P' where id = '$id_chamada'");
        } else if ($escola == 14) {
          $pdo->query("UPDATE frequencia_nucleo SET presenca = 'P' where id = '$id_chamada'");
        } else if ($escola == 15) {
          $pdo->query("UPDATE frequencia_horizonte SET presenca = 'P' where id = '$id_chamada'");
        } else {
          $pdo->query("UPDATE frequencia_jose SET presenca = 'P' where id = '$id_chamada'");
        }
      } else {

        if ($escola == 12) {
          if ($serie == 4) {
            $pdo->query("INSERT INTO frequencia_francisco_4 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($serie == 5) {
            $pdo->query("INSERT INTO frequencia_francisco_5 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($serie == 6) {
            $pdo->query("INSERT INTO frequencia_francisco_6 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($serie == 7) {
            $pdo->query("INSERT INTO frequencia_francisco_7 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($serie == 8) {
            $pdo->query("INSERT INTO frequencia_francisco_8 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          } else if ($serie == 9) {
            $pdo->query("INSERT INTO frequencia_francisco_9 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
          }
        } else if ($escola == 13) {
          $pdo->query("INSERT INTO frequencia_creche SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
        } else if ($escola == 14) {
          $pdo->query("INSERT INTO frequencia_nucleo SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
        } else if ($escola == 15) {
          $pdo->query("INSERT INTO frequencia_horizonte SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
        } else {
          $pdo->query("INSERT INTO frequencia_jose SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'P', data = curDate(), professor = '$professor'");
        }
      }
  }

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_aula=$id_aula_chamada';</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "falta") {

  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];

  $query = $pdo->query("SELECT * FROM aulas where id = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(count($res) > 0){
    if ($escola == 12) {
        if ($serie == 4) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_4 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 5) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_5 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 6) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_6 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 7) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_7 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 8) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_8 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 9) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_9 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }
      } else if ($escola == 13) {
        $query = $pdo->query("SELECT * FROM frequencia_creche where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 14) {
        $query = $pdo->query("SELECT * FROM frequencia_nucleo where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 15) {
        $query = $pdo->query("SELECT * FROM frequencia_horizonte where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
        $query = $pdo->query("SELECT * FROM frequencia_jose where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      if (@count($res) > 0) {
        $id_chamada = $res[0]['id'];
        if ($escola == 12) {
          if ($serie == 4) {
            $pdo->query("UPDATE frequencia_francisco_4 SET presenca = 'F' where id = '$id_chamada'");
          } else if ($serie == 5) {
            $pdo->query("UPDATE frequencia_francisco_5 SET presenca = 'F' where id = '$id_chamada'");
          } else if ($serie == 6) {
            $pdo->query("UPDATE frequencia_francisco_6 SET presenca = 'F' where id = '$id_chamada'");
          } else if ($serie == 7) {
            $pdo->query("UPDATE frequencia_francisco_7 SET presenca = 'F' where id = '$id_chamada'");
          } else if ($serie == 8) {
            $pdo->query("UPDATE frequencia_francisco_8 SET presenca = 'F' where id = '$id_chamada'");
          } else if ($serie == 9) {
            $pdo->query("UPDATE frequencia_francisco_9 SET presenca = 'F' where id = '$id_chamada'");
          }
        } else if ($escola == 13) {
          $pdo->query("UPDATE frequencia_creche SET presenca = 'F' where id = '$id_chamada'");
        } else if ($escola == 14) {
          $pdo->query("UPDATE frequencia_nucleo SET presenca = 'F' where id = '$id_chamada'");
        } else if ($escola == 15) {
          $pdo->query("UPDATE frequencia_horizonte SET presenca = 'F' where id = '$id_chamada'");
        } else {
          $pdo->query("UPDATE frequencia_jose SET presenca = 'F' where id = '$id_chamada'");
        }
      } else {

        if ($escola == 12) {
          if ($serie == 4) {
            $pdo->query("INSERT INTO frequencia_francisco_4 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
          } else if ($serie == 5) {
            $pdo->query("INSERT INTO frequencia_francisco_5 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
          } else if ($serie == 6) {
            $pdo->query("INSERT INTO frequencia_francisco_6 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
          } else if ($serie == 7) {
            $pdo->query("INSERT INTO frequencia_francisco_7 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
          } else if ($serie == 8) {
            $pdo->query("INSERT INTO frequencia_francisco_8 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
          } else if ($serie == 9) {
            $pdo->query("INSERT INTO frequencia_francisco_9 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
          }
        } else if ($escola == 13) {
          $pdo->query("INSERT INTO frequencia_creche SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
        } else if ($escola == 14) {
          $pdo->query("INSERT INTO frequencia_nucleo SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
        } else if ($escola == 15) {
          $pdo->query("INSERT INTO frequencia_horizonte SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
        } else {
          $pdo->query("INSERT INTO frequencia_jose SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'F', data = curDate(), professor = '$professor'");
        }
      }

}

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_aula=$id_aula_chamada';</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "justificado") {

  $id_turma_chamada = $_GET['id'];
  $id_aluno_chamada = $_GET['id_aluno'];
  $id_aula_chamada = $_GET['id_aula'];
  $query = $pdo->query("SELECT * FROM aulas where id = '$id_aula_chamada' ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  if(count($res) > 0){
    if ($escola == 12) {
        if ($serie == 4) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_4 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 5) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_5 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 6) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_6 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 7) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_7 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 8) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_8 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        } else if ($serie == 9) {
          $query = $pdo->query("SELECT * FROM frequencia_francisco_9 where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
        }
      } else if ($escola == 13) {
        $query = $pdo->query("SELECT * FROM frequencia_creche where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 14) {
        $query = $pdo->query("SELECT * FROM frequencia_nucleo where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else if ($escola == 15) {
        $query = $pdo->query("SELECT * FROM frequencia_horizonte where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
        $query = $pdo->query("SELECT * FROM frequencia_jose where turma = '$id_turma_chamada' and aluno = '$id_aluno_chamada' and aula = '$id_aula_chamada' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      if (@count($res) > 0) {
        $id_chamada = $res[0]['id'];
        if ($escola == 12) {
          if ($serie == 4) {
            $pdo->query("UPDATE frequencia_francisco_4 SET presenca = 'J' where id = '$id_chamada'");
          } else if ($serie == 5) {
            $pdo->query("UPDATE frequencia_francisco_5 SET presenca = 'J' where id = '$id_chamada'");
          } else if ($serie == 6) {
            $pdo->query("UPDATE frequencia_francisco_6 SET presenca = 'J' where id = '$id_chamada'");
          } else if ($serie == 7) {
            $pdo->query("UPDATE frequencia_francisco_7 SET presenca = 'J' where id = '$id_chamada'");
          } else if ($serie == 8) {
            $pdo->query("UPDATE frequencia_francisco_8 SET presenca = 'J' where id = '$id_chamada'");
          } else if ($serie == 9) {
            $pdo->query("UPDATE frequencia_francisco_9 SET presenca = 'J' where id = '$id_chamada'");
          }
        } else if ($escola == 13) {
          $pdo->query("UPDATE frequencia_creche SET presenca = 'J' where id = '$id_chamada'");
        } else if ($escola == 14) {
          $pdo->query("UPDATE frequencia_nucleo SET presenca = 'J' where id = '$id_chamada'");
        } else if ($escola == 15) {
          $pdo->query("UPDATE frequencia_horizonte SET presenca = 'J' where id = '$id_chamada'");
        } else {
          $pdo->query("UPDATE frequencia_jose SET presenca = 'J' where id = '$id_chamada'");
        }
      } else {

        if ($escola == 12) {
          if ($serie == 4) {
            $pdo->query("INSERT INTO frequencia_francisco_4 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
          } else if ($serie == 5) {
            $pdo->query("INSERT INTO frequencia_francisco_5 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
          } else if ($serie == 6) {
            $pdo->query("INSERT INTO frequencia_francisco_6 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
          } else if ($serie == 7) {
            $pdo->query("INSERT INTO frequencia_francisco_7 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
          } else if ($serie == 8) {
            $pdo->query("INSERT INTO frequencia_francisco_8 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
          } else if ($serie == 9) {
            $pdo->query("INSERT INTO frequencia_francisco_9 SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
          }
        } else if ($escola == 13) {
          $pdo->query("INSERT INTO frequencia_creche SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
        } else if ($escola == 14) {
          $pdo->query("INSERT INTO frequencia_nucleo SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
        } else if ($escola == 15) {
          $pdo->query("INSERT INTO frequencia_horizonte SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
        } else {
          $pdo->query("INSERT INTO frequencia_jose SET turma = '$id_turma_chamada', aluno =  '$id_aluno_chamada', aula = '$id_aula_chamada', presenca = 'J', data = curDate(), professor = '$professor'");
        }
      }

  }

  echo "<script>window.location='index.php?pag=$pag&funcao=fazerchamada&id=$id_turma_chamada&id_aula=$id_aula_chamada';</script>";
}

?>

<script>
  $(document).ready(function() {
    $('#minhaTabela').DataTable({
      "language": {
        "lengthMenu": "Mostrando _MENU_ registros por página",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "Nenhum registro disponível",
        "infoFiltered": "(filtrado de _MAX_ registros no total)"
      }, stateSave: true,

    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#dataTable2').DataTable({
      "language": {
        "lengthMenu": "Mostrando _MENU_ registros por página",
        "zeroRecords": "Nada encontrado",
        "info": " ",
        "infoEmpty": "Nenhum registro disponível",
        "infoFiltered": "(filtrado de _MAX_ registros no total)"
      }, stateSave: true,
      "paging": false

    });
  });
</script>

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5544089876216624" crossorigin="anonymous"></script>
