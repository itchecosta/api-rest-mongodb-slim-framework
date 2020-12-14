<?php

namespace App\Models;

final class CidadeModel
{
    private $id;
    private $nome;
    private $estadoid;
    private $dt_inc;
    private $dt_alt;

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id): CidadeModel
    {
        $this->id = $id;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): CidadeModel
    {
        if (!$nome && !is_string($nome)) {
            throw new \InvalidArgumentException("Nome da cidade é obrigatório", 400);
            
        }

        $this->nome = $nome;
        return $this;
    }

    public function getEstadoid()
    {
        return $this->estadoid;
    }

    public function setEstadoid($estadoid): CidadeModel
    {
        if (!$estadoid && !is_string($estadoid)) {
            throw new \InvalidArgumentException("Informar o Estado é obrigatório", 400);
            
        }

        $this->estadoid = $estadoid;
        return $this;
    }

    public function getDtInc()
    {
        return $this->dt_inc;
    }

    public function setDtInc($dt_inc): CidadeModel
    {
        $this->dt_inc = $dt_inc;
        return $this;
    }

    public function getDtAlt()
    {
        return $this->dt_alt;
    }

    public function setDtAlt($dt_alt): CidadeModel
    {
        $this->dt_alt = $dt_alt;
        return $this;
    }
}