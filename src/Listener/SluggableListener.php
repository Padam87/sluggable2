<?php
/**
 * Created by IntelliJ IDEA.
 * User: _Adam_
 * Date: 2019. 03. 18.
 * Time: 1:02
 */

namespace App\Listener;


use App\Annotation\Sluggable;
use App\Metadata\ExtendedClassMetadata;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PropertyAccess\PropertyAccess;

class SluggableListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->updateSlug($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->updateSlug($args);
    }

    private function updateSlug(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        /** @var ExtendedClassMetadata $metadata */
        $metadata = $args->getEntityManager()->getClassMetadata(get_class($entity));

        if (null !== $sluggable = $metadata->getExtensionMetadata(Sluggable::class)) {
            $accessor = PropertyAccess::createPropertyAccessor();

            /**
             * @var string $name
             * @var Sluggable $annotation
             */
            foreach ($sluggable['fields'] as $name => $annotation) {
                $slug = call_user_func($annotation->callback, $entity, $annotation->fields, $annotation->separator);
                $accessor->setValue($entity, $name, $slug);
            }
        }
    }
}
