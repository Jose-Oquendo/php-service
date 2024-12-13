<?php
//cargar vendor autoload
require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;

$dotoenv = new Dotenv();
$dotoenv->load(path: __DIR__.'/.env');