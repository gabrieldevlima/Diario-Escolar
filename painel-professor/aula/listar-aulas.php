<?php
require_once("../../conexao.php");

$turma = @$_POST['turma'];

$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' order by data ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$m = 0;

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $nome = $res[$i]['nome'];
    $data = $res[$i]['data'];
    $id_aula = $res[$i]['id'];

    $partes = explode("-", $data);
    $mes = $partes[1];

    if($m != $mes){
        switch ($mes) {
            case 1:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> JANEIRO </a> <br>';
                echo'<hr>';
                break;
            case 2:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> FEVEREIRO </a> <br>';
                echo'<hr>';
                break;
            case 3:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> MARÇO </a> <br>';
                echo'<hr>';
                break;
            case 4:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> ABRIL </a> <br>';
                echo'<hr>';
                break;
            case 5:
                echo'<hr>';
                echo' <a style="font-weight: bolder ;"> MAIO </a> <br>';
                echo'<hr>';
                break;
            case 6:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> JUNHO </a> <br>';
                echo'<hr>';
                break;
            case 7:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> JULHO </a> <br>';
                echo'<hr>';
                break;
            case 8:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> AGOSTO </a> <br>';
                echo'<hr>';
                break;
            case 9:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> SETEMBRO </a> <br>';
                echo'<hr>';
                break;
            case 10:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> OUTUBRO </a> <br>';
                echo'<hr>';
                break;
            case 11:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> NOVEMBRO </a> <br>';
                echo'<hr>';
                break;
            case 12:
                echo'<hr>';
                echo' <a style="font-weight: bolder;"> DEZEMBRO </a> <br>';
                echo'<hr>';
                break;
        }
        $m = $mes;

    }

    $dataF = implode('/', array_reverse(explode('-', $data)));

    $query2 = $pdo->query("SELECT * FROM validadas where aulas = '$id_aula' ");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    if (@count($res2) > 0) {
        echo '<a onclick="deletarAula(' . $id_aula . ')" href="#" title="deletar aula"><i style="margin-right:5px" class="far fa-trash-alt fa-lg ml-2 text-danger"></i></a> <a onclick="upload(' . $id_aula . ')" href="#"><i  ml-2 text-primary"></i></a> <a style="color:green; font-weight: bolder;"> Aula ' . ($i + 1) . ' - ' . $nome . ' - ' . $dataF . '</a>';
        echo '<br><br>';
    } else {
        echo '<a onclick="deletarAula(' . $id_aula . ')" href="#" title="deletar aula"><i style="margin-right:5px" class="far fa-trash-alt fa-lg ml-2 text-danger"></i></a> <a onclick="upload(' . $id_aula . ')" href="#"><i  ml-2 text-primary"></i></a> Aula ' . ($i + 1) . ' - ' . $nome . ' - ' . $dataF;
        echo '<br><br>';
    }
}
