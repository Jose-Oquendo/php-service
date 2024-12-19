<?php
declare(Strict_types=1);
namespace Juan\ApiService\View;

use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Juan\ApiService\Controller\ApiController;

final class RoutesAction
{
    private ApiController $api;

    public function __construct(){}

    public function login(Request $request){
        if($_SERVER['REQUEST_URI'] == '/services/servicioApi/app/v01/login'){
            $this->api = new ApiController($request);
            if($request->getMethod() === 'POST'){
                $valid_user = $request->headers->get('consumer') == $_ENV['USER_FLAG'];
                if($valid_user){
                    $funcion = $this->api->makeToken();
                    if($funcion['status'] == 200){
                        return $funcion;
                    } else {
                        return [ 'result' => 'No answer found', 'status' => 200 ];
                    }
                } else {
                    return [ 'result' => 'Route not available', 'status' => 401 ];
                } 
            } else {
                return [ 'result' => 'Method not allowed', 'status' => 405 ];
            }
        } else {
            return [];
        }   
    }

    public function hook(Request $request){
        if($_SERVER['REQUEST_URI'] == '/services/servicioApi/app/v01/action'){
            $this->api = new ApiController($request);
            if($request->getMethod() === 'POST'){
                $validation = strpos($_SERVER['HTTP_AUTHORIZATION'], $_ENV['API_KEY']);
                $valid_user = $request->headers->get('consumer') == $_ENV['USER_FLAG'];
                if($validation){
                    if($valid_user){
                        if(count($request->toArray()) >= 2){
                            $funcion = $this->api->handleResponse();
                            return $funcion;
                        } else {
                            return [ 'result' => 'Required data', 'status' => 401 ];
                        }
                    } else {
                        return [ 'result' => 'Unspecified or unauthorized consumer.', 'status' => 401 ];
                    } 
                } else {
                    return [ 'result' => 'Key not supported.', 'status' => 401 ];
                } 
            } else {
                return [ 'result' => 'Method not allowed', 'status' => 405 ];
            }
        } else {
            return [];
        }   
    }

    public function handle(Request $request){
        if($_SERVER['REQUEST_URI'] == '/services/servicioApi/app/v01/send'){
            $this->api = new ApiController($request);
            if($request->getMethod() === 'POST'){
                $valid_user = $request->headers->get('consumer') == $_ENV['USER_FLAG'];
                if($valid_user){
                    $funcion = $this->api->getInformation();
                    if($funcion['status'] == 200){
                        return $funcion;
                    } else {
                        return [ 'result' => 'No answer found', 'status' => 200 ];
                    }
                } else {
                    return [ 'result' => 'Route not available', 'status' => 401 ];
                } 
            } else {
                return [ 'result' => 'Method not allowed', 'status' => 405 ];
            }
        } else {
            return [];
        }   
    }

}

?>