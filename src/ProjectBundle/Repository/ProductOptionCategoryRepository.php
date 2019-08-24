<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Intl\Locale;

/**
 * ProductOptionCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductOptionCategoryRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findAllData($arr_query_data=false, $locale=false)
	{
		$locale = ($locale) ? $locale : Locale::getDefault();

		//QueryBuilder Expr
		$this->qb = $this->createQueryBuilder('poc')
			->select('poc, poct')
			->leftJoin('poc.translations', 'poct')
			->orderBy('poc.position', 'ASC')
			->addOrderBy('poc.createdAt', 'DESC');

		//join productOption
		$this->qb->addSelect('po', 'pot')
			->leftJoin('poc.productOptions', 'po')
			->leftJoin('po.translations', 'pot', "WITH", "pot.locale='$locale'");


		$q = $arr_query_data['q'];
		if($q){
			//search from translation
			$this->qb->where($this->qb->expr()->orX(
				$this->qb->expr()->like('poct.title', ':query')
			))
			->setParameter('query', '%'.$q.'%');
		}

		// $this->qb->andWhere("poct.locale = '$locale'");

		return $this->qb;
	}

	public function findAllActiveData($arr_query_data=false, $locale=false)
    {
		$this->findAllData($arr_query_data, $locale);
        $this->setPublic();
		return $this->qb;
	}

	public function setPublic()
    {
		$this->qb->andWhere('poc.status = 1');

        // $this->qb->andWhere('NOW() >= p.publishDate')
        //         ->andWhere('p.status = 1');

        // ->andWhere($this->qb->expr()->andX(
        //     $this->qb->expr()->eq('p.status', ':status')
        // ))->setParameter('status', 1);
    }
}
