<?php

namespace Ben\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ben\CoreBundle\Entity\Project;
use Ben\CoreBUndle\Form\Type\ProjectType;
use Doctrine\Common\Collections\ArrayCollection;

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
        $projectRepository = $this->getDoctrine()->getRepository("BenCoreBundle:Project");
        $projects = $projectRepository->findOrderByDate();
    
        return array(
            'projects' => $projects,
        );
    }
    
    /**
     * Edit event page
     *
     * @param integer $id : project id
     * @Route("/creations/{id}/editer", requirements = {"id" = "\d+"})
     * @Template()
     */
    public function projectEditAction(Project $project)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new ProjectType(), $project);
        
        $originalImageFiles = new ArrayCollection();
        foreach ($project->getImageFiles() as $imageFile) {
            $originalImageFiles->add($imageFile);
        }
        
        $form->handleRequest($request);   

        if ($form->isValid()) {
        
            $em = $this->getDoctrine()->getEntityManager();
        
            foreach ($originalImageFiles as $imageFile) {
                if (false === $project->getImageFiles()->contains($imageFile)) {
                    $em->remove($imageFile);
                }
            }
            
            $em->flush();
            
            return $this->redirect($this->generateUrl('ben_core_administration_index'));
        }
        
        return array(
            'form'  => $form->createView(),
        );
    }
}
