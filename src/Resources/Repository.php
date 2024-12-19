<?php
declare(strict_types=1);
namespace Juan\ApiService\Resources;
require_once APP_DIRECTORY.'\bootstrap.php';
require_once APP_DIRECTORY.'\config\conection.php';

use Conn;

final class Repository
{
    private $conn;

    public function __construct()
    {
        //$this->conn = new Conn('base'); //database name to connect
    }

    private function validParams($params){
        foreach ($params as $key => $value) {
            if (strpos(strval($value), '=') || strpos(strval($value), '{') || strpos(strval($value), ';')) {
                $params = [];
                break;
            }
        }
        return $params;
    }

    public function saveUserData(Array $params){
        $sql = "INSERT INTO users VALUES ( :cli, :nam, default) RETURNING *";
        $params = $this->validParams($params);
        if(is_array($params)){
            // $query = $this->conn->sql($sql, $params);
            $query = [ //test
                "document" => $params['cli'], 
                "name" => $params['nam'], 
                "creted_at" => date('Y-m-d H:i:s')
            ];
            if(is_array($query)){
                return $query;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function GetUser(Array $params){
        $sql = "SELECT document, name, creted_at FROM users WHERE document = :cli";
        $params = $this->validParams($params);
        if(is_array($params)){
            // $query = $this->conn->sql($sql, $params);
            $query = [ //test
                "document" => $params['cli'], 
                "name" => 'Usuario correcto', 
                "creted_at" => date('Y-m-d H:i:s')
            ];
            if(is_array($query)){
                return $query;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}

?>