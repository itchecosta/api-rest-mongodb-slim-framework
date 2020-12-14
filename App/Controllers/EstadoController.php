<?php

namespace App\Controllers;

use App\DAO\EstadosDAO;
use App\Exceptions\AppException;
use App\Models\EstadoModel;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use function src\log;

final class EstadoController
{
    public function getEstados(Request $request, Response $response, array $args): Response
    {
        try {
            $estadosDAO = new EstadosDAO();
        
            if ($args['id']) {
                $results = $estadosDAO->getEstado($args['id']);

                if (!$results) {
                    throw new AppException("Estado não encontrado!",404);
                }

            } else {
                $estados = $estadosDAO->getAllEstados();

                $results = array();

                foreach ($estados as $estado) {
                    $results[] = $estado;
                }

                if (!$results) {
                    throw new AppException("Não existem estados cadastrados no sistema!",400);
                }
            }

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode($results, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        } catch (AppException $ex) {
            return $response->withStatus($ex->getCode())
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => AppException::class,
                                'status' => $ex->getCode(),
                                'code' => '003',
                                'userMessage' => 'Verifique os dados novamente.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\InvalidArgumentException $ex) {
            return $response->withStatus(400)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 400,
                                'code' => '002',
                                'userMessage' => 'Tente novamente mais tarde!',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\Exception | \Throwable $ex) {
            return $response->withStatus(500)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 500,
                                'code' => '001',
                                'userMessage' => 'Erro na aplicação, entre em contato com o administrador.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
        
    }

    public function insertEstados(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $estadosDAO = new EstadosDAO();
            $estado = new EstadoModel();
            $estado->setNome($data['nome'])
                    ->setUf($data['uf']);
            $estadosDAO->insertEstado($estado);

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode(["message" => "Estado inserido com sucesso!"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        } catch (\InvalidArgumentException $ex) {
            return $response->withStatus(400)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 400,
                                'code' => '002',
                                'userMessage' => 'Verifique os dados novamente.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\Exception | \Throwable $ex) {
            return $response->withStatus(500)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 500,
                                'code' => '001',
                                'userMessage' => 'Erro na aplicação, entre em contato com o administrador.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    }

    public function updateEstados(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $estadosDAO = new EstadosDAO();

            $estadoAux = $estadosDAO->getEstado($data['id']);

            if(!$estadoAux){
                throw new AppException("Estado não encontrado!", 404);
            }

            $estado = new EstadoModel();
            $estado->setId($data['id'])
                    ->setNome($data['nome'])
                    ->setUf($data['uf']);
            $estadosDAO->updateEstado($estado);

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode(["message" => "Estado alterado com sucesso!"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        } catch (AppException $ex) {
            return $response->withStatus($ex->getCode())
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => AppException::class,
                                'status' => $ex->getCode(),
                                'code' => '003',
                                'userMessage' => 'Verifique os dados novamente.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\InvalidArgumentException $ex) {
            return $response->withStatus(400)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 400,
                                'code' => '002',
                                'userMessage' => 'Verifique os dados novamente.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\Exception | \Throwable $ex) {
            return $response->withStatus(500)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 500,
                                'code' => '001',
                                'userMessage' => 'Erro na aplicação, entre em contato com o administrador.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    }

    public function deleteEstados(Request $request, Response $response, array $args): Response
    {

        try {
            $estadosDAO = new EstadosDAO();
        
            $estado = $estadosDAO->getEstado($args['id']);

            if(!$estado){
                throw new AppException("Estado não encontrado!", 404);
                
            }

            $estadosDAO->deleteEstado($args['id']);

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode(["message" => "Estado deletado com sucesso!"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        } catch (AppException $ex) {
            return $response->withStatus($ex->getCode())
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => AppException::class,
                                'status' => $ex->getCode(),
                                'code' => '003',
                                'userMessage' => 'Verifique os dados novamente.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\InvalidArgumentException $ex) {
            return $response->withStatus(400)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 400,
                                'code' => '002',
                                'userMessage' => 'Tente novamente mais tarde!',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        } catch (\Exception | \Throwable $ex) {
            return $response->withStatus(500)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode([
                                'error' => \Exception::class,
                                'status' => 500,
                                'code' => '001',
                                'userMessage' => 'Erro na aplicação, entre em contato com o administrador.',
                                'developerMessage' => $ex->getMessage()
                            ], 
                            JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }
    }
}