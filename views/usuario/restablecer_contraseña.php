<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>



<section class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-sm-5">
      <div class="card shadow-lg border-1 rounded-lg">

        <div class="card-header bg-dark">
          <h3 class="text-center text-white font-weight-light my-4">Restablezca contraseña</h3>

        </div>
        <div class="card-body bg-light">

          <form id="formRestablecer" action="<?=base_url?>usuario/actualizacionContraseña" method="POST">

            <div class="form-row">
              <div class="col-md-12">
              <label for="inputCorreo">Correo</label>
              <div class="input-group mb-2">
              <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $user->email ?>">                
            </div>
              </div>
              <div class="col-md-12">
                <input name="user_id" type="hidden" value="<?php echo $user->id ?>" />

                <label for="inputPassword">Contraseña</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-eye" id="mostrar" style="cursor:pointer;"></i>
                    </div>
                  </div>
                  <input class="form-control" id="inputPassword" name="password" type="password"
                    placeholder="Enter password" />

                  <!-- <a id="mostrar"><i class="fas fa-eye"></i></a> -->

                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Debe contener mayor a 4 caracteres.</li>
                  <li class="list-group-item">Debe contener letras y numeros.</li>
                </ul>
              </div>
              <div class="col-md-12">
                <label for="inputConfirmPassword">Confirmar Contraseña</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-eye" id="mostrarconfirmacion" style="cursor:pointer;"></i>
                        </div>
                    </div>
                    <input class="form-control" id="inputConfirmPassword" type="password" placeholder="Repita Contraseña" />
                </div>
                <!-- <div class="form-group">
                  <input class="form-control" id="inputConfirmPassword" type="password" placeholder="Confirm password">
                </div> -->
              </div>
            </div>
            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
              <button type="button" id="botonRestablecer" name="btnGuardar" class="btn btn-success btn-block">Confirmar</button>
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
    $('#botonRestablecer').click(function (e) {
      e.preventDefault();

      var password = $.trim($("#inputPassword").val());
      var Confirmpassword = $.trim($("#inputConfirmPassword").val());

      passcaracteres = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)([A-Za-z\d]|[^ ]){4,20}$/;

      if (password.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo contraseña!",
                    icon: "warning"
                });
                return false;
            }
        
        else if (Confirmpassword.length == "") {
                Swal.fire({
            title: "Campo vacio!",
            text: "Debe llenar el campo confirmacion de contraseña!",
            icon: "warning"
            });
                return false;
        }
        else if (password != Confirmpassword) {
                Swal.fire({
                    title: "Contraseñas distintas!",
                    text: "La confirmacion de contraseña NO coincide con la contraseña anterior!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }
            //    var letter = /[a-zA-Z]/;
            //     var number = /[0-9]/;

            else if (!passcaracteres.test(password)) {
                Swal.fire({
                    title: "Contraseña invalida!",
                    html: "<ul><li>Minimo 4 caracteres</li>"+
                    "<li>Maximo 20</li>"+
                    "<li>Al menos una letra mayúscula</li>"+
                    "<li>Al menos una letra minucula</li>"+
                    "<li>Al menos un dígito</li>"+
                    "<li>No espacios en blanco</li>",
                    icon: "warning"
                    // button: "OK!"
                });
                return false;
            }

            else if (password.length < 4) {
                Swal.fire({
                    title: "Contraseña invalida!",
                    text: "La contraseña debe contener mayor a 4 caracteres!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }

            else{
              Swal.fire({
                    icon: "warning",
                    title: "Cambio de contraseña!",
                    text: "Esta seguro?",
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    confirmButtonText: "Sí, Aceptar",
                    cancelButtonText: "Cancelar"
                    // timer: 1500    //Seteo un tiempo en pantalla antes de cerrar el alert
                    // confirmButtonText: 'Ingresar'
              }).then((result) => {
                if (result.value) {
                  Swal.fire({
                    icon: 'success',
                    title: 'Restablecida!',
                    text: 'Su contraseña ha sido restablecida existamente',
                    showConfirmButton: false,
                    timer: 1500  
                  }).then(function(){
                        $("#formRestablecer").submit();
                  })
                }else{
                  return false;
                }
            })
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

        $('#mostrarconfirmacion').click(function () {
            //Comprobamos que la cadena NO esté vacía.
            var Comfirmpassword = $("#inputConfirmPassword").attr("type");

            if(Comfirmpassword == "password"){
                $('#mostrarconfirmacion').addClass('fa-eye-slash').removeClass('fa-eye');
                $('#inputConfirmPassword').removeAttr('type');
            }else{
               
            $('#inputConfirmPassword').attr('type', 'password');
            $('#mostrarconfirmacion').addClass('fa-eye').removeClass('fa-eye-slash');
            }


        }); 
    
  });

</script>