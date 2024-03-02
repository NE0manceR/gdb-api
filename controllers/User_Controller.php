<?php
class User_Controller
{
  private $user_model;

  public function __construct(User_Model $user_model)
  {
    $this->user_model = $user_model;
  }

  public function registration($name, $email, $user_password)
  {
    $result = $this->user_model->registration($name, $email, $user_password);

    return $result;
  }

  public function login($email, $password_from_user)
  {
    $result = $this->user_model->login($email, $password_from_user);

    return $result;
  }
}
