<?php

@session_start();
$pag = "aula";

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

<div class="modal" id="modal-aulas" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $nome_disc ?><small><a style="text-decoration : none" target="_blank" title="Relatórios de Aulas" href="../rel/aulas.php?id=<?php echo $id_turma ?>"><span class="ml-3">Relatório</span></a></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div align="center" id="mensagem-aulas" class="">
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">

                        <span class="mb-3"><b>Registrar Nova Aula</b></span>
                        <form id="form-aula" method="POST" class="mr-5">
                            <div class="form-group">
                                <label class="mb-2 mt-2">*Tipo de Aula</label>
                                <select name="aula" class="form-control">
                                    <option value=""></option>
                                    <option value="Aula Normal">Aula Normal</option>
                                    <option value="Aula Remota">Aula Remota</option>
                                    <option value="Reposição">Reposição</option>
                                    <option value="Aula Extra">Aula Extra</option>
                                    <option value="Substituição">Substituição</option>
                                    <option value="Aula Antecipada">Aula Antecipada</option>
                                    <option value="Atividade Extra Classe">Atividade Extra Classe</option>
                                    <option value="Recuperação">Recuperação</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>*Conteúdo</label>
                                <textarea class="form-control" id="nome" name="nome"></textarea>
                            </div>

                            <div class="form-group">
                                <label>*Data</label>
                                <input type="date" class="form-control" id="data" name="data">
                            </div>

                            <div align="right">
                                <button type="submit" name="btn-salvar-aula" id="btn-salvar-aula" class="btn btn-success">Registrar Aula</button>
                            </div>

                            <input type="hidden" name="turma" value="<?php echo $_GET['id'] ?>">

                        </form>
                    </div>

                    <div class="col-md-8">

                        <span class="ml-5"><b>Aulas Registradas</b></span>
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
                                                    <th>Status</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php
                                                $turma = $_GET['id'];
                                                $query = $pdo->query("SELECT * FROM aulas where turma = '$turma' order by data desc");
                                                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                                for ($i = 0; $i < count($res); $i++) {
                                                    foreach ($res[$i] as $key => $value) {
                                                    }
                                                    $cont = $i + 1;
                                                    $nome = $res[$i]['nome'];
                                                    $data = $res[$i]['data'];
                                                    $dataF = implode('/', array_reverse(explode('-', $data)));
                                                    $id_aula = $res[$i]['id'];

                                                    $query_v = $pdo->query("SELECT * FROM validadas where aulas = '$id_aula'");
                                                    $res_v = $query_v->fetchAll(PDO::FETCH_ASSOC);
                                                    echo '<tr>';
                                                    echo '<td style="text-align: center;">' . $cont . '</td>';
                                                    echo '<td style="text-align: center;">' . $nome . '</td>';
                                                    echo '<td style="text-align: center;">' . $dataF . '</td>';
                                                    if (@count($res_v) > 0) {
                                                        echo '<td style="text-align: center; color: Green;font-weight: bold;">' . 'Validada' . '</td>';
                                                    } else {
                                                        echo '<td style="text-align: center; color: Red;font-weight: bold;">' . 'Pendente' . '</td>';
                                                    }
                                                    echo '<td style="text-align: center;"><a href="index.php?pag=' . $pag . '&funcao=excluir&id=' . $id_aula . '" class="text-danger mr-1" title="Excluir Registro"><i class="far fa-trash-alt fa-lg"></i></a></td>';
                                                }   ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Excluir este Registro?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] . ' ' . $_GET['turma'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "aulas") {
    echo "<script>$('#modal-aulas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modal-deletar').modal('show');</script>";
}

?>

<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
    $(document).ready(function() {
        listarDadosAulas();
    })
</script>

<script type="text/javascript">
    function listarDadosAulas() {
        var pag = "<?= $pag ?>";
        var turma = "<?= $id_turma ?>";
        var periodo = "<?= $id_per ?>";
        console.log(periodo)
        $.ajax({
            url: pag + "/listar-aulas.php",
            method: "post",
            data: {
                turma,
                periodo
            },
            dataType: "html",
            success: function(result) {
                $('#listar-aulas').html(result)

            },


        })
    }
</script>

<script>
    $(document).ready(function() {
        $('#minhaTabela').DataTable({
            "language": {
                "lengthMenu": " _MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)"
            }
        });
    });
</script>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form-aula").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir-aula.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem-aulas').removeClass()

                if (mensagem.trim() === "Salvo com Sucesso!") {

                    $('#nome').val('');
                    $('#data').val('');
                    listarDadosAulas();

                } else {

                    $('#mensagem-aulas').addClass('text-danger')
                }

                $('#mensagem-aulas').text(mensagem)
                location.reload();

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
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        var turma = "<?= $turma ?>";

        $('#btn-deletar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/excluir-aula.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem) {

                    if (mensagem.trim() === 'Excluído com Sucesso!') {


                        $('#btn-cancelar-excluir').click();
                        window.history.back()
                    }

                    $('#mensagem_excluir').text(mensagem)



                },

            })
        })
    })
</script>
