<?php

namespace App\Metadata;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataFactory;

class ExtendedClassMetadataFactory extends ClassMetadataFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->entityManager = $em;

        parent::setEntityManager($em);
    }

    /**
     * {@inheritDoc}
     */
    protected function newClassMetadataInstance($className)
    {
        return new ExtendedClassMetadata($className, $this->entityManager->getConfiguration()->getNamingStrategy());
    }
}
