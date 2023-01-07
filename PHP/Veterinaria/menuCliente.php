<?php


session_start();

    $dniCliSel = $_SESSION['$dniCliSel'];
    $password = $_SESSION['$password'];
            
        print "<a href='registrar_mascota.php'>Registrar mascota</a><br>";
        
        print "<a href='.php'>Modificar su propio registro</a><br>";
        
        print "<a href='.php'>Eliminar su propio registro</a><br>";
        
        print "<a href='.php'>Generar recibo (cliente-producto)</a><br>";   
        //Angel:no creo q esto lo tenga q hacer el cliente , but...?
?>

