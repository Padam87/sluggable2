<?php
// bootstrap.php
use App\Metadata\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$paths = array(__DIR__."/src/Entity/");

\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(__DIR__ . '/src/Annotation/Sluggable.php');
\Doctrine\Common\Annotations\AnnotationRegistry::registerFile(__DIR__ . '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

$driver = new AnnotationDriver(
    new CachedReader(new AnnotationReader(), new ArrayCache()),
    $paths
);

$driver->addExtension(new \App\Metadata\Driver\SluggableDriverExtension());

$config = Setup::createConfiguration($isDevMode, null, null);
$config->setMetadataDriverImpl($driver);
$config->setClassMetadataFactoryName(\App\Metadata\ExtendedClassMetadataFactory::class);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

// obtaining the entity manager
$em = EntityManager::create($conn, $config);
$em->getEventManager()->addEventSubscriber(new \App\Listener\SluggableListener());
