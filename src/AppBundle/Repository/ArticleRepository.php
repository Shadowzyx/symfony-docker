<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function findAllOrderedByTitle()
    {
        return $this->createQueryBuilder('article')
            ->orderBy('article.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}