<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    session_start();
    session_destroy();
    session_start();
    include 'conexion_bd.php';	

    if (empty($_POST)){
        $dni = "";
        $contra="";
        $error="";
    }else{
        $dni = $_POST["dni"];
        $contra = $_POST["contra"];
    }

// pregmatch dni//, imprimir//, comprobar si dni existe, comprobar si contrasña existe
        
function validar(&$dni, &$contra, &$error){
    include 'conexion_bd.php';
    
    if($dni=="" || !preg_match("/[0-9]{7,8}[A-Z]/",$dni)){
        $dni="";
        $error="Error: DNI no válido";
        return false;
    }else{
        $query="SELECT nombreVet, passwordVet "
                ."FROM veterinario WHERE dniVet = '$dni'";
		$res_valid=mysqli_query($conex,$query) 
                        or die (mysqli_error($conex));
                
                if ((mysqli_num_rows ($res_valid)==0) || !$dni){
                    $dni="";
                    $error="Error: Usuario no existe";

                    return false;
                }else{
                    $reg_cliente=mysqli_fetch_array($res_valid);
                }
    }
    
    if($contra != $reg_cliente['passwordVet']){
        $contra2=$reg_cliente['passwordVet'];
        $error="Error: Contraseña incorrecta, $contra2";
        $contra="";
        return false;
    }
    $_SESSION['dni'] = $dniVet;
    $_SESSION['nombre'] = $reg_cliente['nombreVet'];
    //$_SESSION['apellido'] = $reg_cliente['apellidoCli'];
    //$_SESSION['contra'] = $reg_cliente['passwordCli'];
    $_SESSION['email'] = $reg_cliente['emailCli'];
    return true;
}



function draw_form(&$dni, &$contra, &$error){
    $formulario=<<<FORMULARIO
    <form action="loginVeterinario.php" method="post">
            <h2>
FORMULARIO;
    
    if(!empty($_POST) && $dni==""){ /***dni mal*/

        $form2=<<<FORM2
            Introduce tu dni
                <input name="dni" type="text" value="$dni" class="error">  
            <br>
        </h2>
        <h3>$error</h3>
        <br>
        <h2>
FORM2;
    }else{ /****************************DNI bien*/
            $form2=<<<FORM2
        Introduce tu dni
                <input name="dni" type="text" value="$dni">
                <br>
FORM2;
        }
        
        
    if(!empty($_POST) && $contra==""){ /*Contraseña mal*/
                $form3=<<<FORM3
            Introduce tu contraseña
                <input name="contra" type="text" value="$contra" class="error">
                <br>
                </h2>
                <h3>$error </h3>
                <br>
                <br>
                <input type="submit" name="Submit" value="Enviar">
            
    </form>
FORM3;
    }else{ /****************************Contraseña bien*/
                $form3=<<<FORM3
            Introduce tu contraseña
                <input name="contra" type="text" value="$contra">
                <br>
                <br>
        </h2>
        <input type="submit" name="Submit" value="Enviar">
    </form>
        
FORM3;
    }
    
$formulario=$formulario.$form2.$form3;

print $formulario;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
<?php
/*RUTINA PRINCIPAL*/

$error = '';
if (empty($_POST))/*Rutina inicial*/
{
   draw_form($dni, $contra, $error); 
   
}else{/*Rutina segunda vuelta*/
    if(validar($dni, $contra, $error)){
        /*submit con sesiones*/
        $_SESSION['DNI'] = $dni;
        header("Location: menuVeterinario.php");
        
    }else{
        draw_form( $dni, $contra, $error);
    }
}
?>
        
    <style type="text/css">
        .error{
            border-color: red;
        }
        
    </style>
    </body>
</html>
