<?php



session_start();


 function drawForm($idMascotaSel, $trataSel, $observacion){
     
        include 'conexion_bd.php';
        
        print  "<form action='registrar_trata_masc.php' method='post'>";
          
        $query_conv = "SELECT idMasc,tipoAnimal,dniCli FROM mascota WHERE activo = '1'"; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Mascotas: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='mascotas'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $idMascota = $reg_con['idMasc'];
                $tipoAnimal= $reg_con['tipoAnimal'];
                $dniCli=$reg_con['dniCli'];
                if ($idMascota == $idMascotaSel)  
                    print ("<option value='$idMascota' selected> $idMascota/$tipoAnimal/D:$dniCli");
                else
                    print ("<option value='$idMascota'> $idMascota/$tipoAnimal/D:$dniCli"); 
            }

            print("</select>");

        }else           
        {
            print ("<p>No hay ningun mascota</p>");
        }
        
        $query_conv = "SELECT idTrata,tipoTrata FROM tratamiento WHERE activo = '1'"; 

        $result_con = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

        print("<h2>Tratamientos: </h2>");

        if (mysqli_num_rows($result_con) != 0)
        {
            print ("<select name='tratamientos'>");

            while ($reg_con = mysqli_fetch_array($result_con))
            {
                $trata = $reg_con['idTrata'];
                $tipoTrata = $reg_con['tipoTrata'];
                if ($trata == $trataSel)  
                    print ("<option value='$trata' selected> $trata/$tipoTrata");
                else
                    print ("<option value='$trata'> $trata/$tipoTrata"); 
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
