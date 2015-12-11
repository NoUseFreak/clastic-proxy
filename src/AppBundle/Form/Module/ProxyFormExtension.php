<?php

namespace AppBundle\Form\Module;

use AppBundle\EventListener\ProxyFormPersistListener;
use AppBundle\Form\Type\DomainType;
use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * ProxyTypeExtension
 */
class ProxyFormExtension extends AbstractNodeTypeExtension
{
    private $listener;

    /**
     * ProxyFormExtension constructor.
     * @param $listener
     */
    public function __construct(ProxyFormPersistListener $listener)
    {
        $this->listener = $listener;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->getTabHelper($builder)
            ->findTab('general')
            ->add('backend')
            ->add('port', 'text', [
                'data' => 80,
            ])
            ->add('domains', 'collection', [
                'type' => new DomainType(),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;

        $builder->addEventSubscriber($this->listener);
    }
}
