<?php

namespace Ben\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Implements methods to access all the basic pages (welcome, contact...)
 */
class WelcomeController extends Controller
{
    /**
     * Welcome page
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $imageFileRepository = $this->getDoctrine()->getRepository("BenCoreBundle:ImageFile");
        
        $backgroundFiles = array();
        $galleryFiles = array();
        
        $backgroundFiles = $imageFileRepository->findByDisplay('background');
        $galleryFiles  = $imageFileRepository->findByDisplay('gallery');
        
        foreach($imageFileRepository->findByDisplay('both') as $imageFile) {
            $backgroundFiles[] = $imageFile;
            $galleryFiles[]  = $imageFile;
        }
        
        $this->orderByProjectDate($galleryFiles);
        $backgroundFile = $backgroundFiles[array_rand($backgroundFiles, 1)];
        
        return array(
            'backgroundFile' => $backgroundFile,
            'galleryFiles'   => $galleryFiles,
        );
    }
    
    /**
     * Order an array of image files by associated project date, then name
     *
     */
    public function orderByProjectDate($imageFileArray) {
        uasort($imageFileArray, array($this, 'imageFileProjectDateCompare'));
    }
    
    /**
     * Return true if the first image file's project is more recent than the second
     */
    public function imageFileProjectDateCompare($imageFile1, $imageFile2) {

        $date1 = $imageFile1->getProject()->getDate();
        $date2 = $imageFile2->getProject()->getDate();
        
        if ($date1 == $date2) {
            return strcasecmp($imageFile1->getName(), $imageFile2->getName());
        }
        
        return ($date1 < $date2) ? -1 : 1;
    }
}
