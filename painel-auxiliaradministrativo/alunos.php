<?php
$pag = "alunos";
require_once("../conexao.php");

@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'auxadministrativo') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}



?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i style="margin-right: 5px" style="margin-top: 5px" class='fas fa-plus-circle fa-lg'></i>Novo Aluno</a>
    <a type="button" class="btn-info btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>

</div>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="minhaTabela" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NOME COMPLETO</th>
                        <th>DATA DE NASCIMENTO</th>
                        <th>ID ALUNO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = $pdo->query("SELECT * FROM alunos order by id desc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $nome = $res[$i]['nome'];
                        $datanasc = $res[$i]['datanasc'];
                        $id = $res[$i]['id'];

                        $datanascF = implode('/', array_reverse(explode('-', $datanasc)));


                    ?>


                        <tr>
                            <td>
                                <a target="_blank" href="../rel/boletim.php?id=<?php echo $id ?>" title="Gerar Boletim" class="text-dark"><?php echo $nome ?></a>

                            </td>
                            <td><?php echo $datanascF ?></td>
                            <td><?php echo $id ?></td>

                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit fa-lg'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt fa-lg'></i></a>
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

                    $query = $pdo->query("SELECT * FROM alunos where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['nome'];
                    $datanasc2 = $res[0]['datanasc'];
                } else {
                    $titulo = "Inserir Registro";
                    $datanasc2 = date('Y-m-d');
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>*Nome Completo</label>
                                <input value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Data de Nascimento</label>
                                <input value="<?php echo @$datanasc2 ?>" type="date" class="form-control" id="datanasc" name="datanasc">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">

                    <button type="button" id="btn-fechar" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
                <small>
                    <div id="mensagem">

                    </div>
                </small>

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

                <div align="center" id="mensagem_excluir" class="">

                </div>

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


<div class="modal" id="modal-matriculas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Matrículas do Aluno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php
                $query = $pdo->query("SELECT * FROM matriculas where aluno = '$_GET[id]' order by id desc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($res); $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $aluno = $res[$i]['aluno'];
                    $turma = $res[$i]['turma'];
                    $data = $res[$i]['data'];

                    $dataF = implode('/', array_reverse(explode('-', $data)));

                    $id_m = $res[$i]['id'];




                    $query_r = $pdo->query("SELECT * FROM turmas where id = '" . $turma . "' ");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                    $id_disciplina = $res_r[0]['disciplina'];


                    $query_r = $pdo->query("SELECT * FROM disciplinas where id = '" . $id_disciplina . "' ");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                    $nome_disc = $res_r[0]['nome'];

                ?>
                    <span><?php echo $nome_disc ?>

                        <a href="../rel/boletim.php?id_m=<?php echo $id_m ?>" target="_blank" title="Gerar Boletim">
                            <i class='fas fa-clipboard text-primary mr-1'></i>Boletim</a>

                        <a target="_blank" title="Gerar Relatório de Frequência" href="../rel/declaracao.php?id=<?php echo $id_m ?>"><span class="ml-2"><i class='far fa-sticky-note text-danger'></i></span></a>

                    </span>

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

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculas") {
    echo "<script>$('#modal-matriculas').modal('show');</script>";
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
