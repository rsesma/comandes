<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Comandes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>
<?php
include 'func_aux.php';
$ok = true;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['username'])) {
    $uf = $_SESSION['username'];
    $conn = connect();
    $descrip = getdescrip($conn,$uf);
} else {
    $ok = false;
    header("Location: index.php");
}
?>

<?php if ($ok) { ?>
<div class="container">
    <div class="jumbotron">
        <h1>Comandes</h1>
        <h2>Unitat de Convivència: <?php echo $descrip; ?></h2>
    </div>
    <?php echo "<a class='btn btn-success btn-block' href='comanda_new.php' >Comanda Actual</a>" ?>
    <?php echo "<a class='btn btn-primary btn-block' href='userlist.php' >Històric Comandes</a>" ?>
    <?php echo "<a class='btn btn-secondary btn-block' href='dades_uc.php' >Dades UC</a>" ?>
    <a class="btn btn-link btn-block" href="logout.php">Sortir</a>
</div>

<?php $conn->close(); ?>

<?php } else {
    header("Location: index.php");
}?>

</body>
</html>
