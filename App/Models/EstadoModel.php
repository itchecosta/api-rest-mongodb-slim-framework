<?php

namespace App\Models;

final class EstadoModel
{
    private $id;
    private $nome;
    private $uf;
    private $dt_inc;
    private $dt_alt;

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id): EstadoModel
    {
        if (!$id && !is_string($id)) {
            throw new \InvalidArgumentException("Código identificador do Estado é obrigatório", 400);
            
        }

        $this->id = $id;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): EstadoModel
    {
        if (!$nome && !is_string($nome)) {
            throw new \InvalidArgumentException("Nome do Estado é obrigatório", 400);
            
        }

        $this->nome = $nome;
        return $this;
    }

    public function getUf()
    {
        return $this->uf;
    }

    public function setUf($uf): EstadoModel
    {
        if (!$uf && !is_string($uf)) {
            throw new \InvalidArgumentException("Abreviação do Estado é obrigatório", 400);
            
        }

        $this->uf = $uf;
        return $this;
    }

    public function getDtInc()
    {
        return $this->dt_inc;
    }

    public function setDtInc($dt_inc): EstadoModel
    {
        $this->dt_inc = $dt_inc;
        return $this;
    }

    public function getDtAlt()
    {
        return $this->dt_alt;
    }

    public function setDtAlt($dt_alt): EstadoModel
    {
        $this->dt_alt = $dt_alt;
        return $this;
    }
}