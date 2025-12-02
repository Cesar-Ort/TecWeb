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

// Configurar la ruta base según tu estructura de carpetas
// Basado en tu URL: localhost/tecweb/practicas/act09/product_app/backend/
$app->setBasePath('/tecweb/practicas/act09/product_app/backend');

// Middleware para parsear el body en JSON
$app->addBodyParsingMiddleware();

// Middleware para manejar errores
$app->addErrorMiddleware(true, true, true);

// Middleware para CORS (opcional, útil para desarrollo)
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// ==========================================
// RUTAS DEL API REST
// ==========================================

// GET - Obtener un producto por ID
// Ruta: /product/{id}
$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $read = new Read('marketzone');
    $read->single($id);
    
    $response->getBody()->write($read->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// GET - Listar todos los productos
// Ruta: /products
$app->get('/products', function (Request $request, Response $response) {
    $read = new Read('marketzone');
    $read->list();
    
    $response->getBody()->write($read->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// GET - Buscar productos
// Ruta: /products/{search}
$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $search = $args['search'];
    $read = new Read('marketzone');
    $read->search($search);
    
    $response->getBody()->write($read->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// POST - Agregar un producto
// Ruta: /product
$app->post('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $jsonOBJ = json_decode(json_encode($data));
    
    $create = new Create('marketzone');
    $create->add($jsonOBJ);
    
    $response->getBody()->write($create->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
});

// PUT - Editar un producto
// Ruta: /product
$app->put('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $jsonOBJ = json_decode(json_encode($data));
    
    $update = new Update('marketzone');
    $update->edit($jsonOBJ);
    
    $response->getBody()->write($update->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// DELETE - Eliminar un producto
// Ruta: /product
$app->delete('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    // Verificar si el ID viene en el body
    if (isset($data['id'])) {
        $id = $data['id'];
    } else {
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => 'ID no proporcionado'
        ]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(400);
    }
    
    $delete = new Delete('marketzone');
    $delete->delete($id);
    
    $response->getBody()->write($delete->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

// Ruta de prueba (opcional)
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode([
        'message' => 'API REST de Productos funcionando correctamente',
        'endpoints' => [
            'GET /product/{id}' => 'Obtener un producto por ID',
            'GET /products' => 'Listar todos los productos',
            'GET /products/{search}' => 'Buscar productos',
            'POST /product' => 'Agregar un producto',
            'PUT /product' => 'Editar un producto',
            'DELETE /product' => 'Eliminar un producto'
        ]
    ]));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->run();
?>