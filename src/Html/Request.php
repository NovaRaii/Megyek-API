<?php
 
namespace App\Html;
 
use App\Repositories\CountyRepository;
 
class Request {
 
    static function handle(): void {
        switch ($_SERVER["REQUEST_METHOD"]){
            case "POST":
                self::postRequest();
                break;
            case "GET":
                self::getRequest();
                break;
            case "PUT":
                self::putRequest();
                break;
            case "DELETE":
                self::deleteRequest();
                break;
            default:
                echo 'Unknown request type';
                break;
        }
    }
 
    private static function getRequest(): void
    {
        $resourceName = self::getResourceName();
        switch ($resourceName){
            case 'counties':
                $db = new CountyRepository();
                $resourceId = self::getResourceId();
                $code = 200;
                if($resourceId){
                    $entity = $db->find($resourceId);
                    Response::response($entity, $code);
                    break;
                }
 
                $enteties = $db->getAll();
                if(empty($enteties)){
                    $code = 404;
                }
                Response::response($enteties, $code);
                break;
 
            default:
                Response::response([], 404,  $_SERVER['REQUEST_URI'] . " not found");
        }
    }
 

    private static function getArrUri(string $requestUri): ?array
        {
            return explode("/", $requestUri) ?? null;
        }
        
        private static function getResourceName(): string
        {
            $arrUri = self::getArrUri($_SERVER['REQUEST_URI']);
            $result = $arrUri[count($arrUri) - 1];
            if(is_numeric($result))
            {
                $result = $arrUri[count($arrUri) - 2];
            }

            return $result;
        }

        private static function getResourceId(): int
        {
            $arrUri = self::getArrUri($_SERVER['REQUEST_URI']);
            $result = 0;
            if(is_numeric($arrUri[count($arrUri) - 1]))
            {
                $result = $arrUri[count($arrUri) - 1];
            }
            return $result;
        }

        private static function deleteRequest(){
            $resourceName = self::getResourceName();
            $resourceId = self::getResourceId();
        switch ($resourceName){
            case 'counties':
                $db = new CountyRepository();
                if($resourceId){
                    $entity = $db->find($resourceId);
                    if ($entity) {
                        $db->delete($resourceId);
                        Response::response([],204);

                    }
                    else {
                        Response::response([], 404, $_SERVER['REQUEST_URI'] . " not found");
                    }
                    break;
                default:
                Response::response([], 404, $_SERVER['REQUEST_URI'] . " not found");
                }
        }
    }
 
        }
}
 
 
?>
