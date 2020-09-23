<?php
function contollers_autoload($classname){
    include 'controllers/'.$classname.'.php'; /*entra a la carpeta de los controladores y hace el include de sus clases*/
}
spl_autoload_register('contollers_autoload');