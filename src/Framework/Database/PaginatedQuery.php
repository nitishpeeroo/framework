<?php
    namespace Framework\Database;

    use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery implements AdapterInterface
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var string
     */
    private $query;
    /**
     * @var string
     */
    private $countQuery;
    /**
     * @var string
     */
    private $entity;

    /**
     * PaginatedQuery constructor.
     *
     * @param \PDO   $pdo
     * @param string $query      Requête permettant de récuperer X résultats
     * @param string $countQuery Requête permettant de compter le nombre de résultat total
     * @param string $entity
     */
    public function __construct(\PDO $pdo, string $query, string $countQuery, string $entity)
    {

        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return array|\Traversable The slice.
     */
    public function getSlice($offset, $length) : array
    {
        $statement = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $statement->bindParam('offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam('length', $length, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        $statement->execute();
        return $statement->fetchAll();
    }
}
