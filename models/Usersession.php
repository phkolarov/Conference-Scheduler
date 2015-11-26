            <?php

            namespace SoftUni\Models;

            class Usersession
            {
	const COL_ID = 'id';
	const COL_USERID = 'userid';
	const COL_SESSION = 'session';
	const COL_LOGINDATE = 'loginDate';

	private $id;
	private $userid;
	private $session;
	private $loginDate;

	public function __construct($userid, $session, $loginDate, $id = null)
	{
		$this->setId($id);
		$this->setUserid($userid);
		$this->setSession($session);
		$this->setLoginDate($loginDate);
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
	public function getUserid()
	{
		return $this->userid;
	}

	/**
	* @param $userid
	* @return $this
	*/
	public function setUserid($userid)
	{
		$this->userid = $userid;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getSession()
	{
		return $this->session;
	}

	/**
	* @param $session
	* @return $this
	*/
	public function setSession($session)
	{
		$this->session = $session;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getLoginDate()
	{
		return $this->loginDate;
	}

	/**
	* @param $loginDate
	* @return $this
	*/
	public function setLoginDate($loginDate)
	{
		$this->loginDate = $loginDate;
		
		return $this;
	}

}