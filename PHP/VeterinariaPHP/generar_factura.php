<?php

session_start();

    if(!empty($_SESSION['idMascotaSel'])){$idMasc =$_SESSION['idMascotaSel'];}
    if(!empty($_SESSION['trataSel'])){$idTrata =  $_SESSION['trataSel'];}
    if(!empty($_SESSION['observacion'])){$observacion =  $_SESSION['observacion'];}

    
    function insertar_datos ($idMasc,$idTrata,$observacion){
        include 'conexion_bd.php';

        $hoy=strval(date("d.m.y H:s")); 
        
        /*
        $id_factura = null; 
        
        $query_factura="INSERT INTO factura (idFact,fechaFact) VALUES ('$id_factura','$hoy')";


        $res_valid=mysqli_query($conex,$query_factura) or die (mysqli_error($conex));

        $querySelect="SELECT idFact FROM factura WHERE fechaFact = '$hoy'";

        
        $res_factura2=mysqli_query($conex, $querySelect) or die (mysqli_error($conex));
        if (mysqli_num_rows($res_factura2)!=0){
                $reg=mysqli_fetch_array($res_factura2);
                $idFact=$reg['idFact'];
        }
        */
        
        $query_trata_masc="INSERT INTO trata_masc (idTratMasc, idMasc, idTrata, observacion, fecha) "
            . "VALUES (NULL,'$idMasc','$idTrata','$observacion', '$hoy')";
        
        $res_valid=mysqli_query($conex,$query_trata_masc) 
                        or die (mysqli_error($conex));
        $idFact = mysqli_insert_id($conex);
        imprimirFactura($idMasc,$idTrata,$observacion, $idFact, $hoy);
    }
    
    
    function imprimirFactura($idMasc,$idTrata,$observacion, $idFact, $hoy){
        $form=<<<FORMULARIO
    <form action="menuVeterinario.php" method="post">
            <h1> Impreso de factura[$idFact] / $hoy</h1>
            <h2> 
            <br>
            Id de mascota: $idMasc
            <br>
            Id de tratamiento: $idTrata
            <br>
            Observaciones del tratamiento:
            $observacion
            <br>
    <input type="submit" name="Submit" value="Volver al menú">

FORMULARIO;
        
        print $form;
    }
    

    insertar_datos($idMasc, $idTrata, $observacion);
?>
