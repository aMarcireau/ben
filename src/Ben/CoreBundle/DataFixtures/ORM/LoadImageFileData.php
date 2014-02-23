<?php

namespace Ben\CoreBundle\DataFixtures\ORM;

use Ben\CoreBundle\Entity\ImageFile;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Load project fixtures
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */
class LoadImageFileData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->moveImageFiles(array('data-fixture-1.jpg', 'data-fixture-2.jpg', 'data-fixture-3.jpg'));
    
        $imageFile1 = new ImageFile();
        $imageFile1->setName('Otis')
                   ->setFilename('data-fixture-1.jpg')
                   ->setDisplay('both')
                   ->setProject($this->getReference('project_1'));
        
        $imageFile2 = new ImageFile();
        $imageFile2->setName('Cléopatre et Amonbofis')
                   ->setFilename('data-fixture-2.jpg')
                   ->setDisplay('gallery')
                   ->setProject($this->getReference('project_1'));
                   
        $imageFile3 = new ImageFile();
        $imageFile3->setName('Amonbofis')
                   ->setFilename('data-fixture-3.jpg')
                   ->setDisplay('slider')
                   ->setProject($this->getReference('project_2'));

        $manager->persist($imageFile1);
        $manager->persist($imageFile2);
        $manager->persist($imageFile3);
        $manager->flush();
        
        $this->addReference('imageFile_1', $imageFile1);
        $this->addReference('imageFile_2', $imageFile2);
        $this->addReference('imageFile_3', $imageFile3);
    }
    
    /**
     * Move data-fixtures files to the web directory
     *
     * @param: filename array
     */
    public function moveImageFiles( array $filenames) {
        
        $webDirectory = ImageFile::getWebDirectory();
        $sourceDirectory = __DIR__ . '/../' . $webDirectory;
        $targetDirectory = __DIR__ . '/../../../../../web/' . $webDirectory; 
        
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
        
        foreach($filenames as $filename) {
            copy($sourceDirectory . '/' . $filename, $targetDirectory . '/' . $filename);
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return array(
            'Ben\CoreBundle\DataFixtures\ORM\LoadProjectData',
        );
    }
}
