<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 25.11.2015 г.
 * Time: 14:57 ч.
 */

namespace IdentitySystem\IdentityRepository;


use IdentitySystem\IdentityModels\IdentitySessionModel;
use Core\Database;

class IdentitySessionRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var SessionRepository
     */
    private static $inst = null;

    public function __construct() { }

    /**
     * @return SessionRepository
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
     * @param $username
     * @return $this
     */
    public function filterByUserId($userId)
    {
        $this->where .= " AND userId = ?";
        $this->placeholders[] = $userId;

        return $this;
    }
    /**
     * @param $password
     * @return $this
     */
    public function filterBySession($session)
    {
        $this->where .= " AND session = ?";
        $this->placeholders[] = $session;

        return $this;
    }
    /**
     * @param $gold
     * @return $this
     */
    public function filterByLoginDate($date)
    {
        $this->where .= " AND loginDate = ?";
        $this->placeholders[] = $date;

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
     * @return SessionCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM usersessions" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {

            $entity = new IdentitySessionModel(
                $entityInfo['userid'],
                $entityInfo['session'],
                $entityInfo['loginDate'],
                $entityInfo['id']
            );

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        return new \Collections\UserCollection($collection);
    }

    /**
     * @return User
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM usersessions" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();

        $entity = new IdentitySessionModel(
            $entityInfo['userid'],
            $entityInfo['session'],
            $entityInfo['loginDate'],
            $entityInfo['id']
        );

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

        $this->query = "DELETE FROM usersessions" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(IdentitySessionModel $model)
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

    private static function update(IdentitySessionModel $model)
    {
        $db = Database::getInstance('app');

        $query = "UPDATE usersessions SET userId= :userid, session= :session, loginDate= :loginDate WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
                ':userid' => $model->getUserId(),
                ':session' => $model->getSession(),
                ':loginDate' => $model->getLoginDate()
            ]
        );
    }

    private static function insert(IdentitySessionModel $model)
    {
        $db = Database::getInstance('app');

        $query = "INSERT INTO usersessions (userid,session,loginDate) VALUES (:userid, :session, :loginDate);";
        $result = $db->prepare($query);

        $result->execute(
            [
                ':userid' => $model->getUserId(),
                ':session' => $model->getSession(),
                ':loginDate' => $model->getLoginDate()
            ]
        );
        $model->setId($db->lastId());
        //d($result->error());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\IdentityModels\IdentitySessionModel.php');
        $consts = $refc->getConstants();
        return in_array($column, $consts);
    }

}