<?php

namespace ProjectBundle\Repository;
use Symfony\Component\Intl\Locale;

/**
 * DistributorCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DistributorCategoryRepository extends \Doctrine\ORM\EntityRepository
{
    private $qb;

    public function findAllData($arr_query_data=false, $locale=false)
    {
        $locale = ($locale) ? $locale : Locale::getDefault();
        $this->qb = $this->createQueryBuilder('dbc');

        //join translation
        $this->qb->leftjoin('dbc.translations', 'dbct')
                ->select('dbc', 'dbct')
                ->orderBy('dbc.position', 'ASC')
                ->addOrderBy('dbc.id', 'DESC');

        $q = $arr_query_data['q'];
        if($q){
            //search from translation
            $this->qb->where($this->qb->expr()->orX(
                $this->qb->expr()->like('dbct.title', ':query')
                // $this->qb->expr()->like('evt.description', ':query')
            ))
            ->setParameter('query', '%'.$q.'%');
        }

        return $this->qb;
    }

    public function setPublic()
    {
        $this->qb->andWhere('dbc.status = 1');
    }

    public function findAllActiveData($arr_query_data=false, $locale=false)
    {
        $this->findAllData($arr_query_data, $locale);
        $this->setPublic();
        return $this->qb;
    }

    public function findAllActiveDataByZoneId($arr_query_data=false, $locale=false,$id)
    {
        $this->findAllActiveData($arr_query_data, $locale);
            $this->qb->leftjoin('dbc.distributor', 'd')
            ->leftjoin('d.zone','z')
            ->orderBy('dbc.id', 'ASC')
            ->addOrderBy('d.position', 'ASC')
            ->select('dbc', 'dbct','d','z');

            $this->qb->andwhere($this->qb->expr()->andX(
                $this->qb->expr()->eq('z.id', ':id')
                // $this->qb->expr()->like('evt.description', ':query')
            ))->setParameter('id',$id);

        return $this->qb;
    }

    public function findActiveDataByCategory($arr_query_data=false, $locale=false, $catObj)
    {
        $this->findAllActiveData($arr_query_data, $locale);

        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('dbc.distributorCategory', ':catObj')
        ))
        ->setParameter('catObj',$catObj)
        ->andWhere('dbct.status = 1');

        // $this->qb->where($this->qb->expr()->andX(
        // 		$this->qb->expr()->eq('ec.id', ':catObj')
        // ))

        return $this->qb;
    }
}