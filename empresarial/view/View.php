<?php
namespace Monitor;

class View extends TwigView {

  public static function showLogin() {
    echo self::getTwig()->render('login.twig');
  }

  public static function showInicio($data)
  {
    echo self::getTwig()->render('inicio.twig', $data);
  }

  public static function jsonEncode($data){
    echo json_encode($data);
  }

}
