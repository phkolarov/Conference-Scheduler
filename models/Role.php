            <?php

            namespace SoftUni\Models;

            class Role
            {
	const COL_ID = 'id';
	const COL_ROLENAME = 'Rolename';

	private $id;
	private $Rolename;

	public function __construct($Rolename, $id = null)
	{
		$this->setId($id);
		$this->setRolename($Rolename);
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
	public function getRolename()
	{
		return $this->Rolename;
	}

	/**
	* @param $Rolename
	* @return $this
	*/
	public function setRolename($Rolename)
	{
		$this->Rolename = $Rolename;
		
		return $this;
	}

}