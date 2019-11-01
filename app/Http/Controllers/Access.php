<?php

namespace App\Http\Controllers;

error_reporting(0);

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\CookieJar;


class Access
{
  private static $cookieJar;

  public static function getCookieJar() {
    if (!isset(self::$cookieJar)) {
        self::$cookieJar = new SessionCookieJar('MiCookie', true);
    }

    return self::$cookieJar;
  }

  public static function isLoggedIn(){
    if (session('logged')) {
      try {
        Access::getSessionInfo();
      } catch (RequestException $e) {
        if ($e->hasResponse()) {
          $error = Psr7\str($e->getResponse());
        }
        return false;
      }
      return true;
    }
    return false;
  }

  public static function getGuzzleClient(){
    $cookieJar = self::getCookieJar();//new SessionCookieJar('MiCookie', true);

    $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => session('base_uri_bonita'),
      // You can set any number of default request options.
      'timeout'  => 1.0,
      'cookies' => $cookieJar
    ]);

    return $client;
  }

  public static function login(){
    $user = "walter.bates";
    $password = "bpm";
    $base_uri = "http://localhost:8080/bonita/";

    try {
      //Creo una cookie jar para almacenar las cookies que me va a devolver Bonita luego del request del loginservice
      $cookieJar = self::getCookieJar();//new SessionCookieJar('MiCookie', true);
      $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $base_uri,
        // You can set any number of default request options.
        'timeout'  => 4.0,
        'cookies' => $cookieJar
      ]);
      $resp = $client->request('POST', 'loginservice', [
        'form_params' => [
          'username' => $user,
          'password' => $password,
          'redirect' => 'false'
        ]
      ]);

      //Almaceno el token de Bonita en una variable de sesion para utilizarla en los requests futuros
      $token = $cookieJar->getCookieByName('X-Bonita-API-Token');
      session(['X-Bonita-API-Token' => $token->getValue()]);
      //Luego de esto, tendr�as que ver la el archivo classes/Request.php
      //Ah� vas a ver que cuando se hace un request con POST se agrega un header con el token

      session(['user_bonita' => "walter.bates", 'password_bonita' => "bpm", 'base_uri_bonita' => "http://localhost:8080/bonita/", 'logged' => true]);

      return true;
    } catch (RequestException $e) {
      if ($e->hasResponse()) {
        $error = Psr7\str($e->getResponse());
      } else {
        $error = "No se puede conectar al servidor de Bonita OS";
      }

      return false;
    }
  }

  public static function getSessionInfo(){
    $client = Access::getGuzzleClient();
    $response = $client->request('GET', 'API/system/session/unusedid');
    $info = $response->getBody();
    return json_decode($info);
  }

  /*
  public static function getUserLogged(){
    $info = Access::getSessionInfo();
    return Users::getUserUsername($info->user_id);
  }
  */
}
