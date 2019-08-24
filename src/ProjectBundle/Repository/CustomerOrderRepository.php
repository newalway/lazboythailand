<?php

namespace ProjectBundle\Repository;

/**
 * CustomerOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomerOrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCustomerOrderAll($arr_query_data=false){
        $qb = $this->createQueryBuilder('o')
                	->orderBy('o.orderDate', 'DESC');

        if(isset($arr_query_data['q'])){
            $q = $arr_query_data['q'];
            $qb->where($qb->expr()->orX(
                $qb->expr()->like('o.orderNumber', ':query'),
                $qb->expr()->like('o.paymentOption', ':query'),
                $qb->expr()->like('o.paymentOptionTitle', ':query')
            ))
            ->setParameter('query', '%'.$q.'%');
        }

        if(isset($arr_query_data['search_status'])){
            $search_status = $arr_query_data['search_status'];
            if($search_status==1){
                $qb->andWhere("o.paid = 1");
            }elseif($search_status==0){
                $qb->andWhere("o.paid = 0");
            }
        }

        if(isset($arr_query_data['date_type'])){
            // order date
            if ($arr_query_data['date_type']==1){
                if(isset($arr_query_data['search_type'])){
                    //date range
                    if($arr_query_data['search_type'] == 1){
                        $tran_start_date = (!empty($arr_query_data['search_start_date'])) ? date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $arr_query_data['search_start_date'].' 00:00:00'))) : "";
                        $tran_end_date = (!empty($arr_query_data['search_end_date'])) ? date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $arr_query_data['search_end_date'].' 23:59:59'))) : "";

                        if(!empty($tran_start_date) && !empty($tran_end_date)){
                            $qb->andWhere('o.orderDate between :tran_start_date and :tran_end_date')
                            ->setParameter('tran_start_date', $tran_start_date)
                            ->setParameter('tran_end_date', $tran_end_date);
                        }
                    //month
                    }elseif($arr_query_data['search_type'] == 2){
                        //// filter by month
                        $month = $arr_query_data['search_month']+1;
                        $year = date('Y')-$arr_query_data['search_year'];
                        if(!empty($month) && !empty($year)){
                            $qb->andWhere('MONTH(o.orderDate) = :month  and YEAR(o.orderDate) = :year')
                            ->setParameter('month', $month)
                            ->setParameter('year', $year);
                        }
                    }
                }
            // ship date
            }elseif($arr_query_data['date_type']==2){
                if(isset($arr_query_data['search_type'])){
                    //date range
                    if($arr_query_data['search_type'] == 1){
                        $tran_start_date = (!empty($arr_query_data['search_start_date'])) ? date('Y-m-d',strtotime(str_replace('/', '-', $arr_query_data['search_start_date']))) : "";
                        $tran_end_date = (!empty($arr_query_data['search_end_date'])) ? date('Y-m-d',strtotime(str_replace('/', '-', $arr_query_data['search_end_date']))) : "";
                        if(!empty($tran_start_date) && !empty($tran_end_date)){
                            $qb->andWhere('o.shipDate between :tran_start_date and :tran_end_date')
                            ->setParameter('tran_start_date', $tran_start_date)
                            ->setParameter('tran_end_date', $tran_end_date);
                        }
                    //month
                    }elseif($arr_query_data['search_type'] == 2){
                        // filter by month
                        $month = $arr_query_data['search_month']+1;
                        $year = date('Y')-$arr_query_data['search_year'];
                        if(!empty($month) && !empty($year)){
                            $qb->andWhere('MONTH(o.shipDate) = :month  and YEAR(o.shipDate) = :year')
                            ->setParameter('month', $month)
                            ->setParameter('year', $year);
                        }
                    }
                }
            }
        }

        return $qb;
    }

    //////// select item and order  all if order must be have item
    public function findCustomerOrderHasItem($arr_query_data=false){
        $qb = $this->findCustomerOrderAll($arr_query_data)
                ->innerJoin('o.customerOrderItems','oi')
                ->andWhere('o.deleted != :status')
                ->setParameter('status', 1);
        return $qb;
    }

    public function findCustomerOrderWithoutQuotation($arr_query_data, $payment_option){
        $qb = $this->findCustomerOrderHasItem($arr_query_data)
                ->innerJoin('o.user','u')
                ->andWhere('o.paymentOption != :payment_option')
                ->setParameter('payment_option', $payment_option);
        return $qb;
    }

    public function countCustomerOrderWithoutQuotation($payment_option){
        $qb = $this->findCustomerOrderAll()
                ->andWhere('o.deleted != :status')
                ->setParameter('status', 1)
                ->andWhere('o.paymentOption != :payment_option')
                ->setParameter('payment_option', $payment_option);
        return $qb;
    }
    public function countUnreadCustomerOrderWithoutQuotation($payment_option, $is_read=0){
        $qb = $this->countCustomerOrderWithoutQuotation($payment_option)
                ->andWhere('o.isRead = :is_read')
                ->setParameter('is_read', $is_read);
        return $qb;
    }

    //////// select item and order  all if order must be have item
    public function findCustomerOrderHasItemByUser($user){
        $qb = $this->findCustomerOrderHasItem()
                ->andWhere('o.user = :user')
                ->setParameter('user', $user);
        return $qb;
    }

    //////// select item and order  all if order must be have item
    public function findCustomerOrderHasItemByOrderNumber($orderNumber){
        $qb = $this->findCustomerOrderHasItem()
                ->andWhere('o.orderNumber = :orderNumber')
                ->setParameter('orderNumber', $orderNumber);
        return $qb;
    }

    public function findCustomerOrderHasItems($arr_query_data=false){
        $qb = $this->findCustomerOrderAll($arr_query_data)
                ->innerJoin('o.customerOrderItems','oi');
        return $qb;
    }

    public function getDataByOrderNumberAndUser($orderNumber, $user){
        $qb = $this->findCustomerOrderAll()
                ->innerJoin('o.customerOrderItems', 'oi')
                ->andWhere('o.user = :user')
                ->andWhere('o.orderNumber = :orderNumber')
                ->setParameter('user', $user)
                ->setParameter('orderNumber', $orderNumber);
        return $qb;
    }

    public function checkCustomerHasOrderById($orderid)
    {
        //QueryBuilder
        $qb = $this->findCustomerOrderAll()
                ->andWhere('o.cancelled <> :status')
                ->andWhere('o.deleted <> :status')
                ->andWhere('o.orderNumber = :orderid')
                ->addGroupBy('o.id')
                ->setParameter('status', 1)
                ->setParameter('orderid', $orderid);
        return $qb;
    }

    public function findRequestForQuotation($arr_query_data, $payment_option){
        $qb = $this->findCustomerOrderHasItem($arr_query_data)
                ->innerJoin('o.user','u')
                ->andWhere('o.paymentOption = :payment_option')
                ->setParameter('payment_option', $payment_option);
        return $qb;
    }
    public function findRequestForQuotationByOrderNumber($orderNumber, $payment_option){
        $qb = $this->findCustomerOrderHasItem()
                ->innerJoin('o.user','u')
                ->andWhere('o.orderNumber = :orderNumber')
                ->setParameter('orderNumber', $orderNumber)
                ->andWhere('o.paymentOption = :payment_option')
                ->setParameter('payment_option', $payment_option);
        return $qb;
    }
    public function countQuotation($payment_option){
        $qb = $this->findCustomerOrderAll()
                ->andWhere('o.deleted != :status')
                ->setParameter('status', 1)
                ->andWhere('o.paymentOption = :payment_option')
                ->setParameter('payment_option', $payment_option);
        return $qb;
    }
    public function countUnreadQuotation($payment_option, $is_read=0){
        $qb = $this->countQuotation($payment_option)
                ->andWhere('o.isRead = :is_read')
                ->setParameter('is_read', $is_read);
        return $qb;
    }
}