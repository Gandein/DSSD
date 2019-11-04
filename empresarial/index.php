<?php
namespace Monitor;

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require './vendor/autoload.php';

session_start();

if(!isset($_GET["action"])){
  header("Location: ?action=login");
  exit();
}

if (!Access::isLoggedIn() && $_GET["action"] != 'login' && $_GET["action"] != 'loguear') {
  View::showLogin();
  exit();
}

if (Access::isLoggedIn() && $_GET["action"] == 'login') {
  header("Location: ?action=inicio");
  exit();
}

switch ($_GET["action"]) {
  case 'loguear':
    Access::login();
    break;
  case 'inicio':
    InicioController::inicio();
    break;
  default:
    // code...
    break;
}
