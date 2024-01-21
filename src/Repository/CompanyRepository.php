<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;


/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 2;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findByExampleField(string $name, int $id): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :val')
            ->orWhere('c.id = :id')
            ->setParameter('id', $id)
            ->setParameter('val', $name)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    public function findAllGreaterThanPrice(string $name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
               SELECT * FROM company c LEFT JOIN position p ON c.id=p.company_id
               WHERE c.name like :name
               ORDER BY c.name ASC
               ';
               
        $resultSet = $conn->executeQuery($sql, ['name' =>'%'.$name.'%']);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function getCommentPaginator(Company $company, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.company = :company')
            ->andWhere('c.id = :id')
            ->setParameter('company', $company)
            ->setParameter('id', 3)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();

        $pa = new Paginator($query);
        return $pa;
    }



    public function boldWords(string $html, array $allergens): string
    {
        $items = explode(' ', $html);
        foreach ($items as &$item) {
            foreach ($allergens as $allergen) {
                if (substr_count($item, $allergen)) {
                    if (!preg_match('#^<b>.+</b>$#', $item))
                        $item = "<b>{$item}</b>";
                }
            }
        }
        return implode(' ', $items);
    }

    public function calculateDeliveryCosts(array $orderItems, float $deliveryCost): array
    {
        foreach ($orderItems as &$orderItem) {
            if (isset($orderItem['ilosc']) && $orderItem['ilosc'] > 0 && isset($orderItem['cena_szt'])) {
                $orderItem['cena_szt_z_kosztami_wysylki'] = round($deliveryCost / $orderItem['ilosc'], 2) + $orderItem['cena_szt'];
            }
        }
        return $orderItems;
    }

    public function kwerenda_raportu()
    {
        $dateFrom = date('Y-m-d', $_POST['unix_timestamp_od']);
        $dateTo =  date('Y-m-d', $_POST['unix_timestamp_do']);
        $listStatus = $_POST['lista_statusow'];
        return "
            SELECT COUNT(o.orders_id) orders_count, SUM(op.products_price * op.products_quantity) orders_val,
             osh.status_id as statusId
            FROM orders o
            INNER JOIN orders_products op USING(orders_id)
            INNER JOIN orders_status_history osh ON osh.orders_id = o.orders_id AND osh.status_id IN({$listStatus})
            WHERE o.date_purchased BETWEEN {$dateFrom} AND {$dateTo} group by osh.status_id;
        ";
    }

    public function skarb(string $input)
    {
        $inputArray = str_split($input);
        $outputArray = [];
        $level = 0;
        $i = 0;
        foreach ($inputArray as  $iArr) {

            if ($iArr == '(') {
                $level = $level - 1;
            } elseif ($iArr == ')') {
                $level = $level + 1;
            }

            $outputArray[$i]['index'] = $i;
            $outputArray[$i]['ciag'] = $iArr;
            $outputArray[$i]['poziom'] = $level;
            $i++;
        }
        return $outputArray;
    }



    //    /**
    //     * @return Company[] Returns an array of Company objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Company
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
