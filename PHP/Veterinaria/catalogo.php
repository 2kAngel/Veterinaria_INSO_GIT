<!DOCTYPE html>
<!--
se guarda en la sesión una estructura STACK con el orden de los objetos
se guarda en el post una lista con todas las cantidades
-->
<?php
if(session_status()=="PHP_SESSION_ACTIVE"){}
else{session_start();}


if (empty($_POST)){
        $tipoPro = "";
    }else{
        $tipoPro = $_POST["tipoPro"];

    }
    
    if(!empty($_SESSION['dni'])){$dni = $_SESSION['dni'];}
    if(!empty($_SESSION['nombre'])){$nombre = $_SESSION['nombre'];}
    if(!empty($_SESSION['apellido'])){$apellido= $_SESSION['apellido'];}
    if(!empty($_SESSION['numProds'])){$numProds= $_SESSION['numProds'];}
    else{$numProds=0;}
    
    $stack=array();
    //if(!empty($_SESSION['STACK'])){$stack = $_SESSION['STACK'];}
    //if(!empty($_SESSION['STACK'])){$_SESSION['STACK']=array();}
    //$_SESSION['contra'] = $reg_cliente['passwordCli'];
    //$email= $_SESSION['email'];


function draw_catalogo(&$dni,&$nombre,&$apellido){
    include 'conexion_bd.php';
    
    $header=<<<FORM
            <h1>
            Bienvenido $nombre $apellido.
            </h1>
            <br>
            <h2>
            ¿Qué deseas comprar hoy?
            <br>
            <br>
FORM;
    
    $query_tipo="SELECT tipoPro, precio
			FROM tipo;";
    $res_tipo=mysqli_query($conex, $query_tipo) or die (mysql_error());
    
    if (mysqli_num_rows($res_tipo)!=0){
        
        $formTipo=<<<FORMTIPO
            <form action="catalogo.php" method="post">

                <table width="70%"  border="1" cellspacing="1" cellpadding="1">
                    <tr>
                        <th>Tipo de producto</th>
                        <th>Precio</th>
                    </tr>
FORMTIPO;
        $dataTabla="";
        while ($reg=mysqli_fetch_array($res_tipo)){
            $tipoPro=$reg['tipoPro'];
            $precio=$reg['precio'];
            //$dataTabla="";
            $dataTabla.=<<<DATA
                    <tr>
                        <td><input type="submit" name="tipoPro" value="$tipoPro" /></td>
                        <td>$precio €$</td>
                    </tr>
DATA;
	}
        
        $tabla_foot=<<<PIE
		</table>
                </form>
PIE;
        
        $tabla_completa=<<<TABLA_COMPLETA
                $header
                $formTipo
                $dataTabla
		$tabla_foot
TABLA_COMPLETA;
        
        
    print $tabla_completa;
    
    }
}

function draw_catalogo_prod(&$tipoPro, &$stack, &$nombre,&$apellido,&$numProdsAnterior){
    include 'conexion_bd.php';
    session_start();
    
    $precio =getPrecio($tipoPro);
    if($precio <0){
        print 'error en la recuperación de precio';
        return -1;
    }
    $query_producto="SELECT idProducto, nombrePro, stock 
			FROM producto
			WHERE tipoProducto like '$tipoPro'; ";
    $res_tipo=mysqli_query($conex, $query_producto) or die (mysql_error());

    $header=<<<FORM
            <h1>
            Bienvenido $nombre $apellido.
            </h1>
            <br>
            <h2>
            ¿Qué deseas comprar hoy?
            <br>
            <br>
FORM;
            
    if (mysqli_num_rows($res_tipo)!=0){

        $formProd=<<<FORMPROD
            <form action="carrito.php" method="post">

                <table width="70%"  border="1" cellspacing="1" cellpadding="1">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Máxima compra</th>
                        <th>Cantidad a comprar</th>
                    </tr>
FORMPROD;
        
        $i=$numProdsAnterior;
        $dataTabla="";
        while ($reg=mysqli_fetch_array($res_tipo)){
            $nombrePro=$reg['nombrePro'];
            $stock=intval($reg['stock']);
            $cantidad="cantidad".$i; //Nombre de la variable POST donde se guarda
            $dataTabla.=<<<DATA
                    <tr>
                        <td>$nombrePro</td>
                        <td>$precio €$</td>
                        <td>$stock unidades</td>
                        <td><input name="$cantidad" type="number" value="0" min="0" max="$stock"></td>
                    </tr>
DATA;
            $i++;
            $stack[]=array(array($reg['idProducto'],$nombrePro,$stock,$cantidad,$precio)); //Array donde se guarda la info
        }
        
        $_SESSION['STACK']=$stack;//Array guardado en session
        $_SESSION['numProds']=$i;
        $tabla_foot=<<<PIE
                </table>
            <input type="submit" name="Submit" value="Añadir al carrito">
                </form>
PIE;
        
    $tabla_completa2=<<<TABLA_COMPLETA2
                $header
                $formProd
                $dataTabla
		$tabla_foot
TABLA_COMPLETA2;
    
    print $tabla_completa2;
        
    }
}


function getPrecio($tipoPro){
    include 'conexion_bd.php';
    $query_precio="SELECT precio 
			FROM tipo
			WHERE tipoPro = '$tipoPro'; ";
    
    $res_precio=mysqli_query($conex, $query_precio) or die (mysql_error());
        if (mysqli_num_rows($res_precio)!=0){
            $value=mysqli_fetch_array($res_precio);
            return $value['precio'];
        }
    return -1;

}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
if (empty($_POST))/*Rutina inicial*/
{
   draw_catalogo($dni,$nombre,$apellido); 
   
}else{/*Rutina segunda vuelta*/

        //$_SESSION['DNI'] = $dni;
        //header("Location: catalogo2.php");
        draw_catalogo_prod($tipoPro, $stack ,$nombre,$apellido, $numProds);
}
        ?>
    </body>
</html>
