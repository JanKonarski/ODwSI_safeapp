<?php


	abstract class SQL {
		protected $db;

		public function __construct() {
			$this->db = @new mysqli(
				SQL_SERVER,
				SQL_USER,
				SQL_PASSWORD,
				SQL_DATABASE,
				SQL_PORT
			);

			if( $this->db->connect_errno )
				throw new Exception();
		}

		public function __destruct() {
			$this->db->close();
		}
	}

	class SQLUser extends SQL {
		public function get_user_by( $col, $value, $type ) {
			if( !$stmt= $this->db->prepare( sprintf(
				"SELECT
					id
				,	email
				,	password
				,	clock
				,	trys
				,	ip
				,	status
				,	token
				FROM
					user
				WHERE
					%s= ?",
				$col
			 )))
				throw new Exception();
			
			$stmt->bind_param( $type, $value );
			if( !$stmt->execute())
				throw new Exception();
			
			$result= $stmt->get_result();
			if( $result->num_rows != 1 )
				return NULL;
		
			return $result->fetch_assoc();
		}

		public function new_user( $id, $email, $password, $token ): bool {
			if( $this->get_user_by( "email", $email, "s" ) != NULL )
				return false;

			if( !$stmt= $this->db->prepare(
				"INSERT INTO user (id, email, password, clock, status, token) VALUES (?, ?, ?, NOW(), ?, ?)"
			))
				throw new Exception();
			
			$stmt->bind_param( "sssss", $id, $email, $password, $status, $token );
			$status= "inactivate";
			if( !$stmt->execute())
				return false;
			
			return true;
		}

		public function update_user_by( $col1, $value1, $type1, $col2, $value2, $type2 ): bool {
			if( !$stmt= $this->db->prepare( sprintf(
				"UPDATE
					user
				SET
					%s= ?
				WHERE
					%s= ?",
				$col1,
				$col2
			)))
				throw new Exception();

			$stmt->bind_param( sprintf( "%s%s", $type1, $type2 ), $value1, $value2 );
			if( !$stmt->execute())
				return false;

			return true;
		}

		public function active_user( $token ) {
			if(( $data= $this->get_user_by( "token", $token, "s" )) == NULL )
				return false;
			
			if( $data['status'] != 'inactivate' )
				return false;
			
			if( !$this->update_user_by( "status", "activate", "s", "token", $token, "s" ))
				return false;
			
			if( !$this->update_user_by( "token", NULL, "s", "token", $token, "s" ))
				return false;
			
			return $data;
		}
	}

	class SQLMessange extends SQL {
		public function get_message_by( $col, $value, $type ) {
			if( !$stmt= $this->db->prepare( sprintf(
				"SELECT
					id
				,	userId
				,	content
				,	public
				,	encrypted
				FROM
					messange
				WHERE
					%s= ?",
				$col
			)))
				throw new Exception();
			
			$stmt->bind_param( $type, $value );
			if( !$stmt->execute())
				throw new Exception();
			
			$result= $stmt->get_result();
			if( $result->num_rows == 0 )
				return NULL;
		
			return $result; // wszystkie rekordy do tablicy
		}

		public function new_messange( $userId, $content, $public, $encrypt ): bool {
			$id= generate_id();

			if( !$stmt= $this->db->prepare(
				"INSERT INTO messange VALUES (?, ?, ?, ?, ?)"
			))
				throw new Exception();
			
			$stmt->bind_param( "sssss", $id, $userId, $content, $public, $encrypt );
			if( !$stmt->execute())
				return false;
			
			return true;
		}
	}