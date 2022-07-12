<?php
/*
 * PDO Database class
 * Connect to DB
 * Create, bind and execute prepared statement
 * Return rows and results
 */

declare(strict_types=1);

class Database {
    private string $host = DB_HOST;
    private string $user = DB_USER;
    private string $pass = DB_PASS;
    private string $dbname = DB_NAME;

    private mixed $dbh;
    private mixed $stmt;
    private mixed $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ";dbname=" . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    public function query($sql) :void
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    // bind values
    public function bind($param, $value, $type = null) :void
    {
        if(is_null($type)){
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }
        $this->stmt->bindValue($param,$value,$type);
    }
    //Execute the prepared stmt
    public function execute()
    {
        return $this->stmt->execute();
    }

    //Get result set as array of objects
    public function resultSet() :array
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function singleResult() :object
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //Get row count
    public function rowCount() :int
    {
        return $this->stmt->rowCount();
    }
}