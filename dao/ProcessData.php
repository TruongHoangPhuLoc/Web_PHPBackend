<?php
include ("../validation/Message.php");
class Database
{
    private $dns = "mysql:host=localhost; dbname=mydatabase; charset=utf8";
    private $username = "PhuLoc";
    private $password = "Phuloc@99";
    private $pdo;
    private $stmt;

    public function __construct()
    {
        try{
            $this->pdo = new PDO($this->dns,$this->username,$this->password);
        }
        catch (Exception $e)
        {
            MessagePHP::showMessage($e->getMessage());
        }
    }
    public function closeConn()
    {
        $this->pdo = null;
    }
    public function select($statement)
    {
        try {
            $this->stmt = $this->pdo->prepare($statement);
            $this->stmt->execute();
            return $this->stmt;
        }catch(Exception $exception)
        {
            MessagePHP::showMessage($exception);
        }
    }
    public function selectParam($statement,$condition)
    {
        try {
            $this->stmt = $this->pdo->prepare($statement);
            $this->stmt->execute($condition);
            return $this->stmt;
        }catch(Exception $exception)
        {
            MessagePHP::showMessage($exception);
        }
    }
}


