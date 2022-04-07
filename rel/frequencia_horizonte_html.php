<?php
require_once("../conexao.php");
@session_start();

$id = $_GET['id'];
$m = $_GET['mes'];

switch ($m) {
    case 1:
        $nome_mes = 'JANEIRO';
        break;
    case 2:
        $nome_mes = 'FEVEREIRO';
        break;
    case 3:
        $nome_mes = 'MARÇO';
        break;
    case 4:
        $nome_mes = 'ABRIL';
        break;
    case 5:
        $nome_mes = 'MAIO';
        break;
    case 6:
        $nome_mes = 'JUNHO';
        break;
    case 7:
        $nome_mes = 'JULHO';
        break;
    case 8:
        $nome_mes = 'AGOSTO';
        break;
    case 9:
        $nome_mes = 'SETEMBRO';
        break;
    case 10:
        $nome_mes = 'OUTUBRO';
        break;
    case 11:
        $nome_mes = 'NOVEMBRO';
        break;
    case 12:
        $nome_mes = 'DEZEMBRO';
        break;
}



setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = strtoupper(utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today'))));


//DADOS DA TURMA
$query_r = $pdo->query("SELECT * FROM turmas where id = '$id' ");
$res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);
$escola = $res_r[0]['sala'];
$componente = $res_r[0]['disciplina'];
$professor = $res_r[0]['professor'];
$anoensino = $res_r[0]['serie'];
$letraturma = $res_r[0]['letraturma'];
$turno = $res_r[0]['turno'];
$ano = $res_r[0]['ano'];

$query_p = $pdo->query("SELECT * FROM professores where id = '$professor'");
$res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);

$nome_prof = $res_p[0]['nome'];

$query_s = $pdo->query("SELECT * FROM salas where id = '$escola'");
$res_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

$nome_escola = $res_s[0]['sala'];

$query_c = $pdo->query("SELECT * FROM disciplinas where id = '$componente'");
$res_c = $query_c->fetchAll(PDO::FETCH_ASSOC);

$nome_componente = $res_c[0]['nome'];



//RECUPERAR O TOTAL DE MESES ENTRE DATAS


?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div id="tabela">

    <head>
        <title>Frequência</title>

        <style>
            @page {
                margin: 0px;
                margin-bottom: 30px;

            }


            footer {
                margin-top: 30px;
                width: 100%;
            }

            .cabecalho {
                background-color: #ffffff;
                padding: 10px;
                margin-bottom: 30px;
                width: 100%;
                height: 100px;
            }

            .titulo {
                display: inline-block;
                margin: 0;
                font-size: 16px;
                font-family: Arial, Helvetica, sans-serif;
                color: #6e6d6d;

            }

            .img {
                display: inline-block;
            }


            .subtitulo {
                margin: 5px;
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
            }

            .areaTotais {
                border: 0.5px solid #bcbcbc;
                padding: 15px;
                border-radius: 5px;
                margin-right: 25px;
                margin-left: 25px;
                position: absolute;
                right: 20;
            }

            .areaTotal {
                border: 0.5px solid #bcbcbc;
                padding: 15px;
                border-radius: 5px;
                margin-right: 25px;
                margin-left: 25px;
                background-color: #f9f9f9;
                margin-top: 2px;
            }

            .pgto {
                margin: 1px;
            }

            .fonte13 {
                font-size: 13px;
            }

            .esquerda {
                display: inline;
                width: 50%;
                float: left;
            }

            .direita {
                display: inline;
                width: 50%;
                float: right;
            }

            .table {
                font-family: Verdana, sans-serif;
                font-size: 12px;
                margin: 0px;
            }

            .texto-tabela {
                font-size: 12px;
            }


            .esquerda_float {

                margin-bottom: 10px;
                float: left;
                display: inline;
            }


            .titulos {
                margin-top: 10px;
                margin-left: 10px;
            }

            .image h2 {
                margin-top: -10px;
            }

            .margem-direita {
                margin-right: 80px;
            }

            hr {
                margin: 8px;
                padding: 1px;
            }

            th {
                text-align: center;
            }

            .container {
                padding-left: 20px;
                padding-right: 20px;
                padding-bottom: 30px;
            }
        </style>

    </head>

    <body>
        <?php


        ?>

        <div class="cabecalho">

            <di class="cabecalho">
                <a style="float: right;" href="https://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onclick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="//cdn.printfriendly.com/buttons/printfriendly-pdf-email-button-md.png" alt="Print Friendly and PDF" /></a>
                <div class="row titulos">
                    <div class="col-sm-10  esquerda_float">
                        <img style="float: left" src="../img/logo-novohorizonte.png" width="200px" class="rounded float-left" alt="Responsive image">
                        <img style="float: right" src=" ../img/logo2.png" width="200px" class="rounded float-right" alt="Responsive image">
                        <h2 class="titulo"><b><?php echo strtoupper($nome_sec) ?></b></h2>
                        <h6 class="subtitulo"><?php echo 'Escola Municipal: ' . $nome_escola ?></h6>
                        <h6 class="subtitulo"><?php echo 'Componente Curricular: ' . $nome_componente ?></h6>
                        <h6 class="subtitulo"><?php echo 'Curso: <b> Ensino Fundamental </b> &nbsp&nbsp&nbsp Ano de Ensino: <b>'  . $anoensino . '</b>&nbsp&nbsp&nbsp&nbsp Turma: <b>' . $letraturma . '</b>&nbsp&nbsp&nbsp Turno: <b>' . $turno . '</b>&nbsp&nbsp&nbsp Ano: <b>' . $ano . '</b>' ?></h6>
                        <h6 class="subtitulo"><?php echo 'PROFESSOR(A): ' . $nome_prof ?></h6>
                    </div>
                </div>
        </div>


</div>

<div class=" container">

    <hr>

    <p align="center"><b>ANOTAÇÃO DA FREQUÊNCIA DE AULAS DO MÊS DE <?php echo $nome_mes ?> </b></p>
    <br>


    <div align="center" class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ALUNO</th>
                            <?php

                            $query = $pdo->query("SELECT * FROM aulas where turma = '$id' order by data");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i = 0; $i < count($res); $i++) {
                                foreach ($res[$i] as $key => $value) {
                                }

                                $data = $res[$i]['data'];
                                $partes = explode("-", $data);
                                $ano = $partes[0];
                                $mes = $partes[1];
                                $dia = $partes[2];
                                $qtd_aulas = $i + 1;
                                if ($mes == $m) {
                                    echo '<th>' . $dia . '</th>';
                                }
                            } ?>


                        </tr>
                    </thead>

                    <tbody>



                        <?php

                        $query = $pdo->query("SELECT * FROM matriculas where turma = '$id' order by id desc ");
                        $res = $query->fetchAll(PDO::FETCH_ASSOC);

                        for ($i = 0; $i < count($res); $i++) {
                            foreach ($res[$i] as $key => $value) {
                            }

                            echo '<tr>';

                            $aluno = $res[$i]['aluno'];

                            $query_a = $pdo->query("SELECT * FROM alunos where id = '$aluno' ");
                            $res_a = $query_a->fetchAll(PDO::FETCH_ASSOC);
                            if (count($res_a) < 1) {
                                $pdo->query("DELETE FROM matriculas WHERE aluno = '$aluno'");
                                $pdo->query("DELETE FROM frequencia_horizonte WHERE aluno = '$aluno'");
                                $pdo->query("DELETE FROM notas WHERE aluno = '$aluno'");
                                continue;
                            }

                            $nome_aluno = $res_a[0]['nome'];

                            echo '<td>' . $nome_aluno . '</td>';

                            $query_t = $pdo->query("SELECT * FROM frequencia_horizonte where aluno = $aluno and turma = $id order by data");
                            $res_t = $query_t->fetchAll(PDO::FETCH_ASSOC);

                            for ($j = 0; $j < count($res_t); $j++) {
                                foreach ($res_t[$j] as $key => $value) {
                                }
                                $id_cha = $res_t[$j]['id'];
                                $aula = $res_t[$j]['aula'];
                                $query_aula = $pdo->query("SELECT * FROM aulas where id = $aula");
                                $res_aula = $query_aula->fetchAll(PDO::FETCH_ASSOC);
                                @$aula_id = $res_aula[0]['id'];
                                if ($aula != $aula_id) {
                                    $pdo->query("DELETE FROM frequencia_horizonte WHERE aula = '$aula'");
                                    continue;
                                }
                                $data_aula = $res_aula[0]['data'];
                                $pdo->query("UPDATE frequencia_horizonte SET data = '$data_aula' where id = '$id_cha'");
                                $presenca = $res_t[$j]['presenca'];
                                $partes = explode("-", $data_aula);
                                $mes = $partes[1];
                                if ($mes == $m) {
                                    echo '<td style="text-align: center;">' . $presenca . '</td>';
                                }
                            }
                            echo '</tr>';
                        }

                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<footer align="center">
    <img src="../img/assinatura.PNG" width="650rem">
</footer>
</div>

</body>

</html>

<script>
    var pfHeaderImgUrl = '';
    var pfHeaderTagline = '';
    var pfdisableClickToDel = 1;
    var pfHideImages = 0;
    var pfImageDisplayStyle = 'none';
    var pfDisablePDF = 0;
    var pfDisableEmail = 0;
    var pfDisablePrint = 0;
    var pfCustomCSS = 'href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"';
    var pfEncodeImages = 0;
    var pfShowHiddenContent = 0;
    var pfBtVersion = '2';
    (function() {
        var js, pf;
        pf = document.createElement('script');
        pf.type = 'text/javascript';
        pf.src = '//cdn.printfriendly.com/printfriendly.js';
        document.getElementsByTagName('head')[0].appendChild(pf)
    })();
</script>
