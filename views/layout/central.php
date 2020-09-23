<!-- header-section-starts -->
<?php  ob_start(); ?>

<div class="jumbotron jumbotron-fluid" style="background-image: url(<?=base_url?>img/fondo-pri.jpg);">
    <div class="row no-gutters justify-content-center">
        <div class="col-5 col-sm-5 col-md-2">
            <?php if(isset($_SESSION['identity'])): ?>
            <a class="text-danger" href="<?=base_url?>lobby/index">
                <img class="img-fluid" src="<?=base_url?>img/lego.jpg" alt="" />ARCOIRISFRUTAL</a>
            <?php else: ?>
            <a href="<?=base_url?>">
                <img class="img-fluid" src="<?=base_url?>img/lego.jpg" alt="" />ARCOIRISFRUTAL</a>
            <?php endif; ?>
        </div>
    </div>

</div>


<nav class="navbar navbar-expand-md navbar-light mb-4 bg-light shadow sticky-top" ">

<div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!-- <div class="collapse top-menu navbar-collapse" id="navbarSupportedContent"> -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php if(isset($_SESSION['identity'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url?>lobby/index">Inicio</a>
                </li>            
                <!-- <li class="nav-item"><a class="nav-link" href="<?=base_url?>usuario/logout">Cerrar Sesión</a></li>                                  -->
            <?php endif; ?>

            <?php if(isset($_SESSION['admin'])):?>
                <li class="nav-item"><a class="nav-link" href="<?=base_url?>usuario/mostrarTodos">Usuarios</a></li>
            <?php endif; ?>
            <?php if(!isset($_SESSION['identity'])): ?>
                <li class="nav-item"><a class="nav-link" href="<?=base_url?>">Inicio</a></li>
            <?php endif; ?>
            <?php $categorias = Utils::showCategorias(); ?>
            <?php while($cat = $categorias->fetch_object()): ?>
                <li class="nav-item">
                    <a class="nav-link"  href="<?=base_url?>categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a>
                </li>
            <?php endwhile; ?>

            <?php if(isset($_SESSION['identity'])): ?>
                <li class="nav-item"><a class="nav-link" href="<?=base_url?>pedido/mis_pedidos">Mis pedidos</a></li>
            <?php endif; ?>
        </ul>
        
        <ul class="navbar-nav">
            <?php $stats = Utils::statsCarrito(); ?>
            <li class="nav-item text-center mr-4 pt-2">                
                <a href="<?=base_url?>carrito/index">(<?=$stats['count']?>)
                    <i class="fas fa-shopping-cart mr-4"> $<?=$stats['total']?></i>
                </a>
            </li>

            <?php if(!isset($_SESSION['identity'])): ?>
            <?php else: ?>
                <h5 class="navbar-text"><?=$_SESSION['identity']->nombre?> <?=$_SESSION['identity']->apellido?></h5>
            <?php endif; ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-sm" aria-labelledby="navbarDropdown">
                    <?php if(isset($_SESSION['identity'])): ?>
                        <a class="dropdown-item" href="<?=base_url?>usuario/perfil"><i class="far fa-id-badge"></i>
                            Perfil</a>
                        <a class="dropdown-item" href="<?=base_url?>usuario/logout"><i class="fas fa-sign-out-alt"> </i>
                            Cerrar sesión</a>
                    <?php else: ?>

                    <a class="dropdown-item" href="<?=base_url?>usuario/entrar"><i class="fas fa-sign-in-alt"> </i>
                        Iniciar sesión</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=base_url?>usuario/registro"><i class="fab fa-wpforms"></i>
                        Registrarse</a>
                    <?php endif; ?>
                </div>
            </li>

        </ul>

    </div>
    </div>
</nav>

