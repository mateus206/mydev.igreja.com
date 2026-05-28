<?php

require_once __DIR__ . "/../dao/UserDAO.php";
require_once __DIR__ . "/../utils/Utils.php";

class UserController
{
    public function listprofileApi($userId)
    {
        try {
            $user = (new UserDAO())->findById($userId);

            if (!$user) {
                $dataResponse = [
                    'success' => false,
                    'message' => "Utilizador não encontrado.",
                    'data' => []
                ];

                Utils::jsonResponse($dataResponse, 404);
                exit;
            }

            $emailVerifications = (new UserDAO())->getEmailVerifications($userId);

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data' => [
                    'user' => $user->toArray(),
                    'email_verifications' => $emailVerifications
                ]
            ];

            Utils::jsonResponse($dataResponse);
            exit;

        } catch (Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            Utils::jsonResponse($dataResponse, 401);
            exit;
        }
    }
}