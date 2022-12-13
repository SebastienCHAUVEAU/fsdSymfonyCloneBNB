<?php

namespace App\Repository;

use App\Entity\Accomodation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Accomodation>
 *
 * @method Accomodation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accomodation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accomodation[]    findAll()
 * @method Accomodation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccomodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accomodation::class);
    }

    public function save(Accomodation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Accomodation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search($city,$people,$dateA,$dateB)
    {

        
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ville_nom_simple, ville_latitude_deg, ville_longitude_deg 
        FROM spec_villes_france_free
        WHERE ville_nom_simple = :city';
        $request = $conn->prepare($sql);
        $resultSet  = $request->executeQuery(['city' => $city]);
        $result = $resultSet->fetchAssociative();
        $qbDate = $this->createQueryBuilder("a2");

        
        
        $qbDate = $qbDate
            ->innerJoin("a2.booking_acc", "b2")
            ->where("b2.startDateAt < :dateB")
            ->andWhere("b2.endDateAt > :dateA");

        $qb = $this->createQueryBuilder('a')
            ->join("a.rooms","r")
            ->join("r.roombeds","rb")
            ->join("rb.bed","b")
            ->groupBy("a.id")
            ->having("SUM(b.size * rb.quantity) >= :people")
            ->setParameter("people",$people)
            ->where("a.city = :city")
            ->setParameter('city', $city);


        $qb ->addSelect("ACOS(SIN(PI()*a.latitude/180.0)*SIN(PI()*:lat2/180.0)+COS(PI()*a.latitude/180.0)*COS(PI()*:lat2/180.0)*COS(PI()*:lon2/180.0-PI()*a.longitude/180.0))*6371 AS dist")
            ->setParameter(":lat2", $city["ville_latitude_deg"])
            ->setParameter(":lon2", $city["ville_longitude_deg"])
            ->orderBy("dist");


             //DATE
             if ($dateA && $dateB) {
            //requête imbriquée : ON EXCLUT LES LOGEMENTS NON DISPONIBLES
            $qb->andWhere($qb->expr()->notIn('a.id', $qbDate->getDQL()))
                ->setParameter("dateB", $dateB)
                ->setParameter("dateA", $dateA);
        }
            
       

        return $qb->getQuery()
                ->getResult()
        ;

    }

//    /**
//     * @return Accomodation[] Returns an array of Accomodation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Accomodation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
