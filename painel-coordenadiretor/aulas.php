<?php
$pag = "aulas";
require_once("../conexao.php");

@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'coordenadiretor') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}

$usuario = $_SESSION['id_usuario'];

$query = $pdo->query("SELECT * FROM usuarios where id = '$usuario' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cpf = $res[0]['cpf'];

$query_adm = $pdo->query("SELECT * FROM coordenadiretor where cpf = '$cpf' ");
$res_adm = $query_adm->fetchAll(PDO::FETCH_ASSOC);
$escola = $res_adm[0]['escola'];


?>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>COMPONENTE CURRICULAR</th>
                        <th>ESCOLA</th>
                        <th>ANO/SÉRIE</th>
                        <th>TURMA</th>
                        <th>Nº DE AULAS</th>
                        <th>PENDENTE</th>
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
                        $serie = $res[$i]['serie'];
                        $letraturma = $res[$i]['letraturma'];
                        @$horario = $res[$i]['horario'];
                        $dia = $res[$i]['dia'];
                        $id = $res[$i]['id'];

                        $query_a = $pdo->query("SELECT * FROM aulas where turma =  '$id'");
                        $res_a = $query_a->fetchAll(PDO::FETCH_ASSOC);
                        $qtd_aulas = count($res_a);

                        $query_v = $pdo->query("SELECT * FROM validadas where turma =  '$id'");
                        $res_v = $query_v->fetchAll(PDO::FETCH_ASSOC);
                        $qtd_validadas = count($res_v);

                        $faltavalidar = $qtd_aulas - $qtd_validadas;
                        if ($faltavalidar < 0) {
                            $faltavalidar = 0;
                        }

                        //RECUPERAR NOME DISCIPLINA
                        $query_r = $pdo->query("SELECT * FROM disciplinas where id =  '$disciplina'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_disc = $res_r[0]['nome'];

                        //RECUPERAR NOME SALA
                        $query_r = $pdo->query("SELECT * FROM salas where id =  '$sala'");
                        $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
                        $nome_sala = $res_r[0]['sala'];

                        //RECUPERAR NOME PROFESSOR

                    ?>


                        <tr>
                            <td><?php echo $nome_disc ?></td>
                            <td><?php echo $nome_sala ?></td>
                            <td><?php echo $serie ?></td>
                            <td><?php echo $letraturma ?></td>
                            <td><?php echo $qtd_aulas ?></td>
                            <td><?php echo $faltavalidar ?></td>

                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Mais Informações'><i class='fas fa-info-circle fa-lg'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=validada&id=<?php echo $id ?>" class='text-success mr-1' title='Validar Aulas'><i class='fas fa-chalkboard-teacher fa-lg'></i></a>
                                <a href="index.php?pag=aulas&funcao=relfrequencia&id=<?php echo $id ?>"" class='text-secondary mr-1' title='Gerar Relatório de Frequência'><i class='fas fa-calendar-alt fa-lg'></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class=" modal" id="modal-frequencias" tabindex="-1" role="dialog">
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
                                        <label>Componente Curricular</label>
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
                                        <label>Ano de Ensino</label>
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
                        <h5 class="modal-title">Validar Aulas <small><a style="text-decoration: none;" title="Ver aulas Validadas" href="index.php?pag=<?php echo $pag ?>&funcao=validadas&id_turma=<?php echo $_GET['id'] ?>"><span class="ml-3"> Ver aulas validadas </span></a></small></h5>
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
                                                <th>Nº</th>
                                                <th>Conteúdo</th>
                                                <th>Data</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php

                                            $query = $pdo->query("SELECT * FROM aulas where turma = '$_GET[id]' order by data");
                                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                            for ($i = 0; $i < count($res); $i++) {
                                                foreach ($res[$i] as $key => $value) {
                                                }

                                                $nome = $res[$i]['nome'];
                                                $data = $res[$i]['data'];
                                                $id_aulas = $res[$i]['id'];


                                                $query_v = $pdo->query("SELECT * FROM validadas where aulas = '$id_aulas' ");
                                                $res_v = $query_v->fetchAll(PDO::FETCH_ASSOC);

                                                @$aula_v = $res_v[0]['aulas'];

                                                if (@$aula_v == $id_aulas) {
                                                    continue;
                                                }


                                                $dataF = implode('/', array_reverse(explode('-', $data)));


                                            ?>

                                                <tr>
                                                    <td><?php echo $i + 1 ?></td>
                                                    <td><?php echo $nome ?></td>
                                                    <td><?php echo $dataF ?></td>

                                                    <td style="text-align: center;">

                                                        <a href="index.php?pag=<?php echo $pag ?>&funcao=confirmar&id_turma=<?php echo $_GET['id'] ?>&id_aulas=<?php echo $id_aulas ?>" class='text-success mr-1' title='Validar Aula'><i class='fas fa-check fa-lg'></i></a>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title"><a target="_self" href="index.php?pag=<?php echo $pag ?>&funcao=validada&id=<?php echo $_GET['id_turma']?>"><span class="fa fa-arrow-left text-secondary"></i>&nbsp;&nbsp;</span></a></h5>
                        <h5 class="modal-title">Aulas Validadas <small><a style="text-decoration: none;" target="_blank" title="Imprimir Relatórios de Aulas" href="../rel/aulas.php?id=<?php echo $_GET['id_turma'] ?>"><span class="ml-3">Relatório</span></a></small></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $cont = 0;
                        $query = $pdo->query("SELECT * FROM aulas where turma = '$_GET[id_turma]' order by data");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);

                        for ($i = 0; $i < count($res); $i++) {
                            foreach ($res[$i] as $key => $value) {
                            }

                            $id_aula = $res[$i]['id'];
                            $tipo = $res[$i]['aula'];
                            $aula = $res[$i]['nome'];
                            $data = $res[$i]['data'];
                            $dataF = implode('/', array_reverse(explode('-', $data)));

                            $query_aul = $pdo->query("SELECT * FROM validadas where aulas = '" . $id_aula . "' ");
                            $res_aul = $query_aul->fetchAll(PDO::FETCH_ASSOC);

                            @$id_v = $res_aul[0]['id'];
                            @$valida = $res_aul[0]['aulas'];

                            if (@$valida == $id_aula) {
                            } else {
                                continue;
                            }
                            $cont = $cont + 1;
                            $partes = explode("-", $data);
                            $mes = $partes[1];

                            if (@$m != $mes) {
                                switch ($mes) {
                                    case 1:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;""> JANEIRO </p>';
                                        echo '<hr>';
                                        break;
                                    case 2:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> FEVEREIRO </p>';
                                        echo '<hr>';
                                        break;
                                    case 3:
                                        echo ' <p style="text-align: center; font-weight: bolder;"> MARÇO </p>';
                                        echo '<hr>';
                                        break;
                                    case 4:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> ABRIL </p>';
                                        echo '<hr>';
                                        break;
                                    case 5:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> MAIO </p>';
                                        echo '<hr>';
                                        break;
                                    case 6:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> JUNHO </p>';
                                        echo '<hr>';
                                        break;
                                    case 7:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> JULHO </p>';
                                        echo '<hr>';
                                        break;
                                    case 8:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> AGOSTO </p>';
                                        echo '<hr>';
                                        break;
                                    case 9:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> SETEMBRO </p>';
                                        echo '<hr>';
                                        break;
                                    case 10:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> OUTUBRO </p>';
                                        echo '<hr>';
                                        break;
                                    case 11:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> NOVEMBRO </p>';
                                        echo '<hr>';
                                        break;
                                    case 12:
                                        echo '<br>';
                                        echo ' <p style="text-align: center; font-weight: bolder;"> DEZEMBRO </p>';
                                        echo '<hr>';
                                        break;
                                }
                                $m = $mes;
                            }
                        ?>
                            <span><small><a style="margin-right: 5px" title="Excluir Aula Validada" href="index.php?pag=<?php echo $pag ?>&funcao=excluir_validada&id_v=<?php echo $id_v ?>&id_turma=<?php echo $_GET['id_turma'] ?>"><span class="ml-2"><i class='fas fa-times text-danger fa-lg'></i></span></a><?php echo 'Aula ' . $cont . ' - ' . $aula . ' - ' . $dataF ?></small></span>

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

        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "relfrequencia") {
            echo "<script>$('#modal-frequencias').modal('show');</script>";
        }


        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "confirmar") {

            $id_turma = $_GET['id_turma'];
            $id_aulas = $_GET['id_aulas'];

            $query_r = $pdo->query("SELECT * FROM validadas where turma = '$id_turma' and aulas = '$id_aulas' ");
            $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

            if (@count($res_r) == 0) {

                $query_a = $pdo->query("SELECT * FROM aulas where id = '$id_aulas' ");
                $res_a = $query_a->fetchAll(PDO::FETCH_ASSOC);
                $data = $res_r[0]['data'];

                $res = $pdo->query("INSERT INTO validadas SET turma = '$id_turma', aulas = '$id_aulas', data = '$data'");

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

            echo "<script>window.location='index.php?pag=aulas&funcao=validada&id=$id_turma';</script>";
        }

        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "validadas") {
            echo "<script>$('#modal-validadas').modal('show');</script>";
        }



        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir_validada") {

            $id_v = $_GET['id_v'];
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


        <script type="text/javascript">
            $(document).ready(function() {
                $('#dataTable').dataTable({
                    "ordering": false
                })

            });
        </script>
