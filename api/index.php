<?php
// Força o diretório de trabalho para a raiz do projeto
chdir(dirname(__DIR__));

// Define a constante BASE para evitar falhas nos requires em subpastas
define('VERCEL_ENV', true);

// Carrega o index.php principal da raiz
require_once __DIR__ . '/../index.php';