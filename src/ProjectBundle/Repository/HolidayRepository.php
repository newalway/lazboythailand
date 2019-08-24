<?php

namespace ProjectBundle\Repository;

/**
 * HolidayRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HolidayRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllData($arr_query_data=false)
    {
        $qb = $this->createQueryBuilder('h')
            ->OrderBy('h.holidayDate', 'ASC');

        $q = $arr_query_data['q'];
        if($q){
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('h.title', ':query')
            ))
            ->setParameter('query', '%'.$q.'%');
        }
        return $qb;
    }

    public function findActiveData()
    {
        $today = new \DateTime();
        $today->setTime(0, 0, 0);
        $qb = $this->createQueryBuilder('h')
                ->where('h.status = 1')
                ->OrderBy('h.holidayDate', 'ASC');
        $qb->where($qb->expr()->andX(
            $qb->expr()->gte('h.holidayDate', ':today')
        ))
        ->setParameter('today', $today);
        return $qb;
    }

    public function findPublicHolidayByDate($delivery_date)
    {
        $qb = $this->createQueryBuilder('h')
                ->where('h.status = 1');
        $qb->where($qb->expr()->andX(
            $qb->expr()->eq('h.holidayDate', ':delivery_date')
        ))
        ->setParameter('delivery_date', $delivery_date);
        return $qb;
    }


}
