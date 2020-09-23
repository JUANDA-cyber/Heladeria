<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-7">
           
            <div class="card shadow-lg border-1 rounded-lg mt-5">

                
                <div class="card-header bg-dark">
                    <h2 class="text-center text-white font-weight-light my-4">Perfil</h2>
                </div>
                <div class="card-body bg-light">
                    <div class="card-password">
                        <form id="formNuevaContraseña" action="<?=base_url?>usuario/sendRecoveryCodePass" method="POST">
                            <input type="hidden" id="disabledTextInput" name="email" value="<?=$todos_los_usuarios->email?>">
                            <button type="button" id="botoncodepass" class="btn btn-dark"><i class="fas fa-unlock-alt"><p class="text-light">Cambiar contraseña</p></i></button>  
                        </form>                                    
                    </div>

                    <form id="formPerfil" action="<?=base_url?>usuario/actualizarPerfil" method="POST">
                        <!-- <form action="" id="formRegister"  method="POST">  -->
                       
                        <div class="clearfix"></div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <input name="id" type="hidden" value="<?= $id = $_SESSION['identity']->id?>">
                                <div class="form-group">
                                    <label  for="inputFirstName">Nombres</label>
                                    <input class="form-control " id="inputFirstName" name="nombre" type="text" value="<?=$todos_los_usuarios->nombre?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label  for="inputLastName">Apellidos</label>
                                    <input class="form-control " id="inputLastName" name="apellido" type="text" value="<?=$todos_los_usuarios->apellido?>" >
                                </div>
                            </div>
                        </div>
                        <fieldset disabled>
                        <div class="form-group">
                            <label  for="inputEmailAddress" >Correo: </label>
                            <input type="text" id="disabledTextInput" class="form-control" value="<?=$todos_los_usuarios->email?>">
                        </div> 
                        </fieldset>                      

                        <div class="form-row">
                        
                            <div class="form-group col-md-6">
                                <label  for="inpuTelephone">Telefono</label>
                                <input class="form-control" id="inpuTelephone" name="telefono" type="num" value="<?=$todos_los_usuarios->telefono?>">
                            </div>

                
                            
                        </div>     

                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                            <button type="button" id="botonCambio" name="btnGuardar" class="btn btn-success btn-block">Actualizar</button>
                        </div>                  
                    </form>
                    
                </div>
               
            </div>
        </div>
    </div>
</div>

<?php  require_once 'views/layout/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#botonCambio').click(function (e) {
            e.preventDefault();
            var nombres = $.trim($("#inputFirstName").val());
            var apellidos = $.trim($("#inputLastName").val());
            var password = $.trim($("#inputPassword").val());
            var Confirmpassword = $.trim($("#inputConfirmPassword").val());
            var telefono = $.trim($("#inpuTelephone").val());

            // passcaracteres = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;

            if (nombres.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo nombres!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }
            if (!isNaN(nombres)) {
                Swal.fire({
                    title: "Dato invalido!",
                    text: "El campo nombres NO permite caracteres numericos!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }

            else if (apellidos.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo apellidos!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }
            if (!isNaN(apellidos)) {
                Swal.fire({
                    title: "Dato invalido!",
                    text: "El campo apellidos NO permite caracteres numericos!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }

            // if (password.length == "") {
            //     Swal.fire({
            //         title: "Campo vacio!",
            //         text: "Debe llenar el campo contraseña!",
            //         icon: "warning",
            //         button: "OK!"
            //     });
            //     return false;
            // }
            // //    var letter = /[a-zA-Z]/;
            // //     var number = /[0-9]/;

            // else if (!passcaracteres.test(password)) {
            //     Swal.fire({
            //         title: "Contraseña invalida!",
            //         text: "La contraseña debe contener letras y numeros!",
            //         icon: "warning",
            //         button: "OK!"
            //     });
            //     return false;
            // }

            // else if (password.length < 4) {
            //     Swal.fire({
            //         title: "Contraseña invalida!",
            //         text: "La contraseña debe contener mayor a 4 caracteres!",
            //         icon: "warning",
            //         button: "OK!"
            //     });
            //     return false;
            // }

            // else if (Confirmpassword.length == "") {
            //     Swal.fire({
            // title: "Campo vacio!",
            // text: "Debe llenar el campo confirmacion de contraseña!",
            // icon: "warning",
            // button: "OK!"
            // });
            //     return false;
            // }

            // else if (password != Confirmpassword) {
            //     Swal.fire({
            //         title: "Contraseñas distintas!",
            //         text: "La confirmacion de contraseña NO coincide con la contraseña anterior!",
            //         icon: "warning",
            //         button: "OK!"
            //     });
            //     return false;
            // }

            else if (telefono.length == "") {
                Swal.fire({
            title: "Campo vacio!",
            text: "Debe llenar el campo telefono!",
            icon: "warning",
            button: "OK!"
            });
                return false;
            }

            else if (isNaN(telefono)) {
                Swal.fire({
                    title: "Telefono invalido!",
                    text: "El campo telefono solo permite caracteres numericos!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }

            else if (telefono.length < 10) {
                Swal.fire({
                    title: "Telefono invalido!",
                    text: "El campo telefono debe contener 10 digitos!",
                    icon: "warning",
                    button: "OK!"
                });
                return false;
            }
           
            else{

                Swal.fire({
                    icon: "warning",
                    title: "Cambio de datos personales!",
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
                    title: 'Datos restablecidos!',
                    text: 'Señor usuario vuelva a iniciar sesión.',
                    showConfirmButton: true,
                    confirmButtonColor: '#28a745',
                    ConfirmButtonText: 'Cerrar Sesión.'
                  }).then(function(){
                        $("#formPerfil").submit();
                  })
                }else{
                  return false;
                }
            })
            }
        });
        // $('#mostrar').mousedown(function () {
        //     //Comprobamos que la cadena NO esté vacía.

        //     $('#inputPassword').removeAttr('type');
        //     $('#mostrar').addClass('fa-eye-slash').removeClass('fa-eye');

        // });

        // $('#mostrar').mouseup(function () {

        //     $('#inputPassword').attr('type', 'password');
        //     $('#mostrar').addClass('fa-eye').removeClass('fa-eye-slash');

        // });

        $('#botoncodepass').click(function (e) {
            e.preventDefault();

            Swal.fire({
                    icon: "warning",
                    title: "Cambio de contraseña!",
                    html: "<ul>"+
                    "<li>"+
                    "Se enviará un correo electrónico con las instrucciones para el cambio de tu contraseña. ¿Esta seguro de realizar esta moficación?."+
                    "</li>"+
                    "</ul>",
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
                    title: "Correo enviado exitosamente!",
                    text: 'Señor usuario vuelva a iniciar sesión.',
                    showConfirmButton: true,
                    confirmButtonColor: '#28a745',
                    ConfirmButtonText: 'Cerrar Sesión.'
                  }).then(function(){
                        $("#formNuevaContraseña").submit();
                  })
                }else{
                  return false;
                }
            })


        });

    });

</script>