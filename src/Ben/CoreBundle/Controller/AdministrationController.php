<?php

namespace Ben\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Implements methods to access administration pages
 */
class AdministrationController extends Controller
{
    /**
     * @Route("/administration")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
