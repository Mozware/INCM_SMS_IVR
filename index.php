<?php

// Inclui o autoload do Composer
require __DIR__ . '/vendor/autoload.php';

// Usando a fábrica do Slim para criar a aplicação
use Slim\Factory\AppFactory;
$app = AppFactory::create();

// Definir o Base Path da aplicação (caso esteja em subdiretório)
$basePath = str_replace('/' . basename(__FILE__), '', $_SERVER['SCRIPT_NAME']);
$app = $app->setBasePath($basePath);

// Definir as rotas
require __DIR__ . '/src/routes/user.php';
require __DIR__ . '/src/routes/pages.php';

// Executar a aplicação
$app->run();
