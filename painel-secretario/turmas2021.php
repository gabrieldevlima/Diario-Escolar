<?php
$pag = "turmas2021";
require_once("../conexao.php");

@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'secretario') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}


?>

<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>COMPONENTE CURRICULAR</th>
                        <th>ESCOLA</th>
                        <th>PROFESSOR</th>
                        <th>ANO/SÉRIE</th>
                        <th>TURMA</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                        $query = $pdo->query("SELECT * FROM turmas2021 order by id desc ");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);


                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $disciplina = $res[$i]['disciplina'];
                        $sala = $res[$i]['sala'];
                        $professor = $res[$i]['professor'];
                        $serie = $res[$i]['serie'];
                        $turno = $res[$i]['turno'];
                        $letraturma = $res[$i]['letraturma'];
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
                        $query_r = $pdo->query("SELECT * FROM professores2021 where id =  '$professor'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_prof = $res_r[0]['nome'];

                    ?>


                        <tr>
                            <td>
                                <a style="text-decoration : none" target="_blank" href="../rel/rendimento2021.php?id=<?php echo $id ?>" title="Ver Rendimento da turma" class="text-dark"><?php echo $nome_disc ?></a>
                            </td>
                            <td><?php echo $nome_sala ?></td>
                            <td><?php echo $nome_prof ?></td>
                            <td><?php echo $serie ?></td>
                            <td><?php echo $letraturma ?></td>



                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Mais Informações'><i class='fas fa-info-circle fa-lg'></i></a>

                                <a class="text-dark" title="Ver Alunos Matriculados" href="index.php?pag=<?php echo $pag ?>&funcao=matriculados&id_turma=<?php echo $id ?>"><i class='fas fa-user-graduate fa-lg'></i></a>
                            </td>
                        </tr>
                    <?php } ?>





                </tbody>
            </table>
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

                    $query = $pdo->query("SELECT * FROM turmas2021 where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina3 = $res[0]['disciplina'];
                    $sala3 = $res[0]['sala'];
                    $serie3 = $res[0]['serie'];
                    $professor3 = $res[0]['professor'];
                    $turno3 = $res[0]['turno'];
                    $letraturma3 = $res[0]['letraturma'];
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
                    $query_r = $pdo->query("SELECT * FROM professores2021 where id =  '$professor3'");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                    $nome_prof3 = $res_r[0]['nome'];

                    $data_inicioF = implode('/', array_reverse(explode('-', $data_inicio3)));
                    $data_finalF = implode('/', array_reverse(explode('-', $data_final3)));
                }


                ?>

                <span><b>Componente Curricular: </b> <i><?php echo $nome_disc3 ?></i></span><span class="ml-4"><b>Turma: </b> <i><?php echo $letraturma3 ?></i><br></span>

                <span><b>Escola: </b> <i><?php echo $nome_sala3 ?></i> </span><span class="ml-2"><b>Professor: </b> <i><?php echo $nome_prof3 ?></i><br></span>

                <span><b>Data Início: </b> <i><?php echo $data_inicioF ?></i> </span><span class="ml-4"><b>Data Final: </b> <i><?php echo $data_finalF ?></i><br></span>

                <span><b>Turno: </b> <i><?php echo $turno3 ?></i> </span><span class="ml-4"><b>Dias: </b> <i><?php echo $dia3 ?></i></span></span><span class="ml-4"><b>Ano: </b> <i><?php echo $ano3 ?></i><br></span>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="modal-matriculados" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alunos Matriculados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $query = $pdo->query("SELECT * FROM matriculas2021 where turma = '$_GET[id_turma]' order by id desc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($res); $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $aluno = $res[$i]['aluno'];
                    $id_m = $res[$i]['id'];
                    $query_r = $pdo->query("SELECT * FROM alunos2021 where id = '" . $aluno . "' ");
                    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

                    $nome_aluno = $res_r[0]['nome'];

                ?>
                    <span><small><a style="margin-right: 5px" title="Excluir Matrícula" href="index.php?pag=<?php echo $pag ?>&funcao=excluir_matricula&id_m=<?php echo $id_m ?>&id_turma=<?php echo $_GET['id_turma'] ?>"><span class="ml-2"><i class='fas fa-times text-danger fa-lg'></i></span></a><?php echo $nome_aluno ?></small></span>

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


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculados") {
    echo "<script>$('#modal-matriculados').modal('show');</script>";
}

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>
