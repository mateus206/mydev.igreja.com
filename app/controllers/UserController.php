<?php

require_once __DIR__ . "/../dao/UserDAO.php";
require_once __DIR__ . "/../config/jwt.php";

use Firebase\JWT\JWT;

class UserController
{
  private function view(string $name, array $data = []): void
  {
    extract($data, EXTR_SKIP);
    require __DIR__ . "/../../public/views/{$name}.php";
  }

  public function listprofileApi($userId){
    try{
        $user = (new UserDao())->findById($userId);
        $emailVerifications = (new UserDao())->getEmailVerifications($userId);
        $dataResponse = [
            'success'=>true,
            'message'=>"Operação realizada com sucesso",
            'data'=>[
                'user'=>$user->toArray(),
                'email_verifications'=>$emailVerifications
            ]
        ];
        utils::jsonResponse($dataResponse);
        exit;


    }catch(Exception $e){
        $dataResponse = [
            'success'=>false,
            'message'=>$e->getMessage(),
            'data'=>[]
        ];
        utils::jsonResponse($dataResponse,401);
        exit;
    }
  }

}