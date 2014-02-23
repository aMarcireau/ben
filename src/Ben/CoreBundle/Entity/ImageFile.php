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
 * @ORM\HasLifecycleCallbacks()
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
     * Display name
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message = "L'image doit avoir un nom")
     */
    private $name;

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
     * @ORM\Column(name="display", type="string", length=255, nullable=true)
     */
    private $display;
    
    /**
     * Associated project
     *
     * @var Ben\CoreBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity = "Project", inversedBy = "imageFiles")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message = "Chaque image doit appartenir à un projet")
     */
    private $project;
    
    /**
     * Last update date
     * This column is used to force the persistance of the object, 
     * when only the field is changed
     *
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     * @Assert\NotBlank(message = "Le fichier doit avoir une date de dernière modification")
     */
    private $modified;
    
    /**
     * @Assert\Image(
     *     maxWidth = 5000,
     *     maxHeight = 5000,
     *     maxSize = "1024k",
     *     mimeTypesMessage = "Le fichier doit être une image",
     *     maxWidthMessage = "L'image ne doit pas excéder {{ max_width }}px de large",
     *     maxHeightMessage = "L'image ne doit pas excéder {{ max_height }}px de haut",
     *     sizeNotDetectedMessage = "La taille de l'image n'a pas pu être detectée"
     * )
     */
    private $file;
    
    /**
     * Store the old filename to delete it after the upload of a new file
     */
    private $oldFilename;
    
    //
    // Custom methods
    //
    
    /**
     * Get image directory name
     *
     * @return string 
     */
    static public function getWebDirectory()
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
    public function uploadFile()
    {
        if (null === $this->file) {
            
            return;
        }
        
        $this->setFilename(sha1(uniqid(mt_rand(), true)) . '.' . $this->file->guessExtension());
        $this->file->move($this->getUploadDirectory(), $this->getFilename());
            
        unset($this->file);
    }
    
    /**
     * Modified function
     * This method is called automatically before peristing an object in the database
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModified()
    {
        $this->modified = new \DateTime();
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function removeOldFile()
    {
        if ($this->oldFilename) {
            unlink($this->getUploadDirectory() . '/' . $this->oldFilename);
            
            unset($this->oldFilename);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFile()
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
        if ($file) {
            $this->file = $file;
            $this->modified = new \DateTime();
        }
        
        if (isset($this->filename)) {
                
            $this->oldFilename = $this->getFilename();
        }
        
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
    
    /**
     * Has file?
     * Return true if either file or filename is defined
     *
     * @return boolean
     *
     * @Assert\True(message = "Un fichier est requis")
     */
    public function isFileDefined() {
    
        return ($this->getFile() || $this->getFilename());
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
     * Set name
     *
     * @param string $name
     * @return ImageFile
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

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }
}
