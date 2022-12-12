<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

-->
<?php

session_start();

    if(!empty($_SESSION['dni'])){$dni = $_SESSION['dni'];}

        //print $_SESSION['numProds'];
        $stack[][]=$_SESSION['STACK'];
        $i=$j=0;
        $id='';
        $nombre='';
        $stock='';
        $cantidad='';
        $puntero='';
        
        
        $formAux=<<<FORMPROD
            <form action="pedido.php" method="post">
                <table width="70%"  border="1" cellspacing="1" cellpadding="1">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad a comprar</th>
                    </tr>
FORMPROD;
        $stock=0;
        foreach ($_SESSION['STACK'] as $value) {
            foreach ($value as $value2){
                foreach($value2 as $value3){
                    switch ($i) {
                        case 1:
                            $nombre = $value3;
                            $formProd=<<<FORMREP
                                    <tr>
                                    <td>$value3</td>
FORMREP;
                            $formAux=$formAux.$formProd;
                            break;
                        case 2:
                            $stock=$value3;
                            break;
                        case 3:
                            /*if(empty($_POST["cantidad".$j])){//si viene de pedido
                                if($_SESSION["cantidad".$j] > $stock){
                                     $_SESSION['cantidad'.$j]=$stock;
                                }
                                $cantidad=$_SESSION["cantidad".$j];
                            }else{
                                if($_POST["cantidad".$j] > $stock){
                                    $_POST["cantidad".$j]=$stock;//correccion para no comprar de más
                                }*/
                            
                            $cantidad=$_POST["cantidad".$j];
                            
                            $formProd2=<<<FORMREP2
                                    <td>$cantidad</td>
                                    </tr>
FORMREP2;
                            $formAux=$formAux.$formProd2;
                            $_SESSION['cantidad'.$j]=$cantidad;
                            //$cantidad=$value3;
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
        $formProd3=<<<FORMREP3
                                    </table>
                <h2>
                    ¿Desea finalizar la compra?<br>
                    <input type="submit" name="Submit" value="Finalizar compra y proceder al pago">
            </form>
            <form action="catalogo.php">
                    <input type="submit" type="Submit" value="Volver al catálogo">
            </form>
                </h2>

FORMREP3;
        
        $form=$formAux.$formProd3;
        print $form;
        
        
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
    </body>
</html>


