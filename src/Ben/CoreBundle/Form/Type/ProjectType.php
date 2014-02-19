<?php

namespace Ben\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                     'label' => 'Nom du projet',
            ))
            ->add('description', 'textarea', array(
                     'label' => 'Description',
            ))
            ->add('date', 'date', array(
                     'label' => 'Date',
                     'widget' => 'single_text',
                     'format' => 'dd/MM/yyyy',
                     'invalid_message' => 'La date doit être de la forme jj/mm/aaaa',
            ))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'Project';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\CoreBundle\Entity\Project',
            'render_fieldset' => false,
            'show_legend' => false,
        ));
    }
}
