<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
    
      
<?php

    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos($tipoPro, $precio,&$error)
    {
        include 'conexion_bd.php';
        if($precio <0)
        {
            $error.="<br>El precio no puede ser negativo";
            return false;
        }
        $queryInsert="INSERT INTO tipo (tipoPro, precio) 
                      VALUES ('$tipoPro','$precio');";
        
        if(!mysqli_query($conex, $queryInsert))
        {
            return false;
        }
       
        return true; 
    }
    
    function drawForm($tipoPro, $precio, $error)
{
$form=<<<FORMULARIO
            <form action="registrar_tipo.php" method="post">
            <h1> Registrar Tipo Producto </h1>
            <h2>  
FORMULARIO;
        
        if(!empty($_POST) && $tipoPro==""){ /***codrefen mal*/
$form1=<<<FORM1
                Tipo de producto
                    <input name="tipoPro" type="text" value="$tipoPro" class="error">  
                    <br>
FORM1;
        }else{ /****************************codrefen bien*/
$form1=<<<FORM1
                Tipo de producto
                <input name="tipoPro" type="text" value="$tipoPro">
                <br>
FORM1;
        }
        
$form2=<<<FORMULARIO
                Precio
                <input name="precio" type="number" value="$precio">
                <br>
                </h2>
                <br>
                $error
                <br>
              
                <input type="submit" name="Submit" value="Añadir">
                </form>
FORMULARIO;
        
        $formFinal=$form.$form1.$form2;

        print $formFinal;
    }
    
    function validar(&$tipoPro, $precio, &$error)
    {
        if(!$tipoPro){
            $error.="Error: El tipo de producto debe introducirse";
            return false;
        }
        if($precio <= 0){
            $error.="Error: El precio no puede ser 0 o negativo, puesto que no hay ganancia";
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

if (empty($_POST)){
        $tipoPro = "";
        $precio="";
    }else{
        $tipoPro = $_POST["tipoPro"];
        $precio=$_POST["precio"];
    }

    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($tipoPro, $precio, $error);
    }else{/*Rutina segunda vuelta*/
        if(validar($tipoPro, $precio,$error)){
            if(mandarDatos($tipoPro, $precio,$error)){
                header("Location: menuVeterinario.php");
            }
        }
        drawForm($tipoPro, $precio, $error);
    }
?>
        
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
   
    </body>
</html>
