<?php
namespace Monitor;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\CookieJar;


class Access
{

  public static function isLoggedIn(){
    if (isset($_SESSION['logged'])) {
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
    $cookieJar = new SessionCookieJar('MiCookie', true);

    $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => $_SESSION['base_uri_bonita'],
      // You can set any number of default request options.
      'timeout'  => 1.0,
      'cookies' => $cookieJar
    ]);

    return $client;
  }

  public static function login(){
    $user = $_POST['user'];
    $password = $_POST['password'];
    $base_uri = $_POST['host'];

    try {
      //Creo una cookie jar para almacenar las cookies que me va a devolver Bonita luego del request del loginservice
      $cookieJar = new SessionCookieJar('MiCookie', true);
      $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $base_uri,
        // You can set any number of default request options.
        'timeout'  => 4.0,
        'cookies' => $cookieJar
      ]);
      $cliente =$client;
      //$_SESSION['client'] = $client;
      $resp = $client->request('POST', 'loginservice', [
        'form_params' => [
          'username' => $user,
          'password' => $password,
          'redirect' => 'false'
        ]
      ]);

      //Almaceno el token de Bonita en una variable de sesion para utilizarla en los requests futuros
      $token = $cookieJar->getCookieByName('X-Bonita-API-Token');
      $_SESSION['X-Bonita-API-Token'] = $token->getValue();
      //Luego de esto, tendr�as que ver la el archivo classes/Request.php
      //Ah� vas a ver que cuando se hace un request con POST se agrega un header con el token

      $_SESSION['user_bonita']= $_POST['user'];
      $_SESSION['password_bonita']= $_POST['password'];
      $_SESSION['base_uri_bonita']= $_POST['host'];
      $_SESSION['logged'] = true;

      View::jsonEncode(["success" => true]);
    } catch (RequestException $e) {
      if ($e->hasResponse()) {
        $error = Psr7\str($e->getResponse());
      } else {
        $error = "No se puede conectar al servidor de Bonita OS";
      }

      View::jsonEncode(["success"=> false, "mensaje" => $error]);
    }
  }
public static function devolverCliente(){
return $cliente;

}
  public static function getSessionInfo(){
    $client = Access::getGuzzleClient();
    $response = $client->request('GET', 'API/system/session/unusedid');
    $info = $response->getBody();
    return json_decode($info);
  }

  public static function getUserLogged(){
    $info = Access::getSessionInfo();
    return Users::getUserUsername($info->user_id);
  }
}
