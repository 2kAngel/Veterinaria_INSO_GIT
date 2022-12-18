<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if(!empty($_SESSION['DNI'])){$dniCli=$_SESSION['DNI'];}


function actualizarValor(&$idProd,&$cantidad,&$stock, &$dniCli, &$total){
    include 'conexion_bd.php';
    $stocActualizado=0;
    $stocActualizado=intval($stock) - intval($cantidad);
    $query_producto="UPDATE `producto`  "
            . "SET 'stock' = '$stocActualizado' "
            . "WHERE 'idProducto' = '$idProd';";
    
    $query_Cliente_Producto="INSERT INTO `cliente-producto` (`dniCli`,`idProducto`,`cantidad`) "
            . "VALUES ('$dniCli','$idProd','$cantidad');";
    
    $hoy=strval(date("d.m.y"));
    $query_Recibo="INSERT INTO `recibo` (`numRec`, `dniCliente`, `idProducto`, `fechaRec`, `precioRec`) "
            . "VALUES (NULL,'$dniCli','$idProd','$hoy','$total');";
    
    $res_valid=mysqli_query($conex,$query_Recibo) 
                        or die (mysqli_error($conex));
    $res_valid=mysqli_query($conex,$query_producto) 
                        or die (mysqli_error($conex));
    $res_valid=mysqli_query($conex,$query_Cliente_Producto) 
                        or die (mysqli_error($conex));
}



$head=<<<HEAD
            <form action="pedido.php" method="post">
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
$idProd='';
$nombre='';
$stock=0;
$cantidad=0;
$precio=0;
$total=0;
$formProd='';$formProd1='';$formProd2='';$formProd3='';$formProd4='';$formAux='';
foreach ($_SESSION['STACK'] as $value) {
            foreach ($value as $value2){
                foreach($value2 as $value3){
                    switch ($i) {
                        case 0;
                            $idProd=$value3;
                            $formProd=<<<FORMREP
                                    <tr>
                                    <td>$value3</td>
                                    
FORMREP;
                            break;
                        case 1:
                            $nombre = $value3;
                            $formProd1=<<<FORMREP1
                                    
                                    <td>$value3</td>
                                    
FORMREP1;
                            $formAux=$formAux.$formProd;
                            break;
                        case 2:
                            $stock=$value3;
                            $formProd2=<<<FORMREP2
                                    
                                    <td>$value3</td>
FORMREP2;
                        case 3:
                            $cantidad=0;
                            $cantidad= $_SESSION["cantidad".$j];
                            $formProd3=<<<FORMREP3
                                    <td>$cantidad</td>
                                    
FORMREP3;
                            //$cantidad=$value3;
                            break;
                        case 4:
                            $precio=$value3;
                            $formProd4=<<<FORMREP4
                                    
                                    <td>$value3</td>
                                    </tr>
FORMREP4;
                            $head=$head.$formProd.$formProd1.$formProd2.$formProd3.$formProd4;
                            $total=$total+(doubleval($cantidad) * doubleval($precio));
                            actualizarValor($idProd,$cantidad,$stock,$dniCli,$total);
                            break;
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
            </form>
            
                </h2>

TAIL;
    $head=$head.$tail;
    print $head;
    
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
