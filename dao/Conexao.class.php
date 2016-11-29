<?php
	class Conexao {
		private $pdo;
		public function __construct() {
			try {
				$db_host = 'pgsql:host=127.0.0.1;port=5432;dbname=SharePrice;';
				$db_user = 'postgres';
				$db_pass = 'postgres';
				$this->pdo = new PDO($db_host, $db_user, $db_pass);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			}
			catch (Exception $e) {
				echo '<pre>';
				print_r($e);
				exit;
			}
		}

		public function getPDO(){
			return $this->pdo;
		}

		public function __destruct(){
			$this->pdo = null;
		}
	}
