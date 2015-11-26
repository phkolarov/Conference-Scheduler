            <?php

            namespace SoftUni\Models;

            class User
            {
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_PASSWORD = 'password';
	const COL_FULLNAME = 'fullname';

	private $id;
	private $username;
	private $password;
	private $fullname;

	public function __construct($username, $password, $fullname, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setFullname($fullname);
	}

	/**
	* @return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* @param $id
	* @return $this
	*/
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getUsername()
	{
		return $this->username;
	}

	/**
	* @param $username
	* @return $this
	*/
	public function setUsername($username)
	{
		$this->username = $username;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPassword()
	{
		return $this->password;
	}

	/**
	* @param $password
	* @return $this
	*/
	public function setPassword($password)
	{
		$this->password = $password;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getFullname()
	{
		return $this->fullname;
	}

	/**
	* @param $fullname
	* @return $this
	*/
	public function setFullname($fullname)
	{
		$this->fullname = $fullname;
		
		return $this;
	}

}