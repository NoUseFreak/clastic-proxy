<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 11/12/15
 * Time: 22:49
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Domain;

class DomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fqdn');
    }

    public function getName()
    {
        return 'domain';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Domain::class,
        ));
    }
}