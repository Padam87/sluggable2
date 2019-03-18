<?php

namespace App\Metadata\Driver;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

class AnnotationDriver extends \Doctrine\ORM\Mapping\Driver\AnnotationDriver
{
    /**
     * @var AnnotationDriverExtensionInterface[]
     */
    private $extensions = [];

    public function addExtension(AnnotationDriverExtensionInterface $annotationDriverExtension)
    {
        $this->extensions[] = $annotationDriverExtension;
    }

    public function loadMetadataForClass($className, ClassMetadata $metadata)
    {
        /* @var $metadata \Doctrine\ORM\Mapping\ClassMetadataInfo */

        parent::loadMetadataForClass($className, $metadata);

        foreach ($this->extensions as $extension) {
            $extension->loadMetadataForClass($this->reader, $className, $metadata);
        }
    }
}
