<?php

namespace Entity;

class User
{
	protected $user_id;
    protected $username;
    protected $password;
    protected $mail;
    protected $role;
    protected $image;
    protected $createdAt;
    protected $file;
    
    public function getId()
    {
    	return $this->user_id;
    }
    
    public function setId($id)
    {
    	$this->user_id= $id;
    }
    

    public function getName()
    {
        return $this->username;
    }
    
    public function setName($username)
    {
        $this->username = $username;
    }
    

    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
    
    public function getImage() {
        // Make sure the image is never empty.
        if (empty($this->image)) {
            $this->image = 'placeholder.gif';
        }
        return $this->image;
    }
    
    public function setImage($image) {
        $this->image = $image;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    public function getFile() {
        return $this->file;
    }
    
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
    
    public function getRoles()
    {
        return array($this->getRole());
    }
    public function getRole()
    {
        return $this->role;
    }
    
    public function setRole($role) {
        $this->role = $role;
    }
    
}