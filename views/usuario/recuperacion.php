<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>

<section class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-sm-5">
      <div class="card shadow-lg border-1 rounded-lg">

        <div class="card-header bg-dark">
          <h3 class="text-center text-white font-weight-light my-4">Recuperacion de contraseña</h3>
        </div>
        <div class="card-body bg-light">

          <form id="formRecuperar" action="<?=base_url?>usuario/sendRecoveryCode" method="POST">    

            <div class="form-group">
              <label for="exampleInputEmail1">Correo:</label>
              <input id="email" type="email " name="email" class="form-control" aria-describedby="emailHelp"
                placeholder="Example@gmail.com">
            </div>

            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
              <button type="button" id="botonRecuperar" class="btn btn-success btn-block">Enviar correo de recuperación</button>                
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>



<?php  require_once 'views/layout/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function () {
    $('#botonRecuperar').click(function (e) {
      e.preventDefault();

      var email = $.trim($("#email").val());
      console.log(email);

      function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test(email);
      }

      if (email.length == "") {
        Swal.fire({
          title: "Campo vacio!",
          text: "Debe llenar el campo correo!",
          icon: "warning",
          button: "OK!"
        });
        return false;
      }

      else if (!validateEmail(email)) {
        Swal.fire({
          title: "Correo invalido!",
          text: "El correo ingresado NO esta permitido!",
          icon: "warning",
          button: "OK!"
        });
        return false;
      }      

      else {
            $.ajax({
                url: "../Usuario/emailAjax",
                type: "POST",
                datatype: "json",
                data: { email: email },
                success: function (data) {
                    if (data == 'false') {
                        Swal.fire({
                          icon: "success",
                            title: "Correo enviado exitosamente!",
                            html: "Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada.",
                            confirmButtonColor: '#28a745',
                            showConfirmButton: true, 
                            // timer: 1500 
                            confirmButtonText: 'OK'  
                        }).then(function(){
                            $("#formRecuperar").submit();
                        });
                    }
                    else {
                        Swal.fire({
                          icon: 'error',
                            title: '¡Correo NO existente!',
                            html: 'El correo electrónico no se encuentra registrado en el sistema'
                        });                       
                    }
                }
            });
      }




    });
  });

</script>