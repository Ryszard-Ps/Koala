<?php
/**
* Incluye la vista asociada a la petición de incio  y también es página de incio
**/

require(HTML_DIR . 'global/cabecera.php');
require('raiz/logica/funcion/Bitacora.php');

if (!isset($_SESSION['usuario'])){
  include(HTML_DIR . 'publico/autenticacion.html');
} else {
  $tmp_permiso = $_SESSION['usuario']['permiso_tmp'];
  $rfc = $_SESSION['usuario']['rfc'];


  if ($tmp_permiso == 0) {
    require(HTML_DIR . '/global/nav_empleado.php');
    require(HTML_DIR . '/inicio/inicio.php');
  } elseif ($tmp_permiso == 1) {
    require(HTML_DIR . '/global/nav_zona.php');
    require(HTML_DIR . '/inicio/inicio.php');
  } else {
    require(HTML_DIR . '/global/nav_admin.php');
    require(HTML_DIR . '/inicio/inicio.php');
  }
}

require(HTML_DIR . 'global/pie.php');
 ?>
