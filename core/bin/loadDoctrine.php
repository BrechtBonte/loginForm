<?php
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

$docConf = new Configuration();
$driverImpl = $docConf->newDefaultAnnotationDriver($config->path->entities);
$docConf->setMetadataDriverImpl($driverImpl);
$docConf->setProxyDir($config->path->proxies);
$docConf->setProxyNamespace('LoginForm\Proxies');
$docConf->setAutoGenerateProxyClasses(true);

$connectionOptions = array(
    'driver'    => $config->database->driver,
    'host'      => $config->database->host,
    'user'      => $config->database->user,
    'password'  => $config->database->pass,
    'dbname'    => $config->database->name
);

return EntityManager::create($connectionOptions, $docConf);