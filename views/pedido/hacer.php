<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>

<?php if(isset($_SESSION['identity'])): //si esta identificado ?>
    <h1>Hacer pedido</h1>
    <p>
        <a href="<?=base_url?>carrito/index">Ver los productos y el precio del pedido</a>
    </p>  
    </br>     
    <h3>Direccion para el envio:</h3>
    <form action="<?=base_url.'pedido/add'?>" method="post">
        <label for="provincia">Departamento</label>
        <input type="text" name="provincia" required/>

        <label for="ciudad">Ciudad</label>
        <input type="text" name="localidad" required/>

        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" required/>

        <input type="submit" value="Confirmar pedido">
    </form>

<?php else: ?>
    <h1>Necesita estar identificado</h1>
    <p>Necesita tener una cuenta activa para poder realizar su pedido. </p>
<?php endif; ?>

<?php require_once 'views/layout/footer.php'; ?>


