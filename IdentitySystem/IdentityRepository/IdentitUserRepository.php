<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 24.11.2015 г.
 * Time: 13:27 ч.
 */

namespace IdentitySystem\IdentityRepository;
use IdentitySystem\IdentityModels\IdentityUser;
use IdentitySystem\IdentityModels\IdentityUserModel;
use Core\Database;


class IdentitUserRepository
{

    private $query;

    private $where = " WHERE 1";

    private $placefolders = [];

    private $order = "";

    /**
     * @param $id
     * @return $this
     */
    public function filterById($id){

        $this->where .= "AND id = ? ";
        $this->placefolders[]  = $id;
        return $this;
    }

    /**
     * @param $username
     * @return $this
     */
    public function filterByUsername($username){

        $this->where .= " AND username = ?";
        $this->placefolders[]  = $username;
        return $this;
    }

    /**
     * @param $password
     * @return $this
     */

    public function filterByPassword($password){

        $this->where .= " AND password = ?";
        $this->placefolders[]  = $password;
        return $this;
    }

    /**
     * @param $fullname
     * @return $this
     */

    public function filterByFullname($fullname){

        $this->where .= " AND fullname = ?";
        $this->placefolders[]  = $fullname;
        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderBy ($column){

        if(!$this->isColumnAllowed($column)){
            throw new \Exception("Column is not allowed");
        }

        if(!empty($this->order)){
            throw new \Exception("Cannot do primary order because you alterady have primary order");
        }

        $this->order .= " ORDER BY $column";

        return $this;
    }


    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderByDescending($column){
        if(!$this->isColumnAllowed($column)){
            throw new \Exception("Column is not allowed");
        }

        if(!empty($this->order)){
            throw new \Exception("Cannot do primary order because you already have primary order");
        }

        $this->order .= " ORDER BY $column DESC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenBy($column){

        if(!$this->isColumnAllowed($column)){
            throw new \Exception("Column is not allowed");
        }

        if(empty($this->order)){
            throw new \Exception("Cannot do secondary order, if you not have first order");
        }

        $this->order .= ", $column ASC";
        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenByDescending($column){

        if(empty($this->order)){
            throw new \Exception("Cannot do secondary order, if you not have first order");
        }

        $this->order .= ", $column DESC";
        return $this;
    }

    /**
     * @return User[]
     * @throws \Exception
     */
    public function findAll(){
        $db = Database::getInstance('app');

        $this->query = "SELECT * FROM users" . $this->where . $this->order;

        $result = $db->prepare($this->query);
        $result->execute($this->placefolders);
        var_dump($result->error());

        $users = [];


        foreach($result->fetchAll() as $userInfo){


            $user = new IdentityUserModel(
                $userInfo["username"],
                $userInfo["password"],
                $userInfo["fullname"],
                $userInfo["id"]
            );

            $users[] = $user;
        }
        return $users;
    }

    /**
     * @return User
     * @throws \Exception
     */
    public function findOne(){
        $db = Database::getInstance('app');

        $this->query = "SELECT * from users" . $this->where  . $this->order. " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placefolders);
        $userInfo = $result->fetch();

        d($userInfo);
        $user = new IdentityUserModel(
            $userInfo["username"],
            $userInfo["password"],
            $userInfo["fullname"],
            $userInfo["id"]
        );

        return $user;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete(){
        $db = Database::getInstance('app');

        $this->query = 'DELETE FROM users' . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placefolders);
        var_dump($this->query);


        return $result->rowCount() > 0;
    }

    private function isColumnAllowed($column){

        $ref = new \ReflectionClass('\IdentitySystem\IdentityModels\IdentityUserModel');
        $consts = $ref->getConstants();

        return in_array($column,$consts);
    }

    public static function save(UserC $user){





    }






}