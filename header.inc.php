<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo(NOME_SISTEMA); ?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet"/>
	<link href="css/bootstrap-theme-3.3.6.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link href="css/complemento.css?ver=1.3" rel="stylesheet"/>
	<link href="css/datepicker.min.css" rel="stylesheet">
	<link href="css/business-casual.css" rel="stylesheet"/>

	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/pedido.js?ver=1.8.4"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.min.js" charset="UTF-8"></script>
    <script src="js/locales/bootstrap-datepicker.pt-BR.js" charset="UTF-8"></script>
    <script src="js/jquery.maskedinput.min.js" charset="UTF-8"></script>

</head>

<?php
 	 include "menu.inc.php";
?>


<?php

if( function_exists('escreve_mensagem_status')) escreve_mensagem_status();

?>
