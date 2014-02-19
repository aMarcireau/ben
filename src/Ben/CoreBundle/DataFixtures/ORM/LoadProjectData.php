<?php

namespace Ben\CoreBundle\DataFixtures\ORM;

use Ben\CoreBundle\Entity\Project;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Load project fixtures
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */
class LoadProjectData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $project1 = new Project();
        $project1->setName("Ascension")
                  ->setDescription("Mais vous savez, moi je ne crois pas qu'il y ait de bonnes ou de mauvaises situations. Moi, si je devais résumer ma vie, aujourd'hui avec vous, je dirais que c'est d´abord des rencontres, des gens qui m'ont tendu la main peut-être à un moment où je ne pouvais pas, où j'étais seul chez moi. Et c'est assez curieux de se dire que les hasards, les rencontres forgent une destinée. Parce que quand on a le goût de la chose, quand on a le goût de la chose bien faite, le beau geste, parfois on ne trouve pas l'interlocuteur en face, je dirais le miroir qui vous aide à avancer.
                  Alors ce n'est pas mon cas, comme je disais là, puisque moi au contraire j'ai pu, et je dis merci à la vie, je lui dis merci, je chante la vie, je danse la vie, je ne suis qu'amour. Et finalement quand beaucoup de gens aujourd'hui me disent : \"Mais comment fais-tu pour avoir cette humanité ?\" eh bien je leur réponds très simplement, je leur dis : \"C'est ce goût de l´amour\", ce goût donc, qui m'a poussé aujourd'hui à entreprendre une construction mécanique, mais demain qui sait ? Peut-être simplement à me mettre au service de la communauté, à faire le don, le don de soi.")
                  ->setDate(new \DateTime('1993-11-29'));
        
        $project2 = new Project();
        $project2->setName("Palais")
                 ->setDescription("Débrouille toi pour que ces pierres n’arrivent jamais au chantier. Pas d’pierre, pas d’construction. Pas d’construction, pas d’palais. Pas d’palais... pas d’palais.")
                 ->setDate(new \DateTime('2014-02-20'));     

        $manager->persist($project1);
        $manager->persist($project2);
        $manager->flush();
        
        $this->addReference('project_1', $project1);
        $this->addReference('project_2', $project2);
    }
}
