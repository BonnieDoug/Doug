<?php

/**
 * Created by PhpStorm.
 * User: doug
 * Date: 5/7/17
 * Time: 10:50 PM
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository {

    public function withTopLevelComments($post) {
        return $this->createQueryBuilder("p")
                        ->leftJoin("p.comments", "c")
                        ->where("p = :post")
                        ->andWhere("c.parent IS NULL")
                        ->andWhere("p.status = 1")
                        ->setParameter("post", $post)
                        ->getQuery()->getResult();
        ;
    }

    public function paginateFindAll(\Symfony\Component\HttpFoundation\Request $request, $paginator) {
        
        $query = $this->createQueryBuilder("p")->where("p.status = 1")->getQuery();
        return $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 6/* limit per page */
        );
    }

}
