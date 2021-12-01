<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        $data = [
            "title" => "Loging Page",
        ];

        $this->view('users/login', $data);
    }
}
