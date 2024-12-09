<?php
session_start();
include('Conexion.php');

if (isset($_POST['Usuario']) && isset($_POST['Clave'])) {
    function validate($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $Usuario = validate($_POST['Usuario']);
    $Clave = validate($_POST['Clave']);

    $Clavenueva = "Password";  
    $Clavenueva = md5($Clavenueva);  

    // Imprimir por consola
    echo "<script>console.log('Clavenueva: " . $Clavenueva . "');</script>";
    echo "<script>console.log('Clave original (sin encriptar): " . $Clave . "');</script>";

    if (empty($Usuario)) {
        echo "<script>console.log('Error: Usuario vacío');</script>";
        header("Location: index.php?error=El Usuario es requerido");
        exit();
    } elseif (empty($Clave)) {
        echo "<script>console.log('Error: Clave vacía');</script>";
        header("Location: index.php?error=La clave es requerida");
        exit();
    } else {
        $Clave = md5($Clave);  
        echo "<script>console.log('Clave encriptada: " . $Clave . "');</script>";

        $Sql = "SELECT * FROM Usuarios WHERE Usuario = '$Usuario' AND Clave = '$Clave'";
        $result = mysqli_query($conexion, $Sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row["Usuario"] === $Usuario && $row['Clave'] === $Clave) {
                echo "<script>console.log('Usuario y clave coinciden');</script>";

                if   ($Clave !== $Clavenueva) {
                    $_SESSION['Usuario'] = $row['Usuario'];
                    $_SESSION['Nombre_Completo'] = $row['Nombre'];
                    $_SESSION['Id'] = $row['IdUsuario'];
                    $_SESSION['identificacion_Sesion'] = session_create_id();
                    header("Location: indexusuario.php");
                    exit();
                } 
                else   {
                    $_SESSION['Usuario'] = $row['Usuario'];
                    $_SESSION['Nombre_Completo'] = $row['Nombre'];
                    $_SESSION['Id'] = $row['IdUsuario'];
                    $_SESSION['identificacion_Sesion'] = session_create_id();
                    header("Location: recuperacionPassword.php");
                    exit();        
                }
            }
            else {
                echo "<script>console.log('Error: Usuario o clave incorrectos');</script>";
                header("Location: index.php?error=El usuario o la clave son incorrectas");
                exit();
            }
        } else {
            echo "<script>console.log('Error: Usuario o clave incorrectos - no hay filas coincidentes');</script>";
            header("Location: index.php?error=El usuario o la clave son incorrectas");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
