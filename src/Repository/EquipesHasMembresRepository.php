<?php

namespace App\Repository;

use App\Entity\EquipesHasMembres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * EquipesHasMembresRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EquipesHasMembresRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipesHasMembres::class);
    }

    public function findAllMembresFromEquipeBuilder($id_equipe)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->where('a.equipe = ?1')
            ->innerJoin('a.membreCrestic','b')
            ->orderBy('b.nom','asc')
            ->setParameter(1,$id_equipe);
    }

    public function findAllMembresFromEquipe ($id_equipe)
    {
        return $this->findAllMembresFromEquipeBuilder($id_equipe)->getQuery()->getResult();
    }

    public function getArrayIdFromEquipeMembre ($id_equipe)
    {
        $result = [];
        $array  =  $this->findAllMembresFromEquipe($id_equipe);

        foreach ($array as $key=>$value)
        {
            $id = $value->getMembreCrestic()->getId();
            $result[] = $id;
        }
        return $result;
    }

    public function findAllEquipesFromMembreBuilder($id_membre)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->where('a.membreCrestic = ?1')
            ->innerJoin('a.equipe','b')
            ->orderBy('b.nom','asc')
            ->setParameter(1,$id_membre);
    }

    public function findAllEquipesFromMembre ($id_membre)
    {
        return $this->findAllEquipesFromMembreBuilder($id_membre)->getQuery()->getResult();
    }
}