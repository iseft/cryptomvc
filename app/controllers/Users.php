<?php

/* use function PHPSTORM_META\map; */

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header('location:http://' . URLROOT . '/portfolios/show');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => '',
            ];

            if (empty($data['username'])) {
                $data['usernameError'] = 'Please enter a username.';
            }

            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter a password.';
            }

            $this->loginUser($data);
        } else {
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];
        }

        $this->view('users/login', $data);
    }


    public function register()
    {
        /*         $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ]; */

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            $data = $this->validateName($nameValidation, $data);
            $data = $this->validateEmail($data);
            $data = $this->validatePassword($passwordValidation, $data);

            $this->registerUser($data);
        } else {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];
        }

        $this->view('users/register', $data);
    }


    public function logout()
    {
        session_unset();
        session_destroy();

        header('location:http://' . URLROOT . '/users/login');
    }


    public function createUserSession($user)
    {
        if ($user->user_id == ADMIN_USERID) {
            $_SESSION['admin'] = true;
        } else {
            $_SESSION['admin'] = false;
        }
        
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->user_name;
        $_SESSION['email'] = $user->user_email;
    }


    public function validateName($nameValidation, $data)
    {

        if (empty($data['username'])) {
            $data['usernameError'] = 'Please enter username.';
        } elseif (!preg_match($nameValidation, $data['username'])) {
            $data['usernameError'] = 'Name can only contain letters and numbers.';
        }

        return $data;
    }


    public function validateEmail($data)
    {

        if (empty($data['email'])) {
            $data['emailError'] = 'Please enter email.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['emailError'] = 'Please enter the correct format.';
        } else {
            if ($this->userModel->findUserByEmail($data['email'])) {
                $data['emailError'] = 'Email is already taken.';
            }
        }

        return $data;
    }

    public function validatePassword($passwordValidation, $data)
    {

        if (empty($data['password'])) {
            $data['passwordError'] = 'Please enter password.';
        } elseif (strlen($data['password']) < 6) {
            $data['passwordError'] = 'Password must be at least 6.';
        } elseif (!preg_match($passwordValidation, $data['password'])) {
            $data['passwordError'] = 'Password must have at least one numeric value.';
        }

        if (empty($data['confirmPassword'])) {
            $data['confirmPasswordError'] = 'Please enter confirm password.';
        } else {
            if ($data['password'] != $data['confirmPassword']) {
                $data['confirmPasswordError'] = 'Passwords do not match.';
            }
        }

        return $data;
    }


    public function registerUser($data)
    {
        if (empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            if ($this->userModel->register($data)) {
                header('Location:http://' . URLROOT . '/users/login');
            } else {
                die("Something went wrong.");
            }
        }
    }


    public function loginUser($data)
    {
        if (empty($data['usernameError']) && empty($data['passwordError'])) {
            $loggedInUser = $this->userModel->login($data['username'], $data['password']);

            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
                header('Location:http://' . URLROOT . '/portfolios/show', );
            } else {
                $data['passwordError'] = 'Password or username is incorrect. Please try again.';

                $this->view('users/login', $data);
            }
        }
    }
}
