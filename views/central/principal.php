<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>

<div class="container">


<div class="col-md-12">

        <div id="carousel1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner rounded-lg">
                        <div class="carousel-item active">
                            <img class=" img-fluid d-block w-100"  src="<?=base_url?>img/fondo2.jpg" alt=""/>
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid d-block w-100"  src="<?=base_url?>img/fondo3.jpg" alt=""/>
                        </div>
                        <div class="carousel-item">                            
                            <img class=" img-fluid d-block w-100"   src="<?=base_url?>img/fondo4.jpg" alt=""/>
                        </div> 
                    </div>
            
                    <!--Controles NEXT y PREV-->
                    <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                    <!--Controles de indicadores-->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel1" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel1" data-slide-to="1"></li>
                        <li data-target="#carousel1" data-slide-to="2"></li>                        
                    </ol>            
            </div>
        </div>
    </div>
</div>

<?php  require_once 'views/layout/footer.php'; ?>
