<?php

require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../dao/UserDAO.php";
require_once __DIR__ . "/../utils/Utils.php";

class AuthMiddleware
{
  public static function check(): User
  {
    return self::getUser();
  }

  private static function getUser(): User
  {
    $tokenDecoded = AuthController::requireAuth();

    $userId = $tokenDecoded->data->id ?? null;

    if (!$userId) {
      $dataResponse = [
        "success" => false,
        "message" => "Token inválido. ID do utilizador não encontrado.",
        "data" => []
      ];

      Utils::jsonResponse($dataResponse, 401);
      exit;
    }

    $user = (new UserDAO())->findById((int)$userId);

    if (!$user) {
      $dataResponse = [
        "success" => false,
        "message" => "Utilizador não encontrado.",
        "data" => []
      ];

      Utils::jsonResponse($dataResponse, 401);
      exit;
    }

    return $user;
  }
}