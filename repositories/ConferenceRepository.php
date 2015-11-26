<?php
namespace SoftUni\Repositories;

use SoftUni\Core\Database;
use SoftUni\Models\Conference;
use SoftUni\Collections\ConferenceCollection;

class ConferenceRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var ConferenceRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return ConferenceRepository
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
     * @param $name
     * @return $this
     */
    public function filterByName($name)
    {
        $this->where .= " AND name = ?";
        $this->placeholders[] = $name;

        return $this;
    }
    /**
     * @param $date
     * @return $this
     */
    public function filterByDate($date)
    {
        $this->where .= " AND date = ?";
        $this->placeholders[] = $date;

        return $this;
    }
    /**
     * @param $hall_id
     * @return $this
     */
    public function filterByHall_id($hall_id)
    {
        $this->where .= " AND hall_id = ?";
        $this->placeholders[] = $hall_id;

        return $this;
    }
    /**
     * @param $break1
     * @return $this
     */
    public function filterByBreak1($break1)
    {
        $this->where .= " AND break1 = ?";
        $this->placeholders[] = $break1;

        return $this;
    }
    /**
     * @param $break2
     * @return $this
     */
    public function filterByBreak2($break2)
    {
        $this->where .= " AND break2 = ?";
        $this->placeholders[] = $break2;

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
     * @return ConferenceCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM conference" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Conference($entityInfo['name'],
$entityInfo['date'],
$entityInfo['hall_id'],
$entityInfo['break1'],
$entityInfo['break2'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        return new ConferenceCollection($collection);
    }

    /**
     * @return Conference
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM conference" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new Conference($entityInfo['name'],
$entityInfo['date'],
$entityInfo['hall_id'],
$entityInfo['break1'],
$entityInfo['break2'],
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

        $this->query = "DELETE FROM conference" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Conference $model)
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

    private static function update(Conference $model)
    {
        $db = Database::getInstance('app');

        $query = "UPDATE conference SET name= :name, date= :date, hall_id= :hall_id, break1= :break1, break2= :break2 WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':name' => $model->getName(),
':date' => $model->getDate(),
':hall_id' => $model->getHall_id(),
':break1' => $model->getBreak1(),
':break2' => $model->getBreak2()
            ]
        );
    }

    private static function insert(Conference $model)
    {
        $db = Database::getInstance('app');

        $query = "INSERT INTO users (name,date,hall_id,break1,break2) VALUES (:name, :date, :hall_id, :break1, :break2);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':name' => $model->getName(),
':date' => $model->getDate(),
':hall_id' => $model->getHall_id(),
':break1' => $model->getBreak1(),
':break2' => $model->getBreak2()
            ]
        );
        $model->setId($db->lastId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\SoftUni\Conference');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}