<?php

require_once __DIR__ . "/../dao/eventosDAO.php";
require_once __DIR__ . "/../utils/Utils.php";

class Eventoscontroller
{
    public function listApi(): void
    {
        try {
            $eventos = (new EventoDAO())->findAll();

            $data = array_map(function ($evento) {
                return $evento->toArray();
            }, $eventos);

            $dataResponse = [
                "success" => true,
                "message" => "Operação realizada com sucesso",
                "data" => [
                    "eventos" => $data
                ]
            ];

            Utils::jsonResponse($dataResponse);
            exit;

        } catch (Exception $e) {
            $dataResponse = [
                "success" => false,
                "message" => $e->getMessage(),
                "data" => []
            ];

            Utils::jsonResponse($dataResponse, 400);
            exit;
        }
    }
}
