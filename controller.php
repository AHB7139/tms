<?php

class Database
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $name = 'tms';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
    
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function establishConnection()
    {
        return $this->conn;
    }
}

class TaskManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addTask($taskName)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO tasks (taskName) VALUES (?)");
        $query->bind_param("s", $taskName);
        $query->execute();
        $query->close();
    }

    public function markTaskAsDone($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET is_done = IF(is_done = 0, 1, 0) WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }

    public function getTasks()
    {
        $conn = $this->db->establishConnection();
        $taskQuery = $conn->query("select * from tasks");
        // $tasks = $taskQuery->fetch_all(MYSQLI_ASSOC);

        $tasks = [];
        while ($row = $taskQuery->fetch_assoc()) {
            $tasks[] = $row;
        }

        return $tasks;
    }
}
class UserManager{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addUser($userId, $userName)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO users (userId, userName) VALUES (?, ?)");
        $query->bind_param("is", $userId, $userName);
        $query->execute();
        $query->close();
    }
    public function deleteUser($userId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("DELETE FROM users WHERE userId = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $query->close();
    }
    public function getUsers()
    {
        $conn = $this->db->establishConnection();
        $query = $conn->query("SELECT userId, userName FROM users");

        $users = [];
        while ($row = $query->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }
}
?>
