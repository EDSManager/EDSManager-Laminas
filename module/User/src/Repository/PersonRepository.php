<?php

namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\Person;

/**
 * This is the custom repository class for Person entity.
 */

class PersonRepository extends EntityRepository
{
    /**
     * Retrieves all persons in descending Last_Name order.
     * @return Query
     */
    public function findAllPerson()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('P')
            ->from(Person::class, 'P')
            ->orderBy('P.lastName', 'DESC');

        return $queryBuilder->getQuery();
    }
}