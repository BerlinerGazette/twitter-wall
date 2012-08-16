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
	protected $idStr;

	/**
	 * @var string
	 */
	protected $query;

	/**
	 * @var string
	 */
	protected $fromUser;

	/**
	 * @var string
	 */
	protected $fromUserIdStr;

	/**
	 * @var string
	 */
	protected $fromUserName;

	/**
	 * @var string
	 */
	protected $source;

	/**
	 * @var string
	 */
	protected $text;

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

	public function setIdStr($idStr)
	{
		$this->idStr = (string)$idStr;
		return $this;
	}

	public function getIdStr()
	{
		return $this->idStr;
	}

	public function setQuery($query)
	{
		$this->query = (string)$query;
		return $this;
	}

	public function getQuery()
	{
		return $this->query;
	}

	public function setFromUser($fromUser)
	{
		$this->fromUser = (string)$fromUser;
		return $this;
	}

	public function getFromUser()
	{
		return $this->fromUser;
	}

	public function setFromUserIdStr($fromUserIdStr)
	{
		$this->fromUserIdStr = (string)$fromUserIdStr;
		return $this;
	}

	public function getFromUserIdStr()
	{
		return $this->fromUserIdStr;
	}

	public function setFromUserName($fromUserName)
	{
		$this->fromUserName = (string)$fromUserName;
		return $this;
	}

	public function getFromUserName()
	{
		return $this->fromUserName;
	}

	public function setSource($source)
	{
		$this->source = (string)$source;
		return $this;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function setText($text)
	{
		$this->text = (string)$text;
		return $this;
	}

	public function getText()
	{
		return $this->text;
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
