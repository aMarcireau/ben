<?php

namespace Ben\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ImageFile
 *
 * Represents an image file
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("filename")
 */
class ImageFile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Image filename
     *
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * Display in which the file appears.
     *
     * @var string
     *
     * @ORM\Column(name="display", type="string", length=255)
     */
    private $display;
    
    /**
     * Associated project
     *
     * @var Ben\CoreBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity = "Project", inversedBy = "imageFiles")
     */
    private $project;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return ImageFile
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set display
     *
     * @param string $display
     * @return ImageFile
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return string 
     */
    public function getDisplay()
    {
        return $this->display;
    }
    
    /**
     * Set project
     *
     * @param \Ben\CoreBundle\Entity\Project $project
     * @return imageFile
     */
    public function setProject(\Ben\CoreBundle\Entity\Project $project)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \Ben\CoreBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
}
