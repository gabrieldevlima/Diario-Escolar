<?php
$pag = "aulas";
require_once("../conexao.php");

@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'auxadministrativo') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}



?>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="minhaTabela" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Componente Curricular</th>
                        <th>Escola</th>
                        <th>Professor</th>
                        <th>Ano de Ensino</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = $pdo->query("SELECT * FROM turmas order by id desc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $disciplina = $res[$i]['disciplina'];
                        $sala = $res[$i]['sala'];
                        $professor = $res[$i]['professor'];
                        $serie = $res[$i]['serie'];
                        $horario = $res[$i]['horario'];
                        $dia = $res[$i]['dia'];
                        $id = $res[$i]['id'];

                        //RECUPERAR NOME DISCIPLINA
                        $query_r = $pdo->query("SELECT * FROM disciplinas where id =  '$disciplina'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_disc = $res_r[0]['nome'];

                        //RECUPERAR NOME SALA
                        $query_r = $pdo->query("SELECT * FROM salas where id =  '$sala'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_sala = $res_r[0]['sala'];

                        //RECUPERAR NOME PROFESSOR
                        $query_r = $pdo->query("SELECT * FROM professores where id =  '$professor'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_prof = $res_r[0]['nome'];

                    ?>


                        <tr>
                            <td><?php echo $nome_disc ?></td>
                            <td><?php echo $nome_sala ?></td>
                            <td><?php echo $nome_prof ?></td>
                            <td><?php echo $serie ?></td>



                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit fa-lg'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt fa-lg'></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Mais Informações'><i class='fas fa-info-circle fa-lg'></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=validada&id=<?php echo $id ?>" class='text-success mr-1' title='Validar Aulas'><i class='fas fa-chalkboard-teacher fa-lg'></i></a>
                            </td>
                        </tr>
                    <?php } ?>





                </tbody>
            </table>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM turmas where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $disciplina2 = $res[0]['disciplina'];
                    $sala2 = $res[0]['sala'];
                    $serie2 = $res[0]['serie'];
                    $professor2 = $res[0]['professor'];
                    $horario2 = $res[0]['horario'];
                    $dia2 = $res[0]['dia'];
                    $data_inicio2 = $res[0]['data_inicio'];
                    $data_final2 = $res[0]['data_final'];
                    $ano2 = $res[0]['ano'];
                } else {
                    $titulo = "Inserir Registro";
                }

                ?>

                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Disciplina</label>
                                <select name="disciplina" class="form-control" id="disciplina">

                                    <?php

                                    $query = $pdo->query("SELECT * FROM disciplinas order by nome asc ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_reg = $res[$i]['nome'];
                                        $id_reg = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$disciplina2 == $id_reg) { ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                                    <?php } ?>

                                </select>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Escola</label>
                                <select name="sala" class="form-control" id="sala">

                                    <?php

                                    $query = $pdo->query("SELECT * FROM salas order by sala asc ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_reg = $res[$i]['sala'];
                                        $id_reg = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$sala2 == $id_reg) { ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Professor</label>
                                <select name="professor" class="form-control" id="professor">

                                    <?php

                                    $query = $pdo->query("SELECT * FROM professores order by nome asc ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_reg = $res[$i]['nome'];
                                        $id_reg = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$professor2 == $id_reg) { ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Série</label>
                                <input value="<?php echo @$serie2 ?>" type="text" class="form-control" id="serie" name="serie" placeholder="6º Série">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data Início</label>
                                <input value="<?php echo @$data_inicio2 ?>" type="date" class="form-control" id="data_inicio" name="data_inicio">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Data Final</label>
                                <input value="<?php echo @$data_final2 ?>" type="date" class="form-control" id="data_final" name="data_final">
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Horário Aulas</label>
                                <input value="<?php echo @$horario2 ?>" type="text" class="form-control" id="horario" name="horario" placeholder="De xx:xx às xx:xx">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dias das Aulas</label>
                                <input value="<?php echo @$dia2 ?>" type="text" class="form-control" id="dia" name="dia" placeholder="Segunda à Sexta">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ano Início</label>
                                <input value="<?php echo @$ano2 ?>" type="number" class="form-control" id="ano" name="ano" placeholder="Ano da Turma">
                            </div>
                        </div>
                    </div>










                    <small>
                        <div id="mensagem">

                        </div>
                    </small>

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$validada2 ?>" type="hidden" name="antigo" id="antigo">

                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
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

                <small>
                    <div align="center" id="mensagem_excluir" class="">

                    </div>
                </small>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id" name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>






<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados da Turma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM turmas where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina3 = $res[0]['disciplina'];
                    $sala3 = $res[0]['sala'];
                    $serie3 = $res[0]['serie'];
                    $professor3 = $res[0]['professor'];
                    $horario3 = $res[0]['horario'];
                    $dia3 = $res[0]['dia'];
                    $data_inicio3 = $res[0]['data_inicio'];
                    $data_final3 = $res[0]['data_final'];
                    $ano3 = $res[0]['ano'];


                    //RECUPERAR NOME DISCIPLINA
                    $query_r = $pdo->query("SELECT * FROM disciplinas where id =  '$disciplina3'");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                    $nome_disc3 = $res_r[0]['nome'];

                    //RECUPERAR NOME SALA
                    $query_r = $pdo->query("SELECT * FROM salas where id =  '$sala3'");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                    $nome_sala3 = $res_r[0]['sala'];

                    //RECUPERAR NOME PROFESSOR
                    $query_r = $pdo->query("SELECT * FROM professores where id =  '$professor3'");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                    $nome_prof3 = $res_r[0]['nome'];

                    $data_inicioF = implode('/', array_reverse(explode('-', $data_inicio3)));
                    $data_finalF = implode('/', array_reverse(explode('-', $data_final3)));
                }


                ?>

                <span><b>Disciplina: </b> <i><?php echo $nome_disc3 ?></i><br></span>

                <span><b>Sala: </b> <i><?php echo $nome_sala3 ?></i> </span><span class="ml-4"><b>Professor: </b> <i><?php echo $nome_prof3 ?></i><br></span>

                <span><b>Data Início: </b> <i><?php echo $data_inicioF ?></i> </span><span class="ml-4"><b>Data Final: </b> <i><?php echo $data_finalF ?></i><br></span>

                <span><b>Horário: </b> <i><?php echo $horario3 ?></i> </span><span class="ml-4"><b>Dias: </b> <i><?php echo $dia3 ?></i><br></span>

                </span><span><b>Ano: </b> <i><?php echo $ano3 ?></i><br></span>

            </div>

        </div>
    </div>
</div>







<div class="modal" id="modal-validada" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validar Aulas <small><a class="text-dark" title="Ver aulas Validadas" href="index.php?pag=<?php echo $pag ?>&funcao=validadas&id_turma=<?php echo $_GET['id'] ?>"><u> Ver aulas </u></a></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="minhaTabela2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Conteúdo</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    $query = $pdo->query("SELECT * FROM aulas order by id desc ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }

                                        $nome = $res[$i]['nome'];
                                        $data = $res[$i]['data'];
                                        $id_aulas = $res[$i]['id'];

                                        $dataF = implode('/', array_reverse(explode('-', $data)));


                                    ?>


                                        <tr>
                                            <td><?php echo $nome ?></td>
                                            <td><?php echo $dataF ?></td>

                                            <td>

                                                <a style="position: absolute; padding-left: 40px" href="index.php?pag=<?php echo $pag ?>&funcao=confirmar&id_turma=<?php echo $_GET['id'] ?>&id_aulas=<?php echo $id_aulas ?>" class='text-success mr-1' title='Validar Aula'><i class='fas fa-check fa-2x'></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>
</div>


<div class="modal" id="modal-validadas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aulas Validadas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $query = $pdo->query("SELECT * FROM validadas where turma = '$_GET[id_turma]' order by id desc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($res); $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $aulas = $res[$i]['aulas'];
                    $id_v = $res[$i]['id'];
                    $query_r = $pdo->query("SELECT * FROM aulas where id = '" . $aulas . "' ");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                    $nome_aulas = $res_r[0]['nome'];

                ?>
                    <span><small><?php echo $nome_aulas ?><a title="Excluir Aula Validada" href="index.php?pag=<?php echo $pag ?>&funcao=excluir_validada&id_m=<?php echo $id_m ?>&id_turma=<?php echo $_GET['id_turma'] ?>"><span class="ml-2"><i class='fas fa-times text-danger'></i></span></a></small></span>

                    <hr style="margin:4px">

                <?php } ?>



            </div>

        </div>
    </div>
</div>







<?php

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modal-deletar').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
    echo "<script>$('#modal-endereco').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "validada") {
    echo "<script>$('#modal-validada').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "confirmar") {

    $id_turma = $_GET['id_turma'];
    $id_aulas = $_GET['id_aulas'];

    $query_r = $pdo->query("SELECT * FROM validadas where turma = '$id_turma' and aulas = '$id_aulas' ");
    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

    if (@count($res_r) == 0) {
        $res = $pdo->query("INSERT INTO validadas SET turma = '$id_turma', aulas = '$id_aulas', data = curDate()");

        $id_validada = $pdo->lastInsertId();

        //GERAR AS PARCELAS DE PAGAMENTO validada
        $query_r = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
        $data_ini = $res_r[0]['data_inicio'];
        $data_fin = $res_r[0]['data_final'];

        //RECUPERAR O TOTAL DE MESES ENTRE DATAS
        $d1 = new DateTime($data_ini);
        $d2 = new DateTime($data_fin);
        $intervalo = $d1->diff($d2);
        $anos = $intervalo->y;
        $meses = $intervalo->m + ($anos * 12);

        for ($i = 0; $i < $meses; $i++) {

            //INCREMENTAR 1 MES NA DATA INICIAL
            $data_nova = date('Y/m/d', strtotime("+$i month", strtotime($data_ini)));
        }
    }

    echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma&id_aulas=$id_aulas&funcao=validadas';</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "validadas") {
    echo "<script>$('#modal-validadas').modal('show');</script>";
}



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir_validada") {

    $id_m = $_GET['id_v'];
    $id_turma = $_GET['id_turma'];


    $res = $pdo->query("DELETE from validadas WHERE id = '$id_v'");

    echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma&id_aulas=$id_aulas&funcao=validadas';</script>";
}


?>




<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag=" + pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

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





<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        $('#btn-deletar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/excluir.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem) {

                    if (mensagem.trim() === 'Excluído com Sucesso!') {


                        $('#btn-cancelar-excluir').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem_excluir').addClass('text-danger')
                    $('#mensagem_excluir').text(mensagem)



                },

            })
        })
    })
</script>



<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
    function carregarImg() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5544089876216624" crossorigin="anonymous"></script>

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
    $('#minhaTabela2').DataTable({
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
