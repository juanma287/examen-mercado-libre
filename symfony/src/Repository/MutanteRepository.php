<?php

namespace App\Repository;

use App\Entity\Mutante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mutante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mutante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mutante[]    findAll()
 * @method Mutante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MutanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mutante::class);
    }

   
    /**
     * Se cuenta la cantidad de mutantes y humanos almacenados en la tabla mutante
     */
    public function countMutantAndHuman()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT SUM(CASE 
                    WHEN m.ismutant = 1 THEN 1
                    ELSE 0
                    END) AS isMutant,
               SUM(CASE 
                    WHEN m.ismutant = 0 THEN 1
                    ELSE 0
                    END) AS isHuman
        FROM App\Entity\Mutante m ');

        $mutant = $query->getResult();
        return $mutant;
    }

}
