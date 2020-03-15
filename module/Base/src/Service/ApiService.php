<?php

namespace Base\Service;

use Zend\Http\Request as HttpRequest;
use Doctrine\ORM\EntityManagerInterface;

class ApiService
{
    // Novas Constantes
    const EQ     = "eq";  // =
    const GTE    = "gte"; // >=
    const LT     = "lt";  // <
    const LTE    = "lte"; // <=
    const IN     = "in"; // % %
    const NOTIN  = "notin"; // % %
    const LIKE   = "like"; // % %
    const SEARCH = "search"; // % %
    const TABLE  = 't';

    /**
     * Limite de numero de registros
     * Default = 50
     * @var type Int
     */
    private $limit = 12;

    /**
     * Paginação
     * Default = 0
     * @var type Int
     */
    private $page = 0;

    /**
     * Order By
     * @var type Array
     */
    private $sort = null;

    /**
     * Order By
     * @var type Array
     */
    private $queryString = null;

    /**
     * Entity Manager
     */
    private $em;

    /**
     * Entity
     */
    private $entity;

    /**
     *
     * @var type Doctrine\ORM\Query\Expr\Orx
     */
    private $searchs = null;

    /**
     * QueryBuilder
     */
    public $qb;

    /**
     *
     * @param EntityManagerInterface $em
     * @param Usuario $usuario
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Return list of resources
     *
     * @return mixed
     */
    public function getList(HttpRequest $queryParams, String $entity)
    {
        /**
         * Parametros da URL
         */
        $this->queryString = $queryParams->getQuery();

        /**
         * Entity
         */
        $this->entity = $entity;

        /**
         * Query Builder
         */
        $this->qb = $this->em
            ->getRepository($this->entity)
            ->createQueryBuilder(self::TABLE)
            ->select(self::TABLE);


        $this->builder();

        // $dql = $this->qb->getQuery()->getDql(); var_dump($dql); die;

        return $this;
    }

    public function getResult()
    {
        return $this->qb
                ->setFirstResult($this->page * $this->limit)
                ->setMaxResults($this->limit)
                ->getQuery()->getResult();
    }

    public function builder()
    {
        $page  = $this->queryString["page"];
        $limit = $this->queryString["limit"];

        $this->page  = $page ? $page : $this->page;
        $this->limit = $limit ? $limit : $this->limit;

        foreach ($this->queryString as $field => $values) {

            // Se for um get
            if ($field == "id" && !isset($values[self::IN]) && !isset($values[self::NOTIN])) {
                $this->where(self::TABLE.".".$field, self::EQ, $values);
                return false;
            }

            // Necessario a troca de _ por . para a consulta
            $field = str_replace("_", ".", $field);

            // Verifica se precisa realizar o join
            $join = $this->joinChecking($field);

            // Caso um join de 2 niveis
            if (substr_count($field, '.') == 2) {
                $field = substr(strstr($field, '.'), 1);
            }

            // Caso falso a comparação será na tabela principal
            if ($join == false) {
                $field = self::TABLE.".".$field;
            }

            // Adicionando o where na consulta
            if (is_array($values)) {
                foreach ($values as $operator => $value) {
                    $this->where($field, $operator, $value);
                }
            }
        }

        // Elementos de pesquisa
        if ($this->searchs !== null) {

            $orX = $this->qb->expr()->orX();
            foreach ($this->searchs as $search) {
                $orX->add($search);
            }

            $this->qb->andWhere($orX);
        }
    }

    private function where($field, $operator, $value)
    {
        $c    = false;
        $expr = $this->qb->expr();

        $v     = $value;
        $value = $this->checkOr($value) ? substr($value, 2) : $value;

        switch (strtolower($operator)) {
            case self::EQ:
                $c = $expr->eq($field, $this->literal($value));
                break;
            case self::GTE:
                $c = $expr->gte($field, $this->literal($value));
                break;
            case self::LT:
                $c = $expr->lt($field, $this->literal($value));
                break;
            case self::LTE:
                $c = $expr->lte($field, $this->literal($value));
                break;
            case self::LIKE:
                $c = $expr->like($field, $this->literal("%".$value."%"));
                break;
            case self::SEARCH:
                  $this->searchs[] = $expr->like($field,
                    $this->literal("%".$value."%"));
                break;
            case self::IN:
                $c = $expr->in($field, $value);
                break;
            default:
                return false;
        }

        if ($c) {
            $this->checkOr($v) ? $this->qb->orWhere($c) : $this->qb->andWhere($c);
        }
    }

    private function literal($string)
    {
        return $this->qb->expr()->literal($string);
    }

    private function joinChecking($field): Bool
    {
        $count = substr_count($field, '.');

        // se o valor recebido tiver . significa tabelas secundarias
        if ($count > 0) {

            $expl = explode('.', $field);

            // Checa se o join ainda nao foi feito
            if ($this->checkJoinIsDefined($expl[0]) == false) {
                $this->qb->join(self::TABLE.".".$expl[0], $expl[0]);
            }

            // verificar niveis do join
            switch ($count) {
                case 2:
                    if ($this->checkJoinIsDefined($expl[1]) == false) {
                        $this->qb->join($expl[0].".".$expl[1], $expl[1]);
                    }
                    break;
            }

            return true;
        }

        return false;
    }

    // Checar condição OR
    private function checkOr($value): Bool
    {
        if (!is_array($value) && substr_count($value, '||') == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Função para checar se o join ja foi feito
    private function checkJoinIsDefined($alias)
    {
        $joinDqlParts = $this->qb->getDQLPart('join');

        foreach ($joinDqlParts as $joins) {
            foreach ($joins as $join) {
                if ($join->getAlias() === $alias) {
                    return true;
                }
            }
        }

        return false;
    }
}