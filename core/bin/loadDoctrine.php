<?php
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

$docConf = new Configuration();
$driverImpl = $docConf->newDefaultAnnotationDriver($config->path->entities);
$docConf->setMetadataDriverImpl($driverImpl);
$docConf->setProxyDir($config->path->proxies);
$docConf->setProxyNamespace('LoginForm\Proxies');
$docConf->setAutoGenerateProxyClasses($config->doctrine->genProxies);

$connectionOptions = $config->database->toArray();

return EntityManager::create($connectionOptions, $docConf);