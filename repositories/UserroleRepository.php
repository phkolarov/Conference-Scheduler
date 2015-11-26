<?php
namespace SoftUni\Repositories;

use SoftUni\Core\Database;
use SoftUni\Models\Userrole;
use SoftUni\Collections\UserroleCollection;

class UserroleRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var UserroleRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return UserroleRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    /**
     * @param $id
     * @return $this
     */
    public function filterById($id)
    {
        $this->where .= " AND id = ?";
        $this->placeholders[] = $id;

        return $this;
    }
    /**
     * @param $userid
     * @return $this
     */
    public function filterByUserid($userid)
    {
        $this->where .= " AND userid = ?";
        $this->placeholders[] = $userid;

        return $this;
    }
    /**
     * @param $roleid
     * @return $this
     */
    public function filterByRoleid($roleid)
    {
        $this->where .= " AND roleid = ?";
        $this->placeholders[] = $roleid;

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderBy($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }

        $this->order .= " ORDER BY $column";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderByDescending($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }

        $this->order .= " ORDER BY $column DESC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenBy($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }

        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        $this->order .= ", $column ASC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenByDescending($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }

        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        $this->order .= ", $column DESC";

        return $this;
    }

    /**
     * @return UserroleCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM userrole" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Userrole($entityInfo['userid'],
$entityInfo['roleid'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        return new UserroleCollection($collection);
    }

    /**
     * @return Userrole
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM userrole" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new Userrole($entityInfo['userid'],
$entityInfo['roleid'],
$entityInfo['id']);

        self::$selectedObjectPool[] = $entity;

        return $entity;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        $db = Database::getInstance('app');

        $this->query = "DELETE FROM userrole" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Userrole $model)
    {
        if ($model->getId()) {
            throw new \Exception('This entity is not new');
        }

        self::$insertObjectPool[] = $model;
    }

    public static function save()
    {
        foreach (self::$selectedObjectPool as $entity) {
            self::update($entity);
        }

        foreach (self::$insertObjectPool as $entity) {
            self::insert($entity);
        }

        return true;
    }

    private static function update(Userrole $model)
    {
        $db = Database::getInstance('app');

        $query = "UPDATE userrole SET userid= :userid, roleid= :roleid WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':userid' => $model->getUserid(),
':roleid' => $model->getRoleid()
            ]
        );
    }

    private static function insert(Userrole $model)
    {
        $db = Database::getInstance('app');

        $query = "INSERT INTO users (userid,roleid) VALUES (:userid, :roleid);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':userid' => $model->getUserid(),
':roleid' => $model->getRoleid()
            ]
        );
        $model->setId($db->lastId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\SoftUni\Userrole');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}