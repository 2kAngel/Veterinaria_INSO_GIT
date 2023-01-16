<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h2>
         Menu Veterinario
        </h2>
        <?php
        
        $form=<<<FORM
            <a href='registrar_cliente.php'>Registrar cliente</a><br>
            <a href='registrar_mascota.php'>Registrar mascota</a><br>
            <a href='registrar_veterinario.php'>Registrar veterinario</a><br>             
            <a href='registrar_tipo.php'>Registrar tipo producto</a><br>
            <a href='registrar_tratamiento.php'>Registrar tratamiento</a><br>   
            <a href='registrar_producto.php'>Registrar producto</a><br>  
             
  
            <a href='modificar_cliente.php'>Modificar cliente</a><br>
            <a href='modificar_mascota.php'>Modificar mascota</a><br>   
            <a href='modificar_veterinario.php'>Modificar veterinario</a><br>
                
            <a href='modificar_producto.php'>Modificar producto</a><br>   
            <a href='modificar_tratamiento.php'>Modificar tratamiento</a><br>  
                
                
            <a href='elim_cliente.php'>Eliminar cliente</a><br>
            <a href='elim_mascota.php'>Eliminar mascota</a><br>   
            <a href='elim_veterinario.php'>Eliminar veterinario</a><br>
            <a href='elim_producto.php'>Eliminar producto</a><br>   
            <a href='elim_tratamiento.php'>Eliminar tratamiento</a><br>  
                
            <a href='registrar_trata_masc.php'>Generar factura (trata-masc)</a><br>    
FORM;
        print $form;
        ?>
    </body>
</html>
