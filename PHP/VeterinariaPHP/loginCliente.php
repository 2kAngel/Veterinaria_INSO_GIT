<?php
session_start();




    function drawForm($dniCliSel, $password)
    {
        print " <form action='loginCliente.php' method='post'>";
                   
        include 'conexion_bd.php';
        
        $query_conv = "SELECT dniCli, nombreCli FROM cliente "; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Clientes: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='clientes'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $dniCli = $reg_con['dniCli'];
                $nombreCli = $reg_con['nombreCli'];

                if ($dniCli == $dniCliSel)  
                    print ("<option value='$dniCli' selected> $nombreCli");
                else
                    print ("<option value='$dniCli'> $nombreCli"); 
            }

            print("</select>");

        }else           
        {
            print ("<p>No hay ninguna clientes</p>");
        }
        
        print "<p>Contraseña: <input name='password' type='password' value='$password'></p>";
        
        print "<input type='submit' name='Submit' value='Enviar'>";
        
        print "</form>";
     }
 
    function validar (&$dniCliSel, &$password, &$error)
    {
        $valida = true;
    
        include 'conexion_bd.php';
        
        $query_conv = "SELECT passwordCli FROM cliente 
                                    WHERE dniCli = '$dniCliSel'"; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        $reg_con = mysqli_fetch_array($result_con);
        
        if ($reg_con['passwordCli'] != $password)
        {
            $error =  $error."Contraseña incorrecta";                    //Concatenar ese error en los errores
            $reg_con = "";                                          //Devolver el parámetro para cuando se vuelva a mostrar vacio
            $valida = false;   
        }
        
        return $valida;
    }
    
    
    
    if(empty($_POST))
    {                
        $dniCliSel = "";                        
        $password = "";
    }
    else                                //En caso de si tener información en algun campo del formulario (Pintar Formulario)
    {
        $dniCliSel =  $_POST["clientes"];                        
        $password = $_POST["password"];
    }

    if (empty($_POST)) //si aún no se ha enviado el formulario
    {
       drawForm($dniCliSel, $password);   //Creo el formulario   
    }
    else //para cada vez que el formulario se envíe
    {

        $error = ""; //Inicializamos con 0 errores (vacio)  
        if (!validar ($dniCliSel, $password, $error))        //Vemos si es False o True la fnción de validar (que nos modificara tambien los parámetros al estar con &u)
      {
              print("Errores: ".$error);
              drawForm($dniCliSel, $password); 
      }
      else
      {
            include 'conexion_bd.php';
                  
            $query_conv = "SELECT nombreCli FROM cliente WHERE dniCli = '$dniCliSel'"; 

            $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

            if ($reg_con = mysqli_fetch_array($result_con))
            {
                $nombreCli = $reg_con['nombreCli'];
                 
                $_SESSION['$dniCliSel'] = $dniCliSel;
                $_SESSION['nombreCli'] = $nombreCli;
                header("location: menuCliente.php"); 
            }
      }
     
    }
    
?>

