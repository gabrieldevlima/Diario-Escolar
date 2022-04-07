<?php
$pag = "aulas";
require_once("../conexao.php");

@session_start();
//verificar se o usuário está autenticado
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'secretario') {
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
                        <th>COMPONENTE CURRICULAR</th>
                        <th>ESCOLA</th>
                        <th>ANO/SÉRIE</th>
                        <th>TURMA</th>
                        <th>TOTAL AULA</th>
                        <th>PENDENTE</th>
                        <th>AÇÕES</th>
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
                        $serie = $res[$i]['serie'];
                        $letraturma = $res[$i]['letraturma'];
                        $horario = $res[$i]['horario'];
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
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=validada&id=<?php echo $id ?>" class='text-success mr-1' title='Ver Aulas'><i class='fas fa-chalkboard-teacher fa-lg'></i></a>
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
                        <h5 class="modal-title">Validar Aulas <small><a style="text-decoration: none;" title="Ver aulas Validadas" href="index.php?pag=<?php echo $pag ?>&funcao=validadas&id_turma=<?php echo $_GET['id'] ?>"><span> Ver aulas validadas </span></a></small></h5>
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
                                                <th>Nº</th>
                                                <th>Conteúdo</th>
                                                <th>Data</th>
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

                                                $dataF = implode('/', array_reverse(explode('-', $data)));


                                            ?>

                                                <tr>
                                                    <td><?php echo $i + 1 ?></td>
                                                    <td><?php echo $nome ?></td>
                                                    <td><?php echo $dataF ?></td>
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
                        <h5 class="modal-title"><a target="_self" href="index.php?pag=<?php echo $pag ?>&funcao=validada&id=<?php echo $_GET['id_turma'] ?>"><span class="fa fa-arrow-left text-secondary"></i>&nbsp;&nbsp;</span></a></h5>
                        <h5 class="modal-title">Aulas Validadas <small><a style="text-decoration: none;" target="_blank" title="Imprimir Relatórios de Aulas" href="../rel/aulas.php?id=<?php echo $_GET['id_turma'] ?>"><span class="ml-3">Ver Relatório</span></a></small></h5>
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


        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
            echo "<script>$('#modal-endereco').modal('show');</script>";
        }


        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "validada") {
            echo "<script>$('#modal-validada').modal('show');</script>";
        }

        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "relfrequencia") {
            echo "<script>$('#modal-frequencias').modal('show');</script>";
        }


        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "validadas") {
            echo "<script>$('#modal-validadas').modal('show');</script>";
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
