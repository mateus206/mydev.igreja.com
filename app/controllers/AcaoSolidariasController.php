<?php

require_once __DIR__ . "/../dao/acaosolidariasDAO.php";
require_once __DIR__ . "/../utils/Utils.php";

class AcaoSolidariascontroller
{
    public function listApi(): void
    {
        try {
            $acoesSolidarias = (new AcaoSolidariaDAO())->findAll();

            $data = array_map(function ($acao) {
                return $acao->toArray();
            }, $acoesSolidarias);

            $dataResponse = [
                "success" => true,
                "message" => "Operação realizada com sucesso",
                "data" => [
                    "acoes_solidarias" => $data
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