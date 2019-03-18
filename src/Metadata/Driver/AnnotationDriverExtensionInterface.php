<?php
/**
 * Created by IntelliJ IDEA.
 * User: _Adam_
 * Date: 2019. 03. 18.
 * Time: 1:29
 */

namespace App\Metadata\Driver;


use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;

interface AnnotationDriverExtensionInterface
{
    public function loadMetadataForClass(Reader $reader, $className, ClassMetadata $metadata);
}
