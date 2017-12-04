<?php

namespace ApiCycle\Domain;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class MovieRepository extends \Doctrine\ORM\EntityRepository
{
    const ORDER_DIRECTION_ASC = 'asc';
    const ORDER_DIRECTION_DESC = 'desc';

    const ITEMS_PER_PAGE = 3;

    /**
     * @param int    $page
     * @param string $order
     * @param string $dir
     *
     * @return PaginatedCollection
     */
    public function getMovies($page, $order = null, $dir = null)
    {
        if (null === $dir) {
            $dir = self::ORDER_DIRECTION_ASC;
        }

        $this->validateInput($page, $order, $dir);

        $qb = $this->createQueryBuilder('movie')
            ->where('movie.status = :validStatus')
            ->setParameter('validStatus', Movie::STATUS_VALID);

        if ($order !== null) {
            $qb->orderBy('movie.'.$order, $dir);
        }

        $pagerFanta = $this->applyPagerFanta($qb, $page);
        $paginatedCollection = $this->buildPaginatedCollection($pagerFanta);

        return $paginatedCollection;
    }

    /**
     * @return int
     */
    public function countAll()
    {
        $qb = $this->createQueryBuilder('movie')
            ->select('COUNT(movie)')
            ->where('movie.status = :validStatus')
            ->setParameter('validStatus', Movie::STATUS_VALID);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return string[]
     */
    public static function getAvailableDirValues()
    {
        return [
            self::ORDER_DIRECTION_ASC,
            self::ORDER_DIRECTION_DESC,
        ];
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int          $page
     *
     * @return Pagerfanta
     */
    private function applyPagerFanta(QueryBuilder $queryBuilder, $page)
    {
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::ITEMS_PER_PAGE);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }

    /**
     * @param Pagerfanta $pagerfanta
     *
     * @return PaginatedCollection
     */
    private function buildPaginatedCollection(Pagerfanta $pagerfanta)
    {
        $items = $pagerfanta->getCurrentPageResults();

        $paginatedCollection = new PaginatedCollection(
            $items,
            $pagerfanta->getNbResults()
        );

        return $paginatedCollection;
    }

    /**
     * @param int    $page
     * @param string $order
     * @param string $dir
     *
     * @throws \InvalidArgumentException
     */
    private function validateInput($page, $order, $dir)
    {
        if (0 > $page) {
            throw new \InvalidArgumentException('Page must be positive');
        }

        if (null !== $order) {
            if ('name' !== $order) {
                throw new \InvalidArgumentException("Only allowed value for order is 'name'");
            }
            if (false === in_array($dir, self::getAvailableDirValues())) {
                $availableValuesAsString = implode(', ', self::getAvailableDirValues());

                throw new \InvalidArgumentException(sprintf(
                    'Dir must be one of those: %s',
                    $availableValuesAsString
                ));
            }
        }
    }
}
