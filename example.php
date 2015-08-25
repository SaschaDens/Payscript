<?php
require_once "vendor/autoload.php";

$sales = new Saschadens\Payscript\Sales();

$htmlFormatter = new Saschadens\Payscript\HtmlFormatter;
$jsonFormatter = new Saschadens\Payscript\JsonFormatter;

echo "<h2>HTML Format</h2>";
var_dump($sales->format($htmlFormatter));
echo "<h2>JSON Format</h2>";
var_dump($sales->format($jsonFormatter));