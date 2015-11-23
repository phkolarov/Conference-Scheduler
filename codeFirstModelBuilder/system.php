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

            $queryUserTable = "CREATE TABLE Users(Id int NOT NULL AUTO_INCREMENT,Username varchar(255),Password varchar(255),Fullname varchar(255),PRIMARY KEY (Id))ENGINE=InnoDB;";
            $queryIndex = "ALTER TABLE Users ADD INDEX (Id);";
            $result = $db->prepare($queryUserTable);
            $result->execute();

            //ADD AUTOINCREMENTED INDEX
            $queryAutoincrement = "ALTER TABLE Users AUTO_INCREMENT = 1";
            $result = $db->prepare($queryAutoincrement);
            $result->execute();


            //ADD ADMINISTRATOR USER
            $queryAddAdministrator = "INSERT INTO users(Username,Password,Fullname) VALUES ('admin', 'admin', 'ADMINISTRATOR');";
            $result = $db->prepare($queryAddAdministrator);
            $result->execute();


            //CREATE TABLE ROLES
            $queryRoleTable = "CREATE TABLE Roles(Id int NOT NULL AUTO_INCREMENT,Rolename varchar(255),PRIMARY KEY (Id))ENGINE=InnoDB;;";
            $result = $db->prepare($queryRoleTable);
            $result->execute();

            //ADD ADMINISTRATOR ROLE
            $queryAddAdministrator = "INSERT INTO roles(Rolename) VALUES ('administrator');";
            $result = $db->prepare($queryAddAdministrator);
            $result->execute();

            //ADD EXTENDED USER ROLE
            $queryAddModerator = "INSERT INTO roles(Rolename) VALUES ('moderator');";
            $result = $db->prepare($queryAddModerator);
            $result->execute();

            //ADD ADMINISTRATOR ROLE
            $queryAddRegistered = "INSERT INTO roles(Rolename) VALUES ('registered');";
            $result = $db->prepare($queryAddRegistered);
            $result->execute();


            //CREATE MANY TO MANY TABLE USER-ROLES
            $QueryUserRoleTable = "CREATE TABLE userRole(Id int NOT NULL AUTO_INCREMENT,userId int, roleId int,PRIMARY KEY (Id))ENGINE=InnoDB;;";
            $result = $db->prepare($QueryUserRoleTable);
            $result->execute();

            //ADD FOREIGN KEY
            $foreightKeyConstraintQuery = "ALTER TABLE userRole ADD CONSTRAINT FK_UserRoles_UserID FOREIGN KEY (userId)REFERENCES Users(Id);";
            $result = $db->prepare($foreightKeyConstraintQuery);
            $result->execute();

            //ADD FOREIGN KEY
            $foreightKeyConstraintQuery2 = "ALTER TABLE userRole ADD CONSTRAINT FK_UserRoles_RoleID FOREIGN KEY (roleId)REFERENCES Roles(Id);";
            $result = $db->prepare($foreightKeyConstraintQuery2);
            $result->execute();

            //ADD ADMINISTRATOR ROLE
            $queryAddAdministratorToAdminRole = "INSERT INTO userrole(userId,roleId) VALUES (1,1);";
            $result = $db->prepare($queryAddAdministratorToAdminRole);
            $result->execute();


            //CREATE USERSESSIONS TABLE
            $QueryUserSessionTable = "CREATE TABLE userSessions(Id int NOT NULL AUTO_INCREMENT,userId int NOT NULL, session int,loginDate datetime,PRIMARY KEY (Id))ENGINE=InnoDB;;";
            $result = $db->prepare($QueryUserSessionTable);
            $result->execute();

            //ADD FOREIGN KEY
            $foreightKeyConstraintQuery = "ALTER TABLE userSessions ADD CONSTRAINT FK_UserSession_UserID FOREIGN KEY (userId)REFERENCES Users(Id);";
            $result = $db->prepare($foreightKeyConstraintQuery);
            $result->execute();

            var_dump($result->error());
        }

    }

}