<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use TECWEB\MYAPI\Create\Create;
use TECWEB\MYAPI\Read\Read;
use TECWEB\MYAPI\Update\Update;
use TECWEB\MYAPI\Delete\Delete;

require __DIR__ . '/myapi/vendor/autoload.php';

$app = AppFactory::create();

// Middleware para parsear el body en JSON
$app->addBodyParsingMiddleware();

// Middleware para manejar errores
$app->addErrorMiddleware(true, true, true);

// ==========================================
// RUTAS DEL API REST
// ==========================================

// GET - Obtener un producto por ID
// Ruta: backend/product/{id}
$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $read = new Read('marketzone');
    $read->single($id);
    
    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// GET - Listar todos los productos
// Ruta: backend/products
$app->get('/products', function (Request $request, Response $response) {
    $read = new Read('marketzone');
    $read->list();
    
    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// GET - Buscar productos
// Ruta: backend/products/{search}
$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $search = $args['search'];
    $read = new Read('marketzone');
    $read->search($search);
    
    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// POST - Agregar un producto
// Ruta: backend/product
$app->post('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $jsonOBJ = json_decode(json_encode($data));
    
    $create = new Create('marketzone');
    $create->add($jsonOBJ);
    
    $response->getBody()->write($create->getData());
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

// PUT - Editar un producto
// Ruta: backend/product
$app->put('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $jsonOBJ = json_decode(json_encode($data));
    
    $update = new Update('marketzone');
    $update->edit($jsonOBJ);
    
    $response->getBody()->write($update->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// DELETE - Eliminar un producto
// Ruta: backend/product
$app->delete('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $id = $data['id'];
    
    $delete = new Delete('marketzone');
    $delete->delete($id);
    
    $response->getBody()->write($delete->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>