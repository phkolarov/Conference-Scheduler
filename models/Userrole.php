            <?php

            namespace SoftUni\Models;

            class Userrole
            {
	const COL_ID = 'id';
	const COL_USERID = 'userid';
	const COL_ROLEID = 'roleid';

	private $id;
	private $userid;
	private $roleid;

	public function __construct($userid, $roleid, $id = null)
	{
		$this->setId($id);
		$this->setUserid($userid);
		$this->setRoleid($roleid);
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
	public function getRoleid()
	{
		return $this->roleid;
	}

	/**
	* @param $roleid
	* @return $this
	*/
	public function setRoleid($roleid)
	{
		$this->roleid = $roleid;
		
		return $this;
	}

}