<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/central.php'; ?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-7">
           
            <div class="card shadow-lg border-1 rounded-lg">
                <div class="card-header bg-dark">
                    <h2 class="text-center text-white font-weight-light my-4">Crear una cuenta</h2>
                </div>
                <div class="card-body bg-white">
                    <form id="formRegister" action="<?=base_url?>usuario/save" method="POST">
                        <!-- <form action="" id="formRegister"  method="POST">  -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label  for="inputFirstName">Nombres</label>
                                    <input class="form-control " id="inputFirstName" name="nombre" type="text"
                                        placeholder="Ingrese el nombre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label  for="inputLastName">Apellidos</label>
                                    <input class="form-control " id="inputLastName" name="apellido" type="text"
                                        placeholder="Ingrese el apellido">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  for="inputEmailAddress" >Correo</label>
                            <input class="form-control"  id="inputEmailAddress" name="email" type="email" aria-describedby="emailHelp" placeholder="Example@gmail.com">
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label  for="inputPassword">Contraseña</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-eye" id="mostrar" style="cursor:pointer;"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Enter password" />

                                    <!-- <a id="mostrar"><i class="fas fa-eye"></i></a> -->

                                </div>
                                <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Debe contener mayor a 4 caracteres.</li>
                                            <li class="list-group-item">Debe contener letras y numeros.</li>
                                </ul> 
                            </div>
                            <div class="col-md-6">
                                <label  for="inputConfirmPassword">Confirmar Contraseña</label>
                                <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-eye" id="mostrarconfirmacion" style="cursor:pointer;"></i>
                                        </div>
                                    </div>
                                    <input class="form-control" id="inputConfirmPassword" type="password"
                                        placeholder="Confirm password">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                        <!-- <div class="form-group"> -->
                            <div class="form-group col-md-6">
                                <label  for="inpuTelephone">Telefono</label>
                                <input class="form-control" id="inpuTelephone" name="telefono" type="num" placeholder="Ingrese el telefono">
                            </div>

                            
                        </div>

                        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'):
                            header('location: entrar');
                        ?>
                        <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Identificacion fallida!</strong> Introduce correctamente los datos.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                            <!-- <strong class="alert_red">Registro fallido, introduce bien los datos</strong> -->
                            <?php endif; ?>
                            <?php utils::deleteSession('register'); ?>

                        <div class="form-group mt-4 mb-0">
                            <button type="button" id="registrar" class="btn btn-success btn-block">Crear una cuenta</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="text-dark">
                        ¿Tienes una cuenta? <a href="<?=base_url?>usuario/entrar" class="text-success">Ir al inicio de sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  require_once 'views/layout/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#registrar').click(function (e) {
            e.preventDefault();
            var nombres = $.trim($("#inputFirstName").val());
            var apellidos = $.trim($("#inputLastName").val());
            var email = $.trim($("#inputEmailAddress").val());
            var password = $.trim($("#inputPassword").val());
            var Confirmpassword = $.trim($("#inputConfirmPassword").val());
            var telefono = $.trim($("#inpuTelephone").val());

            passcaracteres = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)([A-Za-z\d]|[^ ]){4,20}$/;

            if (nombres.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo nombres!",
                    icon: "warning"
                });
                return false;
            }
            if (!isNaN(nombres)) {
                Swal.fire({
                    title: "Dato invalido!",
                    text: "El campo nombres NO permite caracteres numericos!",
                    icon: "warning"
                });
                return false;
            }

            else if (apellidos.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo apellidos!",
                    icon: "warning"
                });
                return false;
            }
            if (!isNaN(apellidos)) {
                Swal.fire({
                    title: "Dato invalido!",
                    text: "El campo apellidos NO permite caracteres numericos!",
                    icon: "warning"
                });
                return false;
            }

            else if (email.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo correo!",
                    icon: "warning"                
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

            function validateEmail($email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test(email);
            }

            if (password.length == "") {
                Swal.fire({
                    title: "Campo vacio!",
                    text: "Debe llenar el campo contraseña!",
                    icon: "warning"              
                    });
                return false;
            }
            //    var letter = /[a-zA-Z]/;
            //     var number = /[0-9]/;

            else if (!passcaracteres.test(password)) {
                Swal.fire({
                    title: "Contraseña invalida!",
                    text: "La contraseña debe contener letras y numeros!",
                    icon: "warning"                
                    });
                return false;
            }

            else if (password.length < 4) {
                Swal.fire({
                    title: "Contraseña invalida!",
                    text: "La contraseña debe contener mayor a 4 caracteres!",
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
                    icon: "warning"
                                    });
                return false;
            }

            else if (telefono.length == "") {
                Swal.fire({
            title: "Campo vacio!",
            text: "Debe llenar el campo telefono!",
            icon: "warning"
            });
                return false;
            }

            else if (isNaN(telefono)) {
                Swal.fire({
                    title: "Telefono invalido!",
                    text: "El campo telefono solo permite caracteres numericos!",
                    icon: "warning"
                                    });
                return false;
            }

            else if (telefono.length < 10) {
                Swal.fire({
                    title: "Telefono invalido!",
                    text: "El campo telefono debe contener 10 digitos!",
                    icon: "warning"
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
                                icon: 'error',
                                title: '!Correo existente¡',
                                html: 'Intente registrando otro correo'
                            });
                        }
                        else {
                            Swal.fire({
                                icon: "success",
                                title: "Registro exitoso!",
                                confirmButtonColor: '#3349ff',
                                showConfirmButton: false, //Oculto el boton de OK
                                timer: 1500    //Seteo un tiempo en pantalla antes de cerrar el alert
                                // confirmButtonText: 'Ingresar'
                            }).then(function(){
                                $("#formRegister").submit();
                            })
                        }
                    }
                });
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