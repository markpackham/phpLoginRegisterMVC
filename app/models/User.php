<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");

        $result = $this->db->resultSet();

        return $result;
    }

    public function register($data)
    {
        $this->db->query("INSERT INTO users (username, email, password) VALUES(:username, :email, :password)");

        // Bind values
        $this->db->bind(':username', $data["username"]);
        $this->db->bind(':email', $data["email"]);
        $this->db->bind(':password', $data["password"]);

        // Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM users WHERE username = :username');

        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hashedPassword = $row->password;

        // check if the password we submitted matches the hashed verison in the database
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    // email is passed in by the controller
    public function findUserByEmail($email)
    {
        // prepared statement (to avoid SQL injections)
        $this->db->query("SELECT * FROM users WHERE email = :email");

        // email param will be binded with the email variable
        $this->db->bind(':email', $email);

        // check if email is already registered
        // we wrote the rowCount function in libraries/Database.php
        if ($this->db->rowCount > 0) {
            return true;
        } else {
            return false;
        }
    }
}
