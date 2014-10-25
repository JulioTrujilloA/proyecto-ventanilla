<?php

// Conexión con el framework LIGA.php
if (is_file("index.php") || is_file("buscar.php") || is_file("inicio.php") ) {
    require_once 'LIGA3/LIGA.php';
} else {
    require_once '../LIGA3/LIGA.php';
}

BD("localhost", "root", "123", "proyectofinal");

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    session_start();
}
?>