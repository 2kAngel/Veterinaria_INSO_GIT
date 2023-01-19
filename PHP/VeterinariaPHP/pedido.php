<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if(!empty($_SESSION['$dniCliSel'])){$dniCli=$_SESSION['$dniCliSel'];}

//Actualizar el valor de recibo
function actualizarValorRec($idProd,$cantidad,$stock, $dniCli, $hoy){
    include 'conexion_bd.php';
    $total = calcularTotal();
    $query_Recibo="INSERT INTO `recibo` (`idRec`,`fechaRec`, `precioRec`,`dniCli`) "
                . "VALUES (NULL,'$hoy','$total', '$dniCli');";
        $res_valid=mysqli_query($conex,$query_Recibo) 
                            or die (mysqli_error($conex));
        $idRec=mysqli_insert_id($conex);
        return $idRec;
         
}

//Actualizar el valor de producto singular
function actualizarValorProd($idProd,$cantidad,$stock, $idRec){
    include 'conexion_bd.php';
    
    if($cantidad > 0){
        $stocActualizado=0;
        $stocActualizado=intval($stock) - intval($cantidad);
        $query_producto="UPDATE `producto`  "
                . "SET `stock` = '$stocActualizado' "
                . "WHERE `idProducto` = '$idProd';";
        
        //print "VALUES (NULL,'$hoy','$total');<br><br>";

        /*$querySelect="SELECT idRec FROM recibo "
                . "WHERE `fechaRec` = '$hoy' AND `precioRec` =  '$total';";
        $idRec=0;
        $res_Sel=mysqli_query($conex, $querySelect) or die (mysqli_error($conex));
        if (mysqli_num_rows($res_Sel)!=0){
                $reg=mysqli_fetch_array($res_Sel);
                $idRec=$reg['idRec'];
        }*/

        //print $idRec."<br><br>";
        $query_Cliente_Producto="INSERT INTO cliente_producto (idRec,idProducto,cantidad) "
                . "VALUES ('$idRec','$idProd','$cantidad');";


        $res_valid=mysqli_query($conex,$query_producto) 
                            or die (mysqli_error($conex));
        $res_valid=mysqli_query($conex,$query_Cliente_Producto) 
                            or die (mysqli_error($conex));

    }
    
}

//Saca la cantidad total de dollars del pedido
function calcularTotal(){
    $i=0;$j=0;$total=0;
    foreach ($_SESSION['STACK'] as $value) {
        foreach ($value as $value2){
            foreach($value2 as $value3){
                switch ($i){
                    case 3:
                    $precio=$value3;
                    $cantidad= $_SESSION["cantidad".$j];
                    $total=$total+(doubleval($cantidad) * doubleval($precio));
                default:
                    break;
                }
                $i++;
            }
            $i=0;
            $j++;
        }
    }
    return $total;
}



//RUTINA PRINCIPAL**********************************************

$head=<<<HEAD
            <form action="menuCliente.php" method="post">
                <table width="70%"  border="1" cellspacing="1" cellpadding="1">
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Stock</th>
                        <th>Cantidad a comprar</th>
                        <th>Precio Producto</th>
                    </tr>
HEAD;

$i=0;$j=0;
$idProd='';$nombre='';$stock=0;$cantidad=0;$precio=0;$total=0;
$formProd='';$formProd1='';$formProd2='';$formProd3='';$formProd4='';$formAux='';
$hoy=strval(date("d.m.y H:s"));
//Inserción de recibo
$idRec= actualizarValorRec($idProd,$cantidad,$stock, $dniCli,$hoy);

foreach ($_SESSION['STACK'] as $value) {
    foreach ($value as $value2){
        foreach($value2 as $value3){
            switch ($i) {
                        case 0;
                            $idProd=$value3;
                            $formProd=<<<FORMREP
                                    <tr>
                                    <td>$idProd</td>
FORMREP;
                            break;
                        case 1:
                            $nombre = $value3;
                            $formProd.=<<<FORMREP1
                                    <td>$nombre</td>
FORMREP1;
                            break;
                        case 2:
                            $stock=$value3;
                            $cantidad= $_SESSION["cantidad".$j];
                            $_SESSION["cantidad".$j] = "";
                        
                            $formProd.=<<<FORMREP2
                                    <td>$stock</td>
                                    <td>$cantidad</td>
FORMREP2;
                            break;
                        case 3:
                            $precio=$value3;
                            $formProd.=<<<FORMREP4
                                    <td>$precio</td>
                                    </tr>
FORMREP4;
                            $head=$head.$formProd;
                            $total=$total+(doubleval($cantidad) * doubleval($precio));
                            actualizarValorProd($idProd,$cantidad,$stock, $idRec);                            break;
                        default:
                            break;
            }
            $i++;
        }
        $i=0;
        $j++;
    }
}
    $tail=<<<TAIL
                                    </table>
                <h2>
                    TOTAL:$total €$
                    Pago realizado<br>
            
            <input type="submit" type="Submit" value="Volver al menú">
            </form>
            </h2>

TAIL;
    $head=$head.$tail;
    print $head;
    
    //limpiar el stack
    //$_SESSION['STACK'] = "";
    //$_SESSION['numProds'] = 0;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        
        ?>
    </body>
</html>
