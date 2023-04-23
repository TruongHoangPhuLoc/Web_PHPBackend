<?php
include ("../validation/Message.php");
class Database
{
    private $mysqlhost;
    private $dns;
    private $username;
    private $password;
    private $pdo;
    private $stmt;

    public function __construct()
    {
        try{
            $this->mysqlhost = getenv('mysqlhost');
            $this->dns = sprintf('mysql:host=%s; dbname=MyDB; charset=utf8',$this->mysqlhost);
            $this->username = getenv('username');
            $this->password = getenv('password');
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


