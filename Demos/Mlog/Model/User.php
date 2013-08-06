<?php
/**
 * @link https://github.com/MaGuowei/M
 * @copyright 2013 maguowei.com
 * @author Ma Guowei <imaguowei@gmail.com>
 */
namespace Mlog\Model;


use M\Mvc\Model\Model;

class User extends Model
{
    protected $id;
    protected $username;
    protected $password;
    protected $email;

    protected $table = 'user';
    protected $key = 'id';

    protected $data = array(
        'id' => 'id',
        'username' => 'username',
        'password' => 'password',
        'email' => 'email',
    );


    public function getId()
    {
        return $this->id;
    }

    public function setId()
    {

    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail()
    {
        $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}