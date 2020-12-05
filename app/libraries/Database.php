<?php
	/**
	 * PDO Database class
	 * 
	 * Connects to database
	 * Create prepare statements
	 * Bind values
	 * Return rows and results
	 */
	
	Class Database {
		private $dbh;
		private $stmt;
		private $error;
		
		public function __construct()
		{
			require_once 'config/setup.php';
			require 'config/database.php';
			/**	Set DSN	**/
			/**	Try to connect to database	**/
			try {
				$this->dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
			} catch (PDOException $e) {
				if ($e->getCode() == 1049) {
					try {
						$DB_DSN = 'mysql:host='.$DB_HOST;
						$this->dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
						$this->dbh->query('CREATE DATABASE IF NOT EXISTS '.$DB_NAME);
						$this->dbh->query('USE '.$DB_NAME);
						$install = new Install();
						$install->createTables();
						redirect('');
					} catch (PDOException $e) {
						$this->error = $e->getMessage();
						echo $this->error;
					}
				}
				$this->error = $e->getMessage();
				echo $this->error;
			}
		 }
		 /**	Prepare statement for query	**/
		 public function query($sql)
		 {
			 $this->stmt = $this->dbh->prepare(($sql));
		 }
		 /**	Bind values fore the prepeared statements to prevent sql injections	**/
		 public function bind ($param, $value, $type = null)
		 {
			if (is_null(($type))){
				switch (true) {
					case is_int($value):
						$type = PDO::PARAM_INT;
						break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL;
						break;
					case is_null($value):
						$type = PDO::PARAM_NULL;
					break;
					default:
						$type = PDO::PARAM_STR;
						break;
				}
			}
			$this->stmt->bindValue($param, $value, $type);
		 }

		/**	Execute the prepared statement	**/
		public function execute()
		{
			return $this->stmt->execute();
		}

		/**	Get the result set as array of objects	*/
		public function resultSet() {
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}
		/**	Get single record as object	*/
		public function single() {
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		}
		public function rowCount() {
			return $this->stmt->rowCount();
		}
	 }