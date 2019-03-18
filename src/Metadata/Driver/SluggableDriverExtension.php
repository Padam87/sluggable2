<?php
/**
 * Created by IntelliJ IDEA.
 * User: _Adam_
 * Date: 2019. 03. 18.
 * Time: 1:35
 */

namespace App\Metadata\Driver;

use App\Annotation\Sluggable;
use App\Metadata\ExtendedClassMetadata;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;

class SluggableDriverExtension implements AnnotationDriverExtensionInterface
{
    public function loadMetadataForClass(Reader $reader, $className, ClassMetadata $metadata)
    {
        /* @var $metadata ExtendedClassMetadata */

        $refl = new \ReflectionClass($className);

        foreach ($refl->getProperties() as $property) {
            $field = $property->getName();

            if (null === $annotation = $reader->getPropertyAnnotation($property, Sluggable::class)) {
                continue;
            }

            $metadata->addExtensionFieldMetadata(Sluggable::class, $field, $annotation);
        }
    }
}
