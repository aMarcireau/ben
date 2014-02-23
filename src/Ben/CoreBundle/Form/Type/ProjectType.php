<?php

namespace Ben\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ben\CoreBundle\Entity\ImageFile;
use Ben\CoreBundle\Form\Type\ImageFileType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Project type
 *
 * Requires the container interface to be passed, as it calls th eimage file type
 */
class ProjectType extends AbstractType
{   
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                     'label' => 'Nom du projet',
            ))
            ->add('description', 'textarea', array(
                     'label' => 'Description',
            ))
            ->add('date', 'date', array(
                     'label'  => 'Date',
                     'widget' => 'single_text',
                     'format' => 'dd/MM/yyyy',
                     'invalid_message' => 'La date doit être de la forme jj/mm/aaaa',
            ))
            ->add('imageFiles', 'collection', array(
                    'type'          => 'image_file',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false,
                    'label'         => 'Images associées',
                ))
            ->add('save', 'submit');
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'project';
    }
    
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\CoreBundle\Entity\Project',
            'render_fieldset' => false,
            'show_legend' => false,
            'cascade_validation' => true,
        ));
    }
}
