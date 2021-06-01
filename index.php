<?php
declare(strict_types=1);

require 'vendor/autoload.php';
use Avast\XmlParser\util\RedisService;
use Avast\XmlParser\util\XmlParser;

if (count($argv) <= 1) {
    echo "Path to xml file is missing!\n";
}

$xmlFilePath = $argv[1];
$verbose = $argv[1] == '-v';

if ($verbose) {
    $xmlFilePath = $argv[2];
}

try {
    $xmlParser = new XmlParser($xmlFilePath);
    $redis = new RedisService([
        'host' => $_ENV['REDIS_HOST'],
        'port' => $_ENV['REDIS_PORT'],
        'persistence' => $_ENV['REDIS_PERSISTENCE']
    ]);

} catch (Exception $e) {
    print $e->getMessage();
    exit;
}

$parseCallback = function($node) use ($redis, $verbose) {
    $redis->set($node);
    // output
    if ($verbose) print "{$node->getAttributes()}\n";
};

$subdomains = $xmlParser->findKey('subdomains:subdomain')->parseArray($parseCallback, ['name' => 'subdomains']);
$cookies = $xmlParser->findKey('cookies:cookie')->parse($parseCallback);
