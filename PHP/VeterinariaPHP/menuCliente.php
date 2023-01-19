

<?php

    session_start();

    $dniCliSel = $_SESSION['$dniCliSel'];
    $nombreCli =  $_SESSION['nombreCli'];

    print "<h2> Menu Cliente: $nombreCli ($dniCliSel) </h2>";

    print "<a href='registrar_mascota_cli.php'>Registrar mascota </a><br>";

    print "<a href='modificar_propio_cli.php'>Modificar su cuenta</a><br>";       

    print "<a href='eliminar_propio_cliente.php'>Eliminar su cuenta</a><br>"; 

    print "<a href='catalogo.php'>Comprar objetos del catalogo</a><br>";                  //FALTA

 
?>

