<?php
$pag = "turmas";
require_once("../conexao.php");

@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'auxadministrativo') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}

$usuario = $_SESSION['id_usuario'];

$query = $pdo->query("SELECT * FROM usuarios where id = '$usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf = $res[0]['cpf'];

$query_adm = $pdo->query("SELECT * FROM auxiliaradministrativo where cpf = '$cpf' ");
$res_adm = $query_adm->fetchAll(PDO::FETCH_ASSOC);
$escola = $res_adm[0]['escola'];

$query = $pdo->query("SELECT * FROM turmas where letraturma = 'Ún'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }
    $id = $res[$i]['id'];
    $res = $pdo->prepare("UPDATE turmas SET letraturma = 'UN' WHERE id = '$id'");
}


?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i style="margin-right: 5px" style="margin-top: 5px" class='fas fa-plus-circle fa-lg'></i>Nova Turma</a>
    <a type="button" class="btn-info btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>

</div>



<!-- DataTales Example -->
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

                    if ($escola == 0) {
                        $query = $pdo->query("SELECT * FROM turmas order by id desc ");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $query = $pdo->query("SELECT * FROM turmas where sala = '$escola' order by id desc ");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    }


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
                        $query_r = $pdo->query("SELECT * FROM professores where id =  '$professor'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_prof = $res_r[0]['nome'];

                    ?>


                        <tr>
                            <td>
                                <a style="text-decoration : none" target="_blank" href="../rel/rendimento.php?id=<?php echo $id ?>" title="Ver Rendimento da turma" class="text-dark"><?php echo $nome_disc ?></a>
                            </td>
                            <td><?php echo $nome_sala ?></td>
                            <td><?php echo $nome_prof ?></td>
                            <td><?php echo $serie ?></td>
                            <td><?php echo $letraturma ?></td>



                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit fa-lg'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt fa-lg'></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Mais Informações'><i class='fas fa-info-circle fa-lg'></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=matricula&id=<?php echo $id ?>" class='text-success mr-1' title='Matricular Aluno'><i class='fas fa-user-plus fa-lg'></i></a>
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
                    $turno2 = $res[0]['turno'];
                    $letraturma2 = $res[0]['letraturma'];
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
                                <label>*Componente Curricular</label>
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
                                <label>*Escola</label>
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
                                <label>*Professor</label>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Ano de Ensino</label>
                                <select name="serie" id="serie" class="form-control">
                                    <option selected value="<?php echo $serie2 ?>"><?php echo $serie2 ?></option>
                                    <option value="MATER. I">MATER. I</option>
                                    <option value="MATER. II">MATER. II</option>
                                    <option value="PRE I">PRE I</option>
                                    <option value="PRE II">PRE II</option>
                                    <option value="1º ANO">1º ANO</option>
                                    <option value="2º ANO">2º ANO</option>
                                    <option value="3º ANO">3º ANO</option>
                                    <option value="4º ANO">4º ANO</option>
                                    <option value="5º ANO">5º ANO</option>
                                    <option value="6º ANO">6º ANO</option>
                                    <option value="7º ANO">7º ANO</option>
                                    <option value="8º ANO">8º ANO</option>
                                    <option value="9º ANO">9º ANO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data Início</label>
                                <input value="<?php echo @$data_inicio2 ?>" type="date" class="form-control" id="data_inicio" name="data_inicio">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data Final</label>
                                <input value="<?php echo @$data_final2 ?>" type="date" class="form-control" id="data_final" name="data_final">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Turma</label>
                                <select name="letraturma" id="letraturma" class="form-control">
                                    <option selected value="<?php echo $letraturma2 ?>"><?php echo $letraturma2 ?></option>
                                    <option value="UN">ÚNICA</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Turno</label>
                                <select name="turno" id="turno" class="form-control">
                                    <option selected value="<?php echo $turno2 ?>"><?php echo $turno2 ?></option>
                                    <option value="manhã">MANHÃ</option>
                                    <option value="tarde">TARDE</option>
                                    <option value="noite">NOITE</option>
                                    <option value="integral">INTEGRAL</option>
                                </select>
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
                                <label>*Ano da Turma</label>
                                <select name="ano" id="ano" class="form-control">
                                    <option selected value="<?php echo $ano2 ?>"><?php echo $ano2 ?></option>
                                    <option value="2021">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <small>
                    <div id="mensagem">

                    </div>
                </small>

                <div class="modal-footer">

                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <button type="button" id="btn-fechar" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>

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
                <button type="button" class="btn" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
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
                    $query_r = $pdo->query("SELECT * FROM professores where id =  '$professor3'");
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







<div class="modal" id="modal-matricula" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Matricular Aluno <small><a style="text-decoration: none;" title="Ver Alunos Matriculados" href="index.php?pag=<?php echo $pag ?>&funcao=matriculados&id_turma=<?php echo $_GET['id'] ?>"><span class="ml-3">Ver Alunos</span></a></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Data de Nascimento</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    $query = $pdo->query("SELECT * FROM alunos order by id desc ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }

                                        $erro = 0;

                                        $id_aluno = $res[$i]['id'];
                                        $query_m = $pdo->query("SELECT * FROM matriculas where aluno = '$id_aluno' and turma = '$_GET[id]'");
                                        $res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);

                                        $query_t = $pdo->query("SELECT * FROM turmas where id = '$_GET[id]'");
                                        $res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);
                                        $sala4 = $res_t[0]['sala'];

                                        $query_ma = $pdo->query("SELECT * FROM matriculas where aluno = '$id_aluno'");
                                        $res_ma = $query_ma->fetchAll(PDO::FETCH_ASSOC);
                                        for ($j = 0; $j < count($res_ma); $j++) {
                                            foreach ($res[$j] as $key => $value) {
                                            }
                                            $turma = $res_ma[$j]['turma'];
                                            $query_turma = $pdo->query("SELECT * FROM turmas where id = '$turma'");
                                            $res_turma = $query_turma->fetchAll(PDO::FETCH_ASSOC);
                                            for ($c = 0; $c < count($res_turma); $c++) {
                                                foreach ($res_turma[$c] as $key => $value) {
                                                }
                                                $salamatricula = $res_turma[$c]['sala'];
                                                if ($sala4 != $salamatricula) {
                                                    $erro = 1;
                                                }
                                            }

                                        }

                                        if (@count($res_m) > 0 or $erro == 1) {
                                            continue;
                                        }

                                        $nome = $res[$i]['nome'];
                                        $datanasc = $res[$i]['datanasc'];

                                        $datanascF = implode('/', array_reverse(explode('-', $datanasc)));

                                    ?>


                                        <tr>
                                            <td><?php echo $id_aluno ?></td>
                                            <td><?php echo $nome ?></td>
                                            <td><?php echo $datanascF ?></td>


                                            <td style="text-align: center;">

                                                <a href="index.php?pag=<?php echo $pag ?>&funcao=confirmar&id_turma=<?php echo $_GET['id'] ?>&id_aluno=<?php echo $id_aluno ?>" class='text-info mr-1' title='Confirmar Matricula'><i class='fas fa-check fa-lg'></i></a>
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


<div class="modal" id="modal-matriculados" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><a target="_self" href="index.php?pag=<?php echo $pag ?>&funcao=matricula&id=<?php echo $_GET['id_turma'] ?>"><span class="fa fa-arrow-left text-secondary"></i>&nbsp;&nbsp;</span></a> Alunos Matriculados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $query = $pdo->query("SELECT * FROM matriculas where turma = '$_GET[id_turma]' order by id desc ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($res); $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $aluno = $res[$i]['aluno'];
                    $id_m = $res[$i]['id'];
                    $query_r = $pdo->query("SELECT * FROM alunos where id = '" . $aluno . "' ");
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


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matricula") {
    echo "<script>$('#modal-matricula').modal('show');</script>";
}


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "confirmar") {

    $id_turma = $_GET['id_turma'];
    $id_aluno = $_GET['id_aluno'];

    $res = $pdo->query("INSERT INTO matriculas SET turma = '$id_turma', aluno = '$id_aluno'");

    $query = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $sala = $res[0]['sala'];
    $serie = $res[0]['serie'];
    $letraturma = $res[0]['letraturma'];

    $query_t = $pdo->query("SELECT * FROM turmas where sala = '$sala' and serie = '$serie' and letraturma = '$letraturma'");
    $res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($res_t); $i++) {
        foreach ($res_t[$i] as $key => $value) {
        }
        @$id_t = $res_t[$i]['id'];

        $query_m = $pdo->query("SELECT * FROM matriculas where turma = '$id_t' and aluno = '$id_aluno'");
        $res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
        if(@count($res_m) <= 0){
            $res = $pdo->query("INSERT INTO matriculas SET turma = '$id_t', aluno = '$id_aluno'");
        }


    }

    echo "<script>window.location='index.php?pag=turmas&funcao=matricula&id=$id_turma';</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculados") {
    echo "<script>$('#modal-matriculados').modal('show');</script>";
}



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir_matricula") {

    $id_m = $_GET['id_m'];
    $id_turma = $_GET['id_turma'];


    $res = $pdo->query("DELETE from matriculas WHERE id = '$id_m'");

    $res = $pdo->query("DELETE from pgto_matriculas WHERE matricula = '$id_m'");

    echo "<script>window.location='index.php?pag=$pag&id_turma=$id_turma&id_aluno=$id_aluno&funcao=matriculados';</script>";
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





<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>
