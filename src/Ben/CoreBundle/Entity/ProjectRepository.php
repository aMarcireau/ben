<?php

namespace Ben\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Find most recent projects order by date
     *
     * @param integer $limit: limit
     * @param integer $offset: offset
     * @return ArrayCollection
     */
    public function findOrderByDate($limit = 20, $offset = 0)
    {
        $query = $this->createQueryBuilder('project')
            ->orderBy('project.date', 'DESC')
            ->addOrderBy('project.name')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();
        
        return $query->getResult();
    }
}