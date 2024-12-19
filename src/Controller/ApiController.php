<?php
declare(strict_types=1);
namespace Juan\ApiService\Controller;

date_default_timezone_set('America/Bogota');
require_once APP_DIRECTORY.'\bootstrap.php';

use Juan\ApiService\Resources\Repository;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;

final class ApiController
{
    private Repository $repository; 
    private Request $request; 

    public function __construct(Request $request) 
    {
        $this->request = $request;
        $this->repository = new Repository();
    }

    public function makeToken(): Array
    {
        $generate = Uuid::uuid4();
        $token1 = $generate->toString();
        $generate_complete = Uuid::uuid4();
        $token2 = $generate_complete->toString();

        $this->saveLog($token1.$token2, '');
        return [ 'result' => 'Generado correctamente.', 'status' => 200, 'data' => $token1.$token2];
    }

    public function handleResponse(): Array
    {
        $data = $this->request->toArray();
        $query = $this->repository->saveUserData([
            'cli' => $data['documento'],
            'nam' => $data['nombre'],
        ]);
        if(is_array($query) && count($query) > 0){
            return [ 'result' => $query, 'status' => 200 ];
        } else {
            return [ 'result' => 'Ah ocurrido un error con la información.', 'status' => 400];
        }
    }

    public function getInformation(): Array
    {
        $data = $this->request->toArray();
        $query = $this->repository->GetUser([
            'cli' => $data['documento'],
        ]);
        if(is_array($query) && count($query) > 0){
            return [ 'result' => $query, 'status' => 200 ];
        } else {
            return [ 'result' => 'Ah ocurrido un error con la información.', 'status' => 400];
        }
    }

    public function saveLog($response, $params)
    {
        $archivo = APP_DIRECTORY.'\src\Assets\notes.txt';
        $fp = fopen($archivo, "a");
        fwrite($fp, PHP_EOL.strval(date('Y-m-d H:i:s')).'||'.strval($response) );
        fclose($fp);
    }
}

?>