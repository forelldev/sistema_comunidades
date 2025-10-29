<?php
// routes.php
Router::get('/', 'LoginControl@index'); // RUTA PARA LOGIN CUANDO NO ESTÁS LOGEADO ES LO PRIMERO
Router::post('/ingresar','LoginControl@ingresar');
Router::get('/main','LoginControl@main'); 
Router::get('/registro','LoginControl@registro');
Router::post('/registrar_usuario','LoginControl@registrar_usuario');
Router::get('/validar-sesion', 'LoginControl@validarSesionAjax');
Router::get('/cerrar_sesion', 'ComunidadControl@cerrar_sesion');
Router::get('/registrar_documento', 'ComunidadControl@registrar_documento');
Router::post('/registro_documento','ComunidadControl@registro_documento');
Router::get('/felicidades','ComunidadControl@felicidades');
Router::get('/lista','ComunidadControl@lista');
Router::get('/editar','ComunidadControl@editar');
Router::post('/actualizar','ComunidadControl@actualizar');
Router::get('/cerrar_sesion','LoginControl@cerrar_sesion');
Router::get('/monto_vista','ComunidadControl@monto_vista');
Router::post('/buscar_documentos','ComunidadControl@buscar_documentos');

?>