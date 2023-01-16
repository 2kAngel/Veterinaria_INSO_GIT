<?php



session_start();


 function drawForm($idMascotaSel, $trataSel, $observacion){
     
        include 'conexion_bd.php';
        
        print  "<form action='registrar_trata_masc.php' method='post'>";
          
        $query_conv = "SELECT idMasc FROM mascota "; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Mascotas: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='mascotas'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $idMascota = $reg_con['idMasc'];
            
                if ($idMascota == $idMascotaSel)  
                    print ("<option value='$idMascota' selected> $idMascota");
                else
                    print ("<option value='$idMascota'> $idMascota"); 
            }

            print("</select>");

        }else           
        {
            print ("<p>No hay ningun mascota</p>");
        }
        
        $query_conv = "SELECT idTrata FROM tratamiento "; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Tratamientos: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='tratamientos'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $trata = $reg_con['idTrata'];
            
                if ($trata == $trataSel)  
                    print ("<option value='$trata' selected> $trata");
                else
                    print ("<option value='$trata'> $trata"); 
            }

            print("</select>");

        }else           
        {
            print ("<p>No hay ningun tratamiento</p>");
        }
        
        $form=<<<FORMULARIO
        <h2>Observaciones
        <input name="obser" type="text" value="$observacion"> </h2>
        <br>

        <input type="submit" name="Submit" value="Enviar">
        </form>
FORMULARIO;
        
        print $form;
     
    }
    
    include 'conexion_bd.php';
    /*RUTINA PRINCIPAL*/
    if (empty($_POST)){
            $idMascotaSel = NULL;
            $trataSel = NULL;
            $observacion = NULL;
        }else{
            $idMascotaSel = $_POST['mascotas'];
            $trataSel =  $_POST["tratamientos"];
            $observacion = $_POST["obser"];
        }
        
        if (empty($_POST) || $observacion == NULL )/*Rutina inicial*/
        {
          print "Rellenar todo los datos";
          drawForm($idMascotaSel, $trataSel, $observacion);
        }else{
            $_SESSION['idMascotaSel'] = $idMascotaSel;
            $_SESSION['trataSel'] = $trataSel;
            $_SESSION['observacion'] = $observacion;
            header("location: generar_factura.php"); 
        }
        
?>
