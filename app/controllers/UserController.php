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

    public function updatePasswordApi($userId)
    {
        try {
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            // Aceita JSON (API/mobile) e também form-data/x-www-form-urlencoded.
            if (!is_array($data)) {
                $data = $_POST;
            }

            $currentPassword = $data["current_password"] ?? null;
            $newPassword = $data["new_password"] ?? null;

            if (!$currentPassword || !$newPassword) {
                throw new Exception("current_password e new_password são obrigatórios");
            }

            if (strlen($newPassword) < 6) {
                throw new Exception("A nova password deve ter pelo menos 6 caracteres");
            }

            $userDao = new UserDAO();
            $user = $userDao->findById((int)$userId);

            if (!$user) {
                throw new Exception("Utilizador não encontrado");
            }

            if (!password_verify($currentPassword, $user->getPassword())) {
                throw new Exception("Password atual inválida");
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $userDao->updatePasswordById((int)$userId, $hashedPassword);

            $dataResponse = [
                "success" => true,
                "message" => "Password atualizada com sucesso",
                "data" => []
            ];

            Utils::jsonResponse($dataResponse);
            exit;

        } catch (Exception $e) {
            $dataResponse = [
                "success" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];

            Utils::jsonResponse($dataResponse, 401);
            exit;
        }
    }

}