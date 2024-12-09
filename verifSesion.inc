<?php
session_start();
if (!isset($_SESSION['identificacion_Sesion'])) {
    header('location: ./index.php');
    exit();
}
?>