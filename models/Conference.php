            <?php

            namespace SoftUni\Models;

            class Conference
            {
	const COL_ID = 'id';
	const COL_NAME = 'name';
	const COL_DATE = 'date';
	const COL_HALL_ID = 'hall_id';
	const COL_BREAK1 = 'break1';
	const COL_BREAK2 = 'break2';

	private $id;
	private $name;
	private $date;
	private $hall_id;
	private $break1;
	private $break2;

	public function __construct($name, $date, $hall_id, $break1, $break2, $id = null)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setDate($date);
		$this->setHall_id($hall_id);
		$this->setBreak1($break1);
		$this->setBreak2($break2);
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
	public function getName()
	{
		return $this->name;
	}

	/**
	* @param $name
	* @return $this
	*/
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getDate()
	{
		return $this->date;
	}

	/**
	* @param $date
	* @return $this
	*/
	public function setDate($date)
	{
		$this->date = $date;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getHall_id()
	{
		return $this->hall_id;
	}

	/**
	* @param $hall_id
	* @return $this
	*/
	public function setHall_id($hall_id)
	{
		$this->hall_id = $hall_id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getBreak1()
	{
		return $this->break1;
	}

	/**
	* @param $break1
	* @return $this
	*/
	public function setBreak1($break1)
	{
		$this->break1 = $break1;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getBreak2()
	{
		return $this->break2;
	}

	/**
	* @param $break2
	* @return $this
	*/
	public function setBreak2($break2)
	{
		$this->break2 = $break2;
		
		return $this;
	}

}