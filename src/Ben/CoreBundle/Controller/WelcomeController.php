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
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $imageFileRepository = $this->getDoctrine()->getRepository("BenCoreBundle:ImageFile");
    
        return array();
    }
}
