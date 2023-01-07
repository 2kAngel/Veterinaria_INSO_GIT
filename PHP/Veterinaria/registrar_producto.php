<?php

    session_start();
    include 'conexion_bd.php';
    
    function mandarDatos($idProducto, $tipoProducto, $nombrePro, $stock)
    {
        include 'conexion_bd.php';

        $queryInsert="INSERT INTO producto (idProducto, tipoProducto, nombrePro, stock) 
                      VALUES ('$idProducto', '$tipoProducto', '$nombrePro', '$stock');";
        
        if(!mysqli_query($conex, $queryInsert))
        {
            return false;
        }
       
        return true; 
    }
    
    function drawForm($idProducto, $tipoProductoSel, $nombrePro, $stock)
{
         print "<form action='registrar_producto.php' method='post'>";
$form=<<<FORMULARIO
          
            <h2>  
FORMULARIO;
        
        if(!empty($_POST) && $idProducto==""){ /***codrefen mal*/
$form1=<<<FORM1
                Id producto
                    <input name="idProducto" type="text" value="$idProducto">  
                    <br>
FORM1;
        }else{ /****************************codrefen bien*/
$form1=<<<FORM1
                Id de producto
                <input name="idProducto" type="text" value="$idProducto">
                <br>
FORM1;
        }
  
     //CASO 1.1
    //PASO 0
    include 'conexion_bd.php';

    //PASO 1
    $query_conv = "SELECT *  FROM tipo"; 

    $result_conv = mysqli_query($conex, $query_conv) or die(mysqli_error($conex));

    print("<h2>Tipo de producto: </h2>");

    //PASO 3
    if (mysqli_num_rows($result_conv) != 0)
    {
        print ("<select name='tipos'>");

        //PASO 4
        while ($reg_conv = mysqli_fetch_array($result_conv))
        {
            $tipoProducto = $reg_conv['tipoPro'];

            if ($tipoProductoSel == $tipoProducto)  
                print ("<option value='$tipoProductoSel' selected> $tipoProductoSel");
            else
                print ("<option value='$tipoProducto'> $tipoProducto"); 
        }
        print("</select>");
    }else           
    {
        print ("<p>No hay ningun tipo de producto vigente</p>");
    }

                if(!empty($_POST) && $nombrePro==""){ /***codrefen mal*/
$form3=<<<FORM3
                Nombre de producto
                    <input name="nombrePro" type="text" value="$nombrePro">  
                    <br>
FORM3;
        }else{ /****************************codrefen bien*/
$form3=<<<FORM3
                Nombre de producto
                <input name="nombrePro" type="text" value="$nombrePro">
                <br>
FORM3;
        }
        
$form4=<<<FORMULARIO
                Stock
                <input name="stock" type="number" value="$stock">
                <br>
                </h2>
              
                <input type="submit" name="Submit" value="Añadir">
FORMULARIO;
        
        $formFinal=$form.$form1.$form3.$form4;
        
        print $formFinal;
        
        print "</form>";
    }
    
    function validar(&$idProducto, &$nombrePro, &$stock ,&$error)
    {
        $valida = true;
        if($idProducto == ""){
            $error=$error." Error: El id de producto debe introducirse";
            $valida = false;
        }
        
        if($nombrePro == ""){
            $error=$error. " El nombre de producto debe introducirse";
            $valida = false;
        }
        
        if($stock <= 0){
            $error=$error. " El stock de producto debe ser mayor que 1";
            $valida = false;
        }
        return $valida;
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

        $idProducto = "";
        $tipoProducto= null;
        $nombrePro = "";
        $stock = 0;
        
    }else{
        
        $idProducto = $_POST["idProducto"];
        $tipoProducto= $_POST["tipos"];
        $nombrePro = $_POST["nombrePro"];
        $stock = $_POST["stock"];
 
    }

    $error = '';
    
    if (empty($_POST))/*Rutina inicial*/
    {
       drawForm($idProducto, $tipoProducto, $nombrePro, $stock);
    }else{/*Rutina segunda vuelta*/
        if(validar($idProducto, $nombrePro, $stock ,$error)){
            if(mandarDatos($idProducto, $tipoProducto, $nombrePro, $stock)){
                header("Location: menuVeterinario.php");
            }  
        } else  
        {
            print $error;
            drawForm($idProducto, $tipoProducto, $nombrePro, $stock);
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
