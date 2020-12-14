<?php

namespace App\DAO;

use App\Models\EstadoModel;

class EstadosDAO extends Conexao
{
    public function __construct()
    {  
        parent::__construct();
        
    }

    public function getEstado($id)
    {
        $collection = $this->client->selectCollection('zoox','estados');
        $estado = $collection->findOne(['id' => $id]);

        return $estado;
    }

    public function getAllEstados()
    {
        
        $collection = $this->client->selectCollection('zoox','estados');
        $estados = $collection->find();

        return $estados;
    }

    public function insertEstado(EstadoModel $estado)
    {
        $estado->setId(substr(md5(uniqid(rand(), true)), 0, 5));
        $estado->setDtInc(json_decode(json_encode(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'))),true));

        $collection = $this->client->selectCollection('zoox','estados');
        
        $collection->insertOne([
            'id' => $estado->getId(),
            'nome' => $estado->getNome(),
            'uf' => $estado->getUf(),
            'dt_inc' => $estado->getDtInc()
        ]);

    }

    public function updateEstado(EstadoModel $estado)
    {
        $estado->setDtAlt(json_decode(json_encode(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'))),true));

        $collection = $this->client->selectCollection('zoox','estados');
        
        $collection->findOneAndUpdate(
            ['id' => $estado->getId()],
            [
                '$set' => [
                'nome' => $estado->getNome(),
                'uf' => $estado->getUf(),
                'dt_alt' => $estado->getDtAlt()
                ]
            ]
        );
    }

    public function deleteEstado($id)
    {
        $collection = $this->client->selectCollection('zoox','estados');
        $collection->deleteOne(['id' => $id]);
    }
}