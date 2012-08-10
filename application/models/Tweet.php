<?php

class Application_Model_Tweet
{
	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $createdAt;
 
	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
 
	public function __set($name, $value)
	{
		$method = 'set' . ucfirst($name);
		if (('mapper' === $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid property');
		}
		$this->$method($value);
	}
 
	public function __get($name)
	{
		$method = 'get' . ucfirst($name);
		if (('mapper' === $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid property');
		}
		return $this->$method();
	}
 
	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}
 
	public function setId($id)
	{
		$this->id = (int)$id;
		return $this;
	}
 
	public function getId()
	{
		return $this->id;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = (string)$createdAt;
		return $this;
	}
 
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}

