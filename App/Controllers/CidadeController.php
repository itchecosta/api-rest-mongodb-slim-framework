<?php

namespace App\Controllers;

use App\DAO\CidadesDAO;
use App\Exceptions\AppException;
use App\Models\CidadeModel;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class CidadeController
{
    public function getCidades(Request $request, Response $response, array $args): Response
    {
        try {
            $cidadesDAO = new CidadesDAO();
            
            if ($args['id']) {
                $results = $cidadesDAO->getCidade($args['id']);

                if (!$results) {
                    throw new AppException("Cidade não encontrada!",404);
                }

            } else {
                $cidades = $cidadesDAO->getAllCidades();

                $results = array();

                foreach ($cidades as $cidade) {
                    $results[] = $cidade;
                }

                if (!$results) {
                    throw new AppException("Não existem cidades cadastradas no sistema!",400);
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

    public function insertCidades(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $cidadesDAO = new CidadesDAO();
            $cidade = new CidadeModel();
            $cidade->setNome($data['nome'])
                    ->setEstadoid($data['estadoid']);
            $cidadesDAO->insertCidade($cidade);

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode(["message" => "Cidade inserida com sucesso!"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

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

    public function updateCidades(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();

            $cidadesDAO = new CidadesDAO();
            $cidade = new CidadeModel();
            $cidade->setId($data['id'])
                    ->setNome($data['nome'])
                    ->setEstadoid($data['estadoid']);
            $cidadesDAO->updateCidade($cidade);

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode(["message" => "Cidade alterada com sucesso!"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

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

    public function deleteCidades(Request $request, Response $response, array $args): Response
    {

        try {
            $cidadesDAO = new CidadesDAO();
        
            $cidadesDAO->deleteCidade($args['id']);

            return $response->withStatus(200)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode(["message" => "Cidade deletada com sucesso!"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

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