<?php
namespace App\Http\Controllers;


use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Cookie\CookieJar;

class RequestBonita {

  public static function doTheRequest($method, $uri, $data=null){
    $response = array();

    if (!Access::isLoggedIn()) {
      $logueo = Access::login();
      if (!$logueo) {
        $response["success"] = false;
        $response["mensaje"] = "No se pudo loguear";
        return $response;
      }
    }

    $client = Access::getGuzzleClient();


      //Si el m�todo es POST, hago el request con un header con la variable de sesion
      if ($method == 'POST'){
        $jar = new \GuzzleHttp\Cookie\CookieJar();
        $request = $client->request($method, $uri,
          ['headers' => ['X-Bonita-API-Token' => session('X-Bonita-API-Token')]]
        );
        $tareas = $request->getBody();
        $response['success'] = true;
        $response['data'] = json_decode($tareas);
      }elseif ($method == 'PUT'){
        $jar = new \GuzzleHttp\Cookie\CookieJar();
        $request = $client->request($method, $uri,
          ['headers' => [
              'X-Bonita-API-Token' => session('X-Bonita-API-Token')
            ],
            'json' => $data
          ]
        );
        $tareas = $request->getBody();
        $response['success'] = true;
        $response['data'] = json_decode($tareas);
      } else {
        $request = $client->request($method, $uri, ["timeout"=>100]);
        $tareas = $request->getBody();
        $response['success'] = true;
        $response['data'] = json_decode($tareas);
      }


    return $response;
  }
  //Si el metodo es GET, lo hago directamente.
}
