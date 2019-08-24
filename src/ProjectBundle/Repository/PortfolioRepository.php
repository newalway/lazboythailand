<?php

namespace ProjectBundle\Repository;

/**
 * PortfolioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PortfolioRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllData($arr_query_data=false)
    {
      $qb = $this->createQueryBuilder('pf')
                  ->innerJoin('pf.translations', 'pft')
                  ->orderBy('pf.position', 'ASC')
                  ->addOrderBy('pf.publicDate', 'DESC')
                  ->addOrderBy('pf.createdAt', 'DESC');

      $q = $arr_query_data['q'];

      if($q){
        $qb->where($qb->expr()->orX(
          $qb->expr()->like('pft.title', ':query'),
          $qb->expr()->like('pft.shortDesc', ':query'),
          $qb->expr()->like('pft.description', ':query')
        ))
        ->setParameter('query', '%'.$q.'%');
      }

      return $qb;
    }
    public function findAllActiveData($arr_query_data=false)
    {
      $qb = $this->findAllData($arr_query_data);
      $qb->andWhere($qb->expr()->andX(
            $qb->expr()->like('pf.status', ':status'),
            $qb->expr()->lte('pf.publicDate', ':publicdate')
          ))
          ->setParameter('status',1)
          ->setParameter('publicdate',date('Y-m-d'))
        ;
      return $qb;
    }

    public function getActiveDataByRecent($id)
    {
      $qb = $this->findAllActiveData();
      $qb->andWhere($qb->expr()->andX(
          $qb->expr()->notLike('pf.id', ':id')
      ))
      ->setParameter('id', $id);
      return $qb;
    }

    public function getActiveDataById($id)
    {
      $qb = $this->findAllActiveData();
      $qb->andWhere($qb->expr()->andX(
            $qb->expr()->like('pf.id', ':id')
          ))
          ->setParameter('id',$id)
        ;
      return $qb;
    }
}