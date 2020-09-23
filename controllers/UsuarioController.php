<?php
require_once 'models/usuario.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// envio de emails
require_once 'vendor/autoload.php';

class usuarioController {


    // public function index(){
    //     Utils::isIdentity();
    //     echo "controlador usuario, accion index";
    // }

    public function recover(){        
        require_once 'views/usuario/recuperacion.php';
    }
    
    public function mostrarTodos(){       
        Utils::isAdmin(); 
        $usuario = new Usuario();
        $todos_los_usuarios = $usuario->conseguirTodos('usuario');
        require_once 'views/usuario/mostrar-todos.php';
    }

   

    public function registro(){      
        require_once 'views/usuario/registro.php';
    }

    public function entrar(){
        require_once 'views/usuario/entrar.php';        
    }

    public function perfil(){    
        Utils::isIdentity();
        $id = $_SESSION['identity']->id;      
        $usuario = new Usuario();
        $usuario->setId($id);
        $todos_los_usuarios = $usuario->conseguirUno('usuario');
        // var_dump($todos_los_usuarios);
        // die();
        require_once 'views/usuario/perfil.php';
    }

    public function actualizarPerfil(){  

        if(isset($_POST)){//tarea: hacer la validacion de los datos, esto solo valida que los campos esten llenos: hacer los if() con los datos que les interesa                    
            $id = isset($_POST['id']) ? $_POST['id'] : false;            
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : false;           
            $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;     
                     
            if($nombre && $apellido && $telefono){
                $usuario = new Usuario();
                $usuario->setId($id);
                $usuario->setNombre($nombre);
                $usuario->setApellido($apellido);               
                $usuario->setTelefono($telefono);
                // var_dump($usuario);
                // die();
                $save = $usuario->UpdateUser('usuario');

                if($save){

                    header('Location:'.base_url.'usuario/logout');

                }else{
                    $_SESSION['register'] = "failed";
                }

            }else{
                $_SESSION['register'] = "failed";
            } 
            
        }else{
            $_SESSION['register'] = "failed";
        }

        // header("Location:".base_url.'usuario/perfil');
        
    }
 

    public function nuevaContraseña(){  

        if(isset($_GET['code'])){ 
            $codigo = $_GET['code'];

            // Instance new Model (Song)
            $usuario = new Usuario();
            $usuario->setCodigo($codigo);
            $user = $usuario->UserporCodigo('usuario');

            if ($user === false) {
                $mensaje = 'El código de recuperación de contraseña no es valido. Por favor intenta de nuevo.';
                header("Location:".base_url.'usuario/recover'); 
            } else {
                $current = date("Y-m-d H:i:s");

                if (strtotime($current) > strtotime($user->fecha_recuperacion)) {
                    $mensaje = 'El código de recuperación de contraseña ha expirado. Por favor intenta de nuevo.';                    
                    header("Location:".base_url.'usuario/recover');                     
                } else {        
                    require_once 'views/usuario/restablecer_contraseña.php';                    
                }
            }
        } else {
            header("Location:".base_url); 
        }
    }

    public function actualizacionContraseña(){

        if(isset($_POST)){//tarea: hacer la validacion de los datos, esto solo valida que los campos esten llenos: hacer los if() con los datos que les interesa        
            $id = isset($_POST['user_id']) ? $_POST['user_id'] : false;    
            $password = isset($_POST['password']) ? $_POST['password'] : false;           
              
            if($id && $password ){
                $usuario = new Usuario();
                $usuario->setId($id);            
                $usuario->setPassword($password);       
                //var_dump($usuario);
                $save = $usuario->UpdatePasswordWithRecover('usuario');   
                    
                header('location:'.base_url.'usuario/entrar');            
            }else{
                header('location:'.base_url);
            }        
        }
    }

    public function sendRecoveryCodePass(){   
   
        if (isset($_POST["email"]) && trim($_POST["email"] != '')) {
            $email = $_POST['email'];
            $codigo = $this->createRandomCode();
            $fecha_recuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));

            $usuario = new Usuario();
            $usuario->setEmail($email);
            $user = $usuario->EmailporUser('usuario');
            
            if ($user === false) {
                $mensaje = 'El correo electrónico no se encuentra registrado en el sistema.';
                header("Location:".base_url); 

            } else {
                $usuario = new Usuario();
                $usuario->setEmail($email);
                $usuario->setCodigo($codigo);
                $usuario->setFecha_recuperacion($fecha_recuperacion);
                $respuesta = $usuario->recoverPassword('usuario');
                
                if ($respuesta) {              
                    $this->sendMail($email, $user->nombre, $codigo);
                    
                    echo 'Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada.';
                    header('Location:'.base_url.'usuario/logout');
                } else {
                    echo 'No se recuperar la cuenta. Si los errores persisten comuniquese con el administrador del sitio.';
                    header("Location:".base_url); 
                }
            }
        } else {
            // echo 'El campo de correo electrónico es requerido.';
            header("Location:".base_url); 
        }
    }

    public function sendRecoveryCode(){   
   
        if (isset($_POST["email"]) && trim($_POST["email"] != '')) {
            $email = $_POST['email'];
            $codigo = $this->createRandomCode();
            $fecha_recuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));

            $usuario = new Usuario();
            $usuario->setEmail($email);
            $user = $usuario->EmailporUser('usuario');
            
            if ($user === false) {
                $mensaje = 'El correo electrónico no se encuentra registrado en el sistema.';
                header("Location:".base_url.'usuario/recover'); 

            } else {
                $usuario = new Usuario();
                $usuario->setEmail($email);
                $usuario->setCodigo($codigo);
                $usuario->setFecha_recuperacion($fecha_recuperacion);
                $respuesta = $usuario->recoverPassword('usuario');
                
                if ($respuesta) {              
                    $this->sendMail($email, $user->nombre, $codigo);
                    
                    echo 'Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada.';
                    header("Location:".base_url.'usuario/recover'); 

                } else {
                    echo 'No se recuperar la cuenta. Si los errores persisten comuniquese con el administrador del sitio.';
                    header("Location:".base_url.'usuario/recover'); 

                }
            }
        } else {
            // echo 'El campo de correo electrónico es requerido.';
            header("Location:".base_url.'usuario/recover'); 

        }
    }

    public function createRandomCode(){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }    
        return time().$pass;
    }


    public function sendMail($email, $nombre, $codigo){
     
        $template = file_get_contents(base_url.'views/usuario/template.php');
        
        $template = str_replace("{{name}}", $nombre, $template);
        $template = str_replace("{{action_url_2}}", '<b>'.base_url.'usuario/nuevaContraseña&code='.$codigo.'</b>', $template);
        $template = str_replace("{{action_url_1}}", base_url.'usuario/nuevaContraseña&code='.$codigo, $template);
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{operating_system}}", Utils::getOS(), $template);
        $template = str_replace("{{browser_name}}", Utils::getBrowser(), $template);
       
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
       
        try {
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );

            $mail->SMTPDebug = 0;          
            $mail->isSMTP();
            $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ibanasca20@gmail.com';   //username
            $mail->Password = 'juanibanasca123';   //password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
            $mail->Port = 587;                    //smtp port

            $mail->setFrom('ibanasca20@gmail.com', 'ARCOIRISFRUTAL');
            $mail->addAddress($email, $nombre);            
            
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña - ARCOIRISFRUTAL';
            $mail->Body    = $template;
           
            $mail->send();
            echo 'mensaje enviado';
           
        } catch (Exception $e) {
            // return false;
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
    

    public function save(){

        if(isset($_POST)){//tarea: hacer la validacion de los datos, esto solo valida que los campos esten llenos: hacer los if() con los datos que les interesa        
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;
            $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;

              
            if($nombre && $apellido && $email && $password && $telefono){
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellido($_POST['apellido']);
                $usuario->setEmail($_POST['email']);
                $usuario->setPassword($_POST['password']);
                $usuario->setTelefono($_POST['telefono']);

                //var_dump($usuario);
                $save = $usuario->save();

                if($save){
                    $_SESSION['register'] = "complete";
                    
                }else{
                    $_SESSION['register'] = "failed";
                }

            }else{
                $_SESSION['register'] = "failed";
            } 
            
        }else{
            $_SESSION['register'] = "failed";
        }
        header("Location:".base_url.'usuario/registro');
    }

    public function emailAjax(){
        $email = $_POST['email'];
        // var_dump($email);
        // die();
        $usuario = new Usuario();
        $usuario->setEmail($_POST['email']);
        $todos_los_usuarios = $usuario->conseguirEmail('usuario');
        // return $todos_los_usuarios;
        print JSON_encode($todos_los_usuarios, JSON_UNESCAPED_UNICODE);

    }

    public function login(){
        if(isset($_POST)){//consulta si llegan datos por formulario
            //identificar al usuario
            //consulta a la Base de datos 
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            if($email && $password){
                $usuario = new Usuario();
                $usuario->setEmail($_POST['email']);
                $usuario->setPassword($_POST['password']);   
                        
                $identity = $usuario->login(); //crear una sesion
            
                if($identity && is_object($identity)){//mantener al usuario identificado
                    $_SESSION['identity'] = $identity;

                    if($identity->rol == 'admin'){
                        $_SESSION['admin'] = true;
                    }
                    $_SESSION['error_login'] = 'complete';
                    header("Location:".base_url.'lobby/index');  

                }else{                    
                    $_SESSION['error_login'] = 'failed';
                    header("Location:".base_url.'usuario/entrar'); 
                }
                
            }else{
                $_SESSION['error_login'] = 'failed';
                header("Location:".base_url.'usuario/entrar'); 
            } 

        }else{
            $_SESSION['error_login'] = 'failed';
            header("Location:".base_url.'usuario/entrar'); 
        }      
        // header("Location:".base_url.'lobby/index'); 
    }

    public function logout(){
        if(isset($_SESSION['identity'])){
           unset($_SESSION['identity']);
        }

        if(isset($_SESSION['admin'])){
           unset($_SESSION['admin']);
        }
        
        session_unset();
        session_destroy();
        
        //header("Location:".base_url.'principal/index');
        echo "<script>window.location.replace(' " . base_url . " ');</script>";
   }

   
}