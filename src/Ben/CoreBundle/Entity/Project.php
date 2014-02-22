<?php

namespace Ben\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * Represents a project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ben\CoreBundle\Entity\ProjectRepository")
 * @UniqueEntity("name")
 */
class Project
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
     * Project name
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message = "Le projet doit avoir un nom")
     */
    private $name;

    /**
     * Project description
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message = "Le projet doit avoir une description")
     */
    private $description;

    /**
     * Project date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\NotBlank(message = "Le projet doit avoir une date")
     */
    private $date;
    
    /**
     * Associated image files
     *
     * @ORM\OneToMany(targetEntity="ImageFile", mappedBy="project")
     */
    protected $imageFiles;
    
    
    //
    // Custom methods
    //
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    
    /**
     * Add image files
     *
     * @param \Ben\CoreBundle\Entity\ImageFile $imageFile
     * @return Event
     */
    public function addImageFile(\Ben\CoreBundle\Entity\ImageFile $imageFile)
    {
        $this->imageFiles[] = $imageFile;
    
        return $this;
    }

    /**
     * Remove image files
     *
     * @param \Ben\CoreBundle\Entity\ImageFile $imageFile
     */
    public function removeVideo(\Ben\CoreBundle\Entity\ImageFile $imageFiles)
    {
        $this->imageFiles->removeElement($imageFiles);
    }

    /**
     * Get image files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImageFiles()
    {
        return $this->imageFiles;
    } 
    
    //
    // Doctrine-created accessors
    //

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
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Project
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
