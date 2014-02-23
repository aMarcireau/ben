<?php

namespace Ben\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Image file type
 *
 * This class defines a type to uplaod an image.
 * It is meant to be used inside a project type, as a collection, and must be passed the container interface
 */
class ImageFileType extends AbstractType
{   
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                     'label' => "Nom de l'image",
            ))
            ->add('file', 'file', array(
                     'label' => 'Fichier',
            ))
            ->add('display', 'choice', array(
                     'choices' => $this->container->getParameter('displays'),
                     'label'   => 'Affichage',
            ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'image_file';
    }
    
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\CoreBundle\Entity\ImageFile',
            'render_fieldset' => false,
            'show_legend' => false,
        ));
    }
}
