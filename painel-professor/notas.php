<?php

@session_start();
$pag = "nota";

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
    <a class="text-dark" href="index.php?pag=aula&funcao=aulas&id=<?php echo $id_turma ?>&aulas=sim" title="Lançar Aulas">
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
    <a class="text-dark" href="index.php?pag=frequencia&funcao=chamada&id=<?php echo $id_turma ?>&chamada=sim" title="Registrar Frequência">
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
    <a class="text-dark" href="index.php?pag=nota&funcao=notas&id=<?php echo $id_turma ?>&notas=sim" title="Registrar Nota">
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

<div class="modal" id="modal-notas" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lançar Notas / Conceito <small><a style="text-decoration : none" target="_blank" title="Ver Resultados da turma" href="../rel/rendimento.php?id=<?php echo $id_turma ?>"><span class="ml-3">Relatório</span></a></small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form2" method="POST">
        <div class="modal-body">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Data de Nascimento</th>
                      <th>Notas</th>
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

                      $query_r = $pdo->query("SELECT * FROM alunos where id = '$aluno' ");
                      $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                      $nome = $res_r[0]['nome'];
                      $id_aluno = $res_r[0]['id'];
                      $datanasc = $res_r[0]['datanasc'];

                      $datanascF = implode('/', array_reverse(explode('-', $datanasc)));
                    ?>

                      <tr>
                        <td>
                          <?php echo $nome ?>
                        </td>

                        <td><?php echo $datanascF ?></td>
                        <td style="text-align: center;">
                          <a onclick="lancarNotas(<?php echo $id_aluno ?>, '<?php echo $nome ?>', <?php echo $id_aluno ?>)" href="" class='text-info mr-1' title='Lançar Notas'><i class='fas fa-id-card fa-lg'></i></a>
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

<div class="modal" id="modal-lancar-notas" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc . ' - ' ?> <span id="txtnomealuno"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-6">

            <span class="mb-2"></span>


            <form id="form-notas" method="POST" class="mr-5">
              <?php
              if ($nome_disc == 'E. INFANTIL') {
                echo '<div class="form-group">
                <label style="margin-top:10px"><b>Inserir Conceito</b></label>
                <input type="text" class="form-control" id="nota" name="nota">
                <input type="hidden" name="tipo" value="E. INFANTIL">
              </div>';
              } else {
                echo '<div class="form-group">

                <label><b>Tipo de Nota</b></label>
                <select name="tipo" class="form-control">
                  <option value="Avaliativa Mensal">Avaliativa Mensal</option>
                  <option value="Recuperação">Recuperação</option>
                  <option value="Prova Final">Prova Final</option>

                </select>
                <label style="margin-top:10px"><b>Inserir Nota ou Conceito</b></label>
                <input type="text" class="form-control" id="nota" name="nota">
              </div>';
              }
              ?>

              <div align="right">
                <button type="submit" name="btn-salvar-nota" id="btn-salvar-nota" class="btn btn-success mb-4">Registrar Nota</button>
              </div>

              <input type="hidden" name="turma" value="<?php echo $_GET['id'] ?>">
              <input type="hidden" name="periodo" value="<?php echo $_GET['id_periodo'] ?>">
              <input type="hidden" id="txtidaluno" name="aluno">

            </form>
          </div>
          <div class="col-md-5">

            <span class="ml-4"><b>Notas ou Conceito do Aluno </b></span>
            <small>
              <div id="listar-notas" class="ml-5 mt-2">

              </div>
            </small>

          </div>
        </div>
        <small>
          <div align="center" id="mensagem-notas" class=""></div>
        </small>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-editar-notas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <?php
        $titulo = "Editar Nota";
        $idnota2 = $_GET['id'];

        $query = $pdo->query("SELECT * FROM notas where id = '" . $idnota2 . "' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nota2 = $res[0]['nota'];

        ?>

        <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-notas" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>*Inserir nova nota</label>
                <input value="<?php echo @$nota2 ?>" type="text" class="form-control" id="nota2" name="nota2">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">

          <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">

          <div align="right">
            <button type="submit" name="btn-salvar-nota" id="btn-salvar-nota" class="btn btn-primary mb-4">Salvar</button>
          </div>
        </div>
        <small>
          <div id="mensagem">

          </div>
        </small>
    </div>
    </form>
  </div>
</div>

<?php

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "notas") {
  echo "<script>$('#modal-notas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editarnota") {
  echo "<script>$('#modal-editar-notas').modal('show');</script>";
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
      }
    });
  });
</script>

<script type="text/javascript">
  function listarDadosNotas(aluno) {
    var pag = "<?= $pag ?>";
    var turma = "<?= $id_turma ?>";
    var periodo = "<?= $id_per ?>";

    $.ajax({
      url: pag + "/listar-notas.php",
      method: "post",
      data: {
        turma,
        periodo,
        aluno
      },
      dataType: "html",
      success: function(result) {
        $('#listar-notas').html(result)

      },

    })
  }
</script>

<script type="text/javascript">
  function lancarNotas(idaluno, nomealuno) {
    event.preventDefault();

    var pag = "<?= $pag ?>";
    document.getElementById('txtidaluno').value = idaluno;

    $("#txtnomealuno").text(nomealuno);

    listarDadosNotas(idaluno);

    $('#modal-lancar-notas').modal('show');
  }
</script>


<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-notas").submit(function() {
    var pag = "<?= $pag ?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir-nota.php",
      type: 'POST',
      data: formData,

      success: function(mensagem) {

        $('#mensagem-notas').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#nota').val('');
          listarDadosNotas(document.getElementById('txtidaluno').value);

        } else {

          $('#mensagem-notas').addClass('text-danger')
        }

        $('#mensagem-notas').text(mensagem)

      },

      cache: false,
      contentType: false,
      processData: false,
      xhr: function() { // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
          myXhr.upload.addEventListener('progress', function() {
            /* faz alguma coisa durante o progresso do upload */
          }, false);
        }
        return myXhr;
      }
    });
  });
</script>

<script type="text/javascript">
  function deletarNota(idnota) {
    event.preventDefault();
    var pag = "<?= $pag ?>";

    $.ajax({
      url: pag + "/excluir-nota.php",
      method: "post",
      data: {
        idnota
      },
      dataType: "text",
      success: function(mensagem) {

        if (mensagem.trim() === 'Excluído com Sucesso!') {

          listarDadosNotas(document.getElementById('txtidaluno').value);
        }

      },

    })
  }
</script>
