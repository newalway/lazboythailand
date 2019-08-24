<?php

namespace ProjectBundle\Repository;

/**
 * SubscriberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubscriberRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAllData($arr_query_data=false)
	{
			//QueryBuilder Expr
			$qb = $this->createQueryBuilder('c');
			$qb->orderBy('c.createdAt', 'DESC');

			if(isset($arr_query_data['q'])){
				$q = $arr_query_data['q'];
				$qb->where($qb->expr()->orX(
					$qb->expr()->like('c.name', ':query'),
					$qb->expr()->like('c.email', ':query')
				))
				->setParameter('query', '%'.$q.'%');
			}
			return $qb;
	}
}
