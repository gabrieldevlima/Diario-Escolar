<?php
$pag = "alunos2021";
require_once("../conexao.php");

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'secretario'){
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
                        <th>NOME COMPLETO</th>
                        <th>DATA DE NASCIMENTO</th>
                        <th>ID ALUNO</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = $pdo->query("SELECT * FROM alunos2021 order by id desc ");
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
                                <a target="_blank" href="../rel/boletim2021.php?id=<?php echo $id ?>" title="Gerar Boletim" class="text-dark"><?php echo $nome ?></a>

                            </td>
                            <td><?php echo $datanascF ?></td>
                            <td><?php echo $id ?></td>
                        </tr>
                    <?php } ?>


                </tbody>
            </table>
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
                $query = $pdo->query("SELECT * FROM matriculas2021 where aluno = '$_GET[id]' order by id desc ");
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


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
    echo "<script>$('#modal-endereco').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculas") {
    echo "<script>$('#modal-matriculas').modal('show');</script>";
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
