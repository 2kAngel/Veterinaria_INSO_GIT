<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

   
    function mandarDatos ($dniCli, $dniVet, $tipoAnimal, $sexo){
        include 'conexion_bd.php';

        $id_mascota = null;
        
        $queryInsert="INSERT INTO mascota (idMasc, dniCli, dniVet, tipoAnimal, sexo)
                    VALUES ('$id_mascota', '$dniCli', '$dniVet', '$tipoAnimal', '$sexo');";
                
        
        if(!mysqli_query($conex, $queryInsert)){

            return false;
        }
        return true;
        
    }
    
    function drawForm( $dniCliSel, $dniVetSel, $tipoAnimal, $sexo, $error){
                   
         print  "<form action='registrar_mascota.php' method='post'>";
        include 'conexion_bd.php';
        
        $query_conv = "SELECT dniCli FROM cliente "; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Clientes: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='clientes'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $dniCli = $reg_con['dniCli'];

                if ($dniCli == $dniCliSel)  
                    print ("<option value='$dniCli' selected> $dniCli");
                else
                    print ("<option value='$dniCli'> $dniCli"); 
            }
            
            print("</select>");
        }   
            
        $query_conv = "SELECT dniVet, nombreVet FROM veterinario "; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Veterinarios: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='veterinarios'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $dniVet = $reg_con['dniVet'];
                $nombreVet = $reg_con['nombreVet'];

                if ($dniVet == $dniCliSel)  
                    print ("<option value='$dniVet' selected> $nombreVet");
                else
                    print ("<option value='$dniVet'> $nombreVet"); 
            }

            print("</select>");

        }else           
        {
            print ("<p>No hay ningun veterinario</p>");
        }
        
        print "<p> <input type='radio' name = 'sexo' value='H'";
        if ($sexo == 'H') 
            print "checked> Hembra </p>";
        else
            print "> Hembra </p>";

        print "<p> <input type='radio' name = 'sexo' value='M'";

        if ($sexo == 'M') 
            print "checked> Macho </p>";
        else
            print "> Macho </p>";
        
        $form3=<<<FORMULARIO
                Tipo de animal
                <input name="tipoAnimal" type="text" value="$tipoAnimal">
                <br>
      
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Añadir">
                </form>
FORMULARIO;
        
        print $form3;
        
        print "</form>";
    }
    
    function validar(&$tipoAnimal,&$error){
        if(!$tipoAnimal){
            $error="Error: Error introducir tipo animal";
            return false;
        }
        return true;
    }

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php

    session_start();
    include 'conexion_bd.php';
    /*RUTINA PRINCIPAL*/
if (empty($_POST)){
        $dniCliSel = NULL;
        $dniVetSel = NULL;
        $tipoAnimal = NULL;
        $sexo = NULL;
        $error="";
    }else{
        $dniCliSel =  $_POST["clientes"];
        $dniVetSel =  $_POST["veterinarios"];
        $tipoAnimal = $_POST["tipoAnimal"];
        $sexo =       $_POST["sexo"];
    }

    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm( $dniCliSel, $dniVetSel, $tipoAnimal, $sexo, $error);
    }else{
    /*Rutina segunda vuelta*/
    if(validar($tipoAnimal, $error)){
        if(mandarDatos($dniCliSel, $dniVetSel, $tipoAnimal, $sexo)){
            header("Location: menuVeterinario.php");
        }
    }
    drawForm( $dniCliSel, $dniVetSel, $tipoAnimal, $sexo, $error);
    }
    
?>
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
   
    </body>
</html>
