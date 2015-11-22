<?php
/**
 * Created by PhpStorm.
 * User: Phill
 * Date: 11/22/2015
 * Time: 7:52 PM
 */

namespace codeFirstModelBuilder;

require_once("Core\\Database.php");
use Core\Database;
use PDO;

class system
{


    public static function databaseBuilder($dbname)
    {

        //$db = Database::getInstance('app');

        $pdo = new \PDO("mysql:host=" . \Config\DatabaseConfig::DB_HOST, \Config\DatabaseConfig::DB_USER, \Config\DatabaseConfig::DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbname = "`" . str_replace("`", "``", $dbname) . "`";
        $pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");

        $pdo->query("use $dbname");

    }

    public static function createIdentityTables()
    {

        $db = Database::getInstance('app');

        $queryGetTables = "SHOW TABLES";

        $dbNames = $db->prepare($queryGetTables);
        $dbNames->execute();
        $tableNames = $dbNames->fetchAll();

        if (count($tableNames) <= 0) {

            $queryUserTable = "CREATE TABLE Users(Id int,Username varchar(255),Password varchar(255),Fullname varchar(255),PRIMARY KEY (Id));";
            $queryIndex = "ALTER TABLE Users ADD INDEX (Id);";
            $result = $db->prepare($queryUserTable);
            $result->execute();

//            $queryIndex = "ALTER TABLE Users ADD INDEX (Id);";
//            $result = $db->prepare($queryIndex);
//            $result->execute();



            $queryRoleTable = "CREATE TABLE Roles(Id int,Rolename varchar(255));";
            $result = $db->prepare($queryRoleTable);
            $result->execute();

            $queryIndex = "ALTER TABLE Roles ADD INDEX (Id);";
            $result = $db->prepare($queryIndex);
            $result->execute();

            $QueryUserRoleTable = "CREATE TABLE userRole(Id int,userId int, roleId int);";
            $result = $db->prepare($QueryUserRoleTable);
            $result->execute();

            $queryIndex = "ALTER TABLE userRole ADD INDEX (Id);";
            $result = $db->prepare($queryIndex);
            $result->execute();

            $foreightKeyConstraintQuery = "ALTER TABLE userRole ADD CONSTRAINT FK_ActiveDirectories_UserID FOREIGN KEY (userId)REFERENCES Users(Id);";
            $result = $db->prepare($foreightKeyConstraintQuery);
            $result->execute();

            var_dump($result->error());
        }

    }

}