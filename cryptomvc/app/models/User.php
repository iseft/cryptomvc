<?php

class User extends Model
{
/*     protected $db;

    public function __construct()
    {
        $this->db = new Database;
    } */


    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");

        $result = $this->db->resultSet();

        return $result;
    }


    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE user_email = :email');

        $this->db->bind(':email', $email);

        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function register($data)
    {
        $this->db->query('INSERT INTO users (user_name, user_email, password) VALUES (:user_name, :user_email, :password)');

        $this->db->bind(':user_name', $data['username']);
        $this->db->bind(':user_email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM users WHERE user_name = :user_name');

        $this->db->bind(':user_name', $username);

        $row = $this->db->single();

        if ($row != false) {
            $hashedPassword = $row->password;

            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {
                return false;
            }
        }
    }
}
