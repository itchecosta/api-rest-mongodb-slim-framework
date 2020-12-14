<?php

namespace App\DAO;

use App\Models\CidadeModel;

class CidadesDAO extends Conexao
{
    public function __construct()
    {  
        parent::__construct();
        
    }

    public function getCidade($id)
    {
        $collection = $this->client->selectCollection('zoox','cidades');
        $cidade = $collection->findOne(['id' => $id]);

        return $cidade;
    }

    public function getAllCidades()
    {
        
        $collection = $this->client->selectCollection('zoox','cidades');
        $cidades = $collection->find();

        return $cidades;
    }

    public function insertCidade(CidadeModel $cidade)
    {
        $cidade->setId(substr(md5(uniqid(rand(), true)), 0, 5));
        $cidade->setDtInc(json_decode(json_encode(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'))),true));

        $collection = $this->client->selectCollection('zoox','cidades');
        
        $collection->insertOne([
            'id' => $cidade->getId(),
            'nome' => $cidade->getNome(),
            'estadoid' => $cidade->getEstadoid(),
            'dt_inc' => $cidade->getDtInc()
        ]);

    }

    public function updateCidade(CidadeModel $cidade)
    {
        $cidade->setDtAlt(json_decode(json_encode(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'))),true));

        $collection = $this->client->selectCollection('zoox','cidades');
        
        $collection->findOneAndUpdate(
            ['id' => $cidade->getId()],
            [
                '$set' => [
                'nome' => $cidade->getNome(),
                'estadoid' => $cidade->getEstadoid(),
                'dt_alt' => $cidade->getDtAlt()
                ]
            ]
        );
    }

    public function deleteCidade($id)
    {
        $collection = $this->client->selectCollection('zoox','cidades');
        $collection->deleteOne(['id' => $id]);
    }

}