<?php
function connect(){
    require_once 'dbconfig.php';

    $con = mysqli_connect($dbconfig['server'],$dbconfig['username'],$dbconfig['password'],$dbconfig['db']);
    if(!$con){
        die("Failed to connect to Database");
    }
    $con->query("SET NAMES 'utf8'");
    $con->query("SET CHARACTER SET utf8");
    $con->query("SET SESSION collation_connection = 'utf8_unicode_ci'");

    return $con;
}

function clear_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getdescrip($conn,$uf){
    $stmt = $conn -> prepare('SELECT descrip FROM uf WHERE uf = ?');
    $stmt->bind_param('i', $uf);
    $stmt->execute();
    $users = $stmt->get_result();
    $descrip = "";
    if ($users->num_rows > 0) {
        while($r = $users->fetch_assoc()) {
            $descrip = $r["descrip"];
        }
    }
    return $descrip;
}

function gettotal($conn,$uf,$fecha){
    $stmt = $conn -> prepare("SELECT Sum(total) AS total FROM comanda WHERE uf = ? AND fecha = ? GROUP BY fecha, uf");
    $stmt->bind_param('is', $uf, $fecha);
    $stmt->execute();
    $totals = $stmt->get_result();
    if ($totals->num_rows > 0) {
        while($r = $totals->fetch_assoc()) {
            $uctotal = ($r["total"]==NULL ? '' : number_format($r["total"], 2, ",", ".")."€");
        }
    }
    return $uctotal;
}

function isopen(){
    $day = date("N");
    $hour = date("H");

    $open = false;
    $next=getnext();
    $dini=2;
    $dend=5;
    $hini=10;
    $hend=17;
    if (($day >= $dini) && ($day <= $dend)) {
        $open = true;
        if ((($day == $dini) && ($hour < $hini)) ||
            (($day == $dend) && ($hour > $hend))) {
            $open = false;
        }
    }
    $open=false;
    return $open;
}

function getnext(){
    return date('Y-m-d',strtotime("next tuesday"));
}

?>