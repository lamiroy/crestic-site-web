<?php

namespace App\Repository;

use App\Entity\ProjetsHasPartenaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ProjetsHasPartenairesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjetsHasPartenairesRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjetsHasPartenaires::class);
    }

    public function findAllPartenairesFromProjetBuilder($id_projet)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->innerJoin('a.partenaire', 'b')
            ->where('a.projet = ?1')
            ->setParameter(1,$id_projet)
            ->orderBy('b.nom','ASC');
    }

    public function findAllPartenairesFromProjet ($id_projet)
    {
        return $this->findAllPartenairesFromProjetBuilder($id_projet)->getQuery()->getResult();
    }



    public function getArrayIdFromProjetsPartenaires ($id_projet)
    {
        $result = [];
        $array  =  $this->findAllPartenairesFromProjet($id_projet);

        foreach ($array as $key=>$value)
        {
            $id = $value->getPartenaire()->getId();
            $result[] = $id;
        }
        return $result;
    }
}