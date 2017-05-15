<?php

	class connexion_db
	{
		

		public function connected()
		{
			$con=new mysqli('localhost','root','p!g@','alertAgricole');

			if ($con->connect_errno) {
				# code...
				return $con->connect_errno;
				
			}

			return $con;
		}

		

	}

?>