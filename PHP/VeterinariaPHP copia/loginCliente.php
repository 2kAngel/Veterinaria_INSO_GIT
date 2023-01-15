<?php

    function drawForm($dniCliSel, $password)
    {
        
        print " <form action='loginCliente.php' method='post'>";
                   
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

        }else           
        {
            print ("<p>No hay ninguna clientes</p>");
        }
        
        print "<input name='password' type='text' value='$password'>";
        
        print "</form>";
     }
 
    function validar (&$dniCliSel, &$password, &$error)
    {
        $valida = true;
        //Debe de empezar con 8 números y terminar con una letra mayúscula
        if (($dniCliSel == "") || (!preg_match("/^[0-9]{8}[A-Z]$/",$dniCliSel))){             
            $error =  $error."Nif invalido";                    //Concatenar ese error en los errores
            $nif = "";                                          //Devolver el parámetro para cuando se vuelva a mostrar vacio
            $valida = false; 
        }
        
        
        include 'conexion_bd.php';
        
        $query_conv = "SELECT password FROM cliente 
                                    WHERE dniCli = $dniCliSel"; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        $reg_con = mysqli_fetch_array($result_con);
        
        if ($reg_con != $password)
        {
            $error =  $error."Contraseña incorrecta";                    //Concatenar ese error en los errores
            $reg_con = "";                                          //Devolver el parámetro para cuando se vuelva a mostrar vacio
            $valida = false;   
        }
        
        return $valida;
    }
    
    
    session_start();
    
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
            $_SESSION['$dniCliSel'] = $dniCliSel;
            $_SESSION['$password'] = $password;
            header("location: menuCliente.php"); 
      }
     
    }
    
?>

