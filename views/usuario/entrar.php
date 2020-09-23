<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>

 

<?php if(!isset($_SESSION['identity'])):?> 

<section class="container-fluid">
  <div class="row no-gutters justify-content-center">
    <div class="col-sm-5">
      <div class="card shadow-lg border-1 rounded-lg">    

        <div class="card-header bg-dark">
        <h3 class="text-center text-white font-weight-light my-4">Iniciar Sesión</h3>
        </div>
        <div class="card-body bg-white">
      
          <form id="formLogin" action="<?=base_url?>usuario/login" method="POST">
              <!-- <form id="formLogin" action="" method="POST"> -->
            <div class="form-group">
              <label for="exampleInputEmail1">Correo:</label>
              <input  id="email" type="email "name="email" class="form-control" aria-describedby="emailHelp" placeholder="Example@gmail.com">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Contraseña:</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-eye" id="mostrar" style="cursor:pointer;"></i>
                        </div>
                    </div>
                    <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Ingrese Contraseña" />
                </div>
            </div>

            <?php if(isset($_SESSION['error_login']) && $_SESSION['error_login'] == 'complete'):?>
                <strong class="alert_green">Acceso completado</strong>
              <?php elseif(isset($_SESSION['error_login']) && $_SESSION['error_login'] == 'failed'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Identificacion fallida!</strong> Introduce correctamente los datos.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif; ?> 
            <?php utils::deleteSession('error_login'); ?>
            
              <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
            
                <input type="submit" class="btn btn-success btn-block" value="Entrar"/>
            </div>
          </form>
        </div>
        <div class="card-footer text-center">
            <div class="text-dark">¿Necesito una cuenta? <a href="<?=base_url?>usuario/registro" class="text-success">¡Regístrate!</a></div>
            <div class="small"><a href="<?=base_url?>usuario/recover" class="text-success">¡Olvidaste tu contraseña!</a></div>

        </div>

      </div>
    </div>
  </div>
</section>

<?php endif; ?>  



<?php  require_once 'views/layout/footer.php'; ?>
<script type="text/javascript">
$(document).ready(function() {
$('#formLogin').submit(function(){
    // e.preventDefault();

   var email = $.trim($("#email").val());
   var password = $.trim($("#inputPassword").val());


   if (email.length == ""){
    Swal.fire({
        title: "Campo vacio!",
        text: "Debe llenar el campo correo!",
        icon: "warning",
        button: "OK!"
    });
        return false;
   }

   else if(!validateEmail(email)){
    Swal.fire({
        title: "Correo invalido!",
        text: "El correo ingresado NO esta permitido!",
        icon: "warning",
        button: "OK!"
    });
        return false;
   }

   function validateEmail($email){
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test(email);
  }

   if(password.length == ""){
    Swal.fire({
        title: "Campo vacio!",
        text: "Debe llenar el campo contraseña!",
        icon: "warning",
        button: "OK!"
    });
        return false;
   }  
    
});

$('#mostrar').click(function () {
            //Comprobamos que la cadena NO esté vacía.
            var password = $("#inputPassword").attr("type");

            if(password == "password"){
                $('#mostrar').addClass('fa-eye-slash').removeClass('fa-eye');
                $('#inputPassword').removeAttr('type');
            }else{
               
            $('#inputPassword').attr('type', 'password');
            $('#mostrar').addClass('fa-eye').removeClass('fa-eye-slash');
            }

        });

      });

</script>
