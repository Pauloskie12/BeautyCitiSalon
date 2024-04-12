<?php 


Class myLibs {
	private $dsn = "mysql:host=localhost;dbname=u679186036_beautyciti_db";
	private $username = "u679186036_beautyciti_db";
	private $password = "BeautyCiti@123";
	private $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	protected $con;

	public function openConnection(){
		try{
			$this->con = new PDO($this->dsn, $this->username, $this->password, $this->option);
			return $this->con;
		}catch(PDOException $e){
			echo "Connection Failed! ".$e->getMessage();
		}

	}

	public function closeConnection(){
		$this->con = null;
	}



}

$lib = new myLibs();


?>