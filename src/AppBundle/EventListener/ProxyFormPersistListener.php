<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AppBundle\EventListener;

use AppBundle\Entity\Proxy;
use Clastic\NodeBundle\Event\NodeFormPersistEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * NodeListener.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ProxyFormPersistListener implements EventSubscriberInterface
{
    private $original;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            NodeFormPersistEvent::NODE_FORM_PERSIST => 'persist',
            FormEvents::PRE_SUBMIT => 'prePersist',
        );
    }

    public function prePersist(FormEvent $event)
    {
        /** @var Proxy $data */
        $data = $event->getForm()->getData();
        $this->original = new ArrayCollection();

        foreach ($data->getDomains() as $domain) {
            $this->original->add($domain);
        }

    }

    /**
     * @param NodeFormPersistEvent $event
     *
     * @throws \Exception
     */
    public function persist(NodeFormPersistEvent $event)
    {
        /** @var Proxy $data */
        $data = $event->getForm()->getData();
        $em = $event->getEntityManager();

        // remove the relationship between the tag and the Task
        foreach ($this->original as $domain) {
            if (false === $data->getDomains()->contains($domain)) {
                $em->remove($domain);
            }
        }

        $em->flush();
    }
}
