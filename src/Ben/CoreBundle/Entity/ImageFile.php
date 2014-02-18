<?php

namespace Ben\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ben\CoreBundle\Entity\Project;

/**
 * ImageFile
 *
 * Represents an image file
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\Image(
     *     maxWidth = 5000,
     *     maxHeight = 5000,
     *     maxSize = "1024k",
     *     mimeTypesMessage = "Le fichier doit être une image"
     *     maxWidthMessage = "L'image ne doit pas excéder {{ max_width }}px de large",
     *     maxHeightMessage = "L'image ne doit pas excéder {{ max_height }}px de haut",
     *     sizeNotDetectedMessage = "La taille de l'image n'a pas pu être detectée",
     * )
     * * @Assert\NotBlank(
     *     message = "Une image doit être uploadée",
     * )
     */
    public $file;
    
    
    //
    // Custom methods
    //
    
    /**
     * Get image directory name
     *
     * @return string 
     */
    protected function getWebDirectory()
    {
    
        return 'uploads/images';
    }
    
    /**
     * Get image upload directory
     *
     * @return string 
     */
    protected function getUploadDirectory()
    {
    
        return __DIR__ . '/../../../../web/' . $this->getWebDirectory();
    }
    
    /**
     * Get image path for the web
     *
     * @return string
     */
    protected function getPath()
    {
    
        return $this->getWebDirectory() . '/' . $this->getFilename();
    }
    
    /**
     * Get absolute image path (to delete or move)
     *
     * @return string
     */
    protected function getAbsolutePath()
    {
    
        return $this->getUploadDirectory() . '/' . $this->getFilename();
    }

    /**
     * Uplaod function
     * This method is called automatically before peristing an object in the database
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        
        $this->setFilename(sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension());
        $this->file->move($this->getUploadDirectory(), $this->getFilename());

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    
    /**
     * Set file
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile
     * @return imageFile
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile() {
    
        return $this->file;
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
    public function setProject(Project $project)
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
