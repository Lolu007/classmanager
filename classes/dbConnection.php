<?php
		
class ConnectionDb
{
	var $server;
	var $uname;
	var $pword;
	var $dbase;
		
	function __construct($s,$u,$p,$db)
	{
	
		$this->server=$s;
		$this->uname=$u;
		$this->pword=$p;
		$this->dbase=$db;
			
		//define the mysql connection variables
		define("HOST",$this->server);
		define("USER",$this->uname);
		define("PASS",$this->pword);
		define("DB",$this->dbase);	
	}
		
		
	function opendatabase()
	{
			$db=mysql_pconnect(HOST,USER,PASS);
			try
			{
					if(!$db)
					{
						$exp="Error connecting to database: <br />";
						$exp .= mysql_errno(). ": ".mysql_error();
						throw new exception($exp);
					} 
					else
					{
						mysql_select_db(DB,$db);
					}
					return $db;
			}//end try
			catch(exception $e)
			{
				echo $e->getmessage();
			}//end catch	
	}//end function opendatabase
}//end class ConnectionDb

//class DBConn()
class DBConn
{
	public function DBConn()
	{
		$conn=new ConnectionDb("localhost", "root", "", "classmanager");
		$conn->opendatabase();
	}
	
	public function executeQuery($qry)
	{
		$res=mysql_query($qry) or die(mysql_error());
		return $res;
	}
		
	public function fetchData($qry)
	{
		$res=mysql_query($qry) or die(mysql_error());
		$rs=mysql_fetch_assoc($res);
		return $rs;
	}
		
	function getNumOfRows($qry)
	{
		$res=mysql_query($qry) or die(mysql_error());
		$num=mysql_num_rows($res);
		return $num;
	}
		
}//end class DBConn


///////////////////////another class 4dbconn

class DBConn2
{
	//create the class fields
	private $connection;
	private $query;
	private $resultset;
	private $host;
	private $username;
	private $password;
	private $databaseName;
	
	//create the constructor 
	public function __construct()
	{
		$this->setHost("localhost");
		$this->setDatabaseName("classmanager");
		$this->setUsername("root");
		$this->setPassword("");
		//create the connection link*/
		$this->connection = mysql_connect($this->getHost(),$this->getUsername(),$this->getPassword())or die("Couldn't connect to database:".mysql_error());
		//select the database to use
		$this->setConnection($this->connection);
		mysql_select_db($this->getDatabaseName(),$this->connection)or die(mysql_error());
	}
	
	/**
	 * @return the $connection
	 */
	public function getConnection() 
	{
		return $this->connection;
	}

	/**
	 * @return the $query
	 */
	public function getQuery() 
	{
		return $this->query;
	}

	/**
	 * @return the next row inside the resultset
	 */
	public function getResultset()
	{
		$this->setResultset();
		return $this->resultset;
	}

	/**
	 * @param $connection the $connection to set
	 */
	public function setConnection($connection)
    {
		$this->connection = $connection;
	}

	/**
	 * @param The SQL statement to be executed
	 * @return Returns the resultset if needed but it actually sets the private query
	 */
	public function setQuery($query)
	{
		$this->query =mysql_query($query,$this->getConnection())or die(mysql_error());
		return $this->query;
	}

	/**
	 * @param None. It uses the query previously set
	 */
	public function setResultset()
	{
		$this->resultset = mysql_fetch_array($this->getQuery());
	}
	
	/**
	 * @return Returns the number of rows in a resultset 
	 * (that is the query previously set)
	 */
	function countResultSet()
	{
		return mysql_num_rows($this->getQuery());
	}
	
	public function close()
	{
		mysql_close($this->connection);
		unset($this->connection);
	}
	
	public function getAffectedRows()
	{
		return mysql_affected_rows();
	}
	/**
	 * @return the $host
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @return the $databaseName
	 */
	public function getDatabaseName() {
		return $this->databaseName;
	}

	/**
	 * @param $host the $host to set
	 */
	public function setHost($host) {
		$this->host = $host;
	}

	/**
	 * @param $username the $username to set
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @param $password the $password to set
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @param $databaseName the $databaseName to set
	 */
	public function setDatabaseName($databaseName) 
	{
		$this->databaseName = $databaseName;
	}
	
}//end class dbmanager


?>