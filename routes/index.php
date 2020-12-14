<?php

use function src\{
    config,
    basicAuth,
    tokenAuth};
use App\Controllers\{
    EstadoController,
    CidadeController};
use App\DAO\CidadesDAO;
use Psr7Middlewares\Middleware\TrailingSlash;
use Firebase\JWT\JWT;
use src\Page;

$app = new \Slim\App(config());

// ********************************

$app->add(new TrailingSlash(false));
//..

/**
 * HTTP Auth - Autenticação minimalista para retornar um JWT
 */
$app->get('/auth', function ($request, $response) use ($app) {

    $key = getenv('JWT_SECRET_KEY');

    $token = array(
        "user" => "@itchecosta",
        "linkedin" => "https://linkedin.com/in/itchecosta",
        "github" => "https://github.com/itchecosta"
    );

    $jwt = JWT::encode($token, $key);

    return $response->withJson(["auth-jwt" => $jwt], 200)
                    ->withHeader('Content-type', 'application/json');   
});

$app->get('/lista', function(){
    $cidades = new CidadesDAO();
    $lista = $cidades->getAllCidades();
    $page = new Page();
    $page->setTpl("lista",['cidades' => ($lista)]);

});


$app->group('', function() use ($app) {
    $app->get('/estado[/{id}]', EstadoController::class.":getEstados");
    $app->post('/estado', EstadoController::class.":insertEstados");
    $app->put('/estado', EstadoController::class.":updateEstados");
    $app->delete('/estado/{id}', EstadoController::class.":deleteEstados");

    $app->get('/cidade[/{id}]', CidadeController::class.":getCidades");
    $app->post('/cidade', CidadeController::class.":insertCidades");
    $app->put('/cidade', CidadeController::class.":updateCidades");
    $app->delete('/cidade/{id}', CidadeController::class.":deleteCidades");
})->add(tokenAuth());

// *******************************

$app->run();