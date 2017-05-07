<?php
/**
 * Created by PhpStorm.
 * User: doug
 * Date: 5/7/17
 * Time: 10:50 PM
 */

namespace AppBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function withTopLevelComments($post){
        return $this->createQueryBuilder("p")
                ->leftJoin("p.comments", "c")
                ->where("p = :post")
                ->andWhere("c.parent IS NULL")
                ->andWhere("p.status = 1")
                ->setParameter("post", $post)
                ->getQuery()->getResult();
            ;
    }
}