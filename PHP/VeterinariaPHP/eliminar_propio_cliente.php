

<?php        


    function drawForm($aceptar){

    print  "<form action='eliminar_propio_cliente.php' method='post'>";

       print "<p> <input type='radio' name = 'aceptar' value='S'";
            if ($aceptar == 'S') 
                print "checked> Aceptar </p>";
            else
                print "> Aceptar </p>";

            print "<p> <input type='radio' name = 'aceptar' value='N'";

            if ($aceptar == 'N') 
                print "checked> Denegar </p>";
            else
                print "> Denegar </p>";
            
         print "<input type='submit' name='Submit' value='Eliminar'>";

    print "</form>";
    }

    function deleteCliente($dniCli)
    {
        include 'conexion_bd.php';

        //$queryUpdate="DELETE FROM cliente WHERE dniCli LIKE '$dniCli'";
        $queryUpdate="UPDATE cliente SET activo = 0 WHERE `cliente`.`dniCli` = '$dniCli';";
        $res_cli=mysqli_query($conex, $queryUpdate) or die (mysql_error($conex));
                
        if(!$res_cli){
            return false;
        }
        
        return true; 
    }
     
    
    session_start();
    include 'conexion_bd.php';
    /*RUTINA PRINCIPAL*/
    if (empty($_POST)){
        $dniCliSel = $_SESSION['$dniCliSel'];
        $aceptar =  "N";
    }else{
        $dniCliSel = $_SESSION['$dniCliSel'];
        $aceptar =   $_POST['aceptar'];
    }

    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($aceptar);
    }else{
        if ($aceptar == "S")
        {
            if(deleteCliente($dniCliSel))
               header("Location: menuVeterinario.php");
           else
           {
               print "<H2> ERROR DE ELIMINACION </H2>";
               drawForm($aceptar);
           }
        }
        else 
        {
            print "<H2> DENEGANDO </H2>";
            drawForm($aceptar); 
        }
    }
 
    ?>

