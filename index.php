<?php

require_once 'bootstrap.php';

$test = new \App\Entity\Test();

$test
    ->setName('Hello, this is a test.')
;

$em->persist($test);
$em->flush();


echo $test->getSlug();
