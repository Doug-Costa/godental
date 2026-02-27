<?php
session_start();
require_once "../../funcoes/Conexao.php";
require_once (__DIR__."/../../filter-input.php");
require_once "../../funcoes/Key.php";
require_once "exe.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php print $nomesite; ?> - NOVO CADASTRO</title>
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slim.css">
	<link rel="icon" href="../img/favicon.png">
  </head>
  <body style="background-image:url(../img/bg.jpg);">
  <?php
  	$getUrl = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
	
	$setUrl = (!isset($getUrl) ? 'index' : $getUrl);
	$Url    = explode('/', $setUrl);
		if(file_exists($Url[0] . '.php')):

		require $Url[0] . '.php';
			else:
		require 'verificar_url.php';
	endif;
?>
<script language="JavaScript">
	window.onload = function() {
		document.addEventListener("contextmenu", function(e){
			e.preventDefault();
		}, false);
		document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
              // "I" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
              	disabledEvent(e);
              }
              // "J" key
              if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
              	disabledEvent(e);
              }
              // "S" key + macOS
              if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
              	disabledEvent(e);
              }
              // "U" key
              if (e.ctrlKey && e.keyCode == 85) {
              	disabledEvent(e);
              }
              // "F12" key
              if (event.keyCode == 123) {
              	disabledEvent(e);
              }
          }, false);
		function disabledEvent(e){
			if (e.stopPropagation){
				e.stopPropagation();
			} else if (window.event){
				window.event.cancelBubble = true;
			}
			e.preventDefault();
			return false;
		}
	};
</script>