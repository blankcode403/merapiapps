<?php/** * blogroll model * table name 'mst_blogrolls' **/class ST02_model extends RAR_Model{	function ReadST02() {
		if (isset ( $_POST ['query'] )) {
			$this->db->select ( '*' );
			$this->db->from ( 'mst_users' );
			/* $this->db->where('status','1'); */
			$this->db->like ( 'username', $_POST ['query'] );
			$SqlRead = $this->db->get ();
		} else {
			$this->db->select ( '*' );
			$this->db->from ( 'mst_users' );
			/* $this->db->where('status','1'); */
			$SqlRead = $this->db->get ();
		}
		
		if ($SqlRead->num_rows () != 0) {
			foreach ( $SqlRead->result () as $row ) {
				$arr [] = $row;
			}
			echo '{ metaData: { "root": "data" }';
			echo ',"success":true,"data":' . json_encode ( $arr ) . ', "totalCount":"' . $SqlRead->num_rows () . '" }';
		} else {
			return '({"metaData":"0","data":[]})';
		}
	}		function InsertST02() {		$now = date('Y-m-d H:i:s');
		$username = $this->input->post ( 'username', TRUE );
		$group_id = $this->input->post ( 'group_id', TRUE );		$email = $this->input->post ( 'email', TRUE );		$passwd = md5($this->input->post ( 'passwd', TRUE ));		$crton = date('Y-m-d H:i:s',now());		$modfon = date('Y-m-d H:i:s',now());		$status = $this->input->post ( 'status', TRUE );
		$dataInsert = array (
				'username' => $username,
				'group_id' => $group_id,
				'email' => $email,
				'passwd' => $passwd,
				'create_on' => $crton,				'modified_on' => $modfon,				'status' => $status,
		);
		$this->db->insert ( 'mst_users', $dataInsert );
	}		function UpdateST02() {		$now = date('Y-m-d H:i:s');		$id_user = $this->input->post ( 'id_user', TRUE );
		$username = $this->input->post ( 'username', TRUE );		$group_id = $this->input->post ( 'group_id', TRUE );		$email = $this->input->post ( 'email', TRUE );		$passwd = md5($this->input->post ( 'passwd', TRUE ));		$crton = date('Y-m-d H:i:s',now());		$modfon = date('Y-m-d H:i:s',now());		$status = $this->input->post ( 'status', TRUE );
		$data = array (
				'username' => $username,				'group_id' => $group_id,				'email' => $email,				'passwd' => $passwd,				'create_on' => $crton,				'modified_on' => $modfon,				'status' => $status,
		);
		$this->db->where ( 'id_user', $id_user );
		$this->db->update ( 'mst_users', $data );
	}
	function DelST02() {
		$info = $this->input->post ( "data" );
		$data = json_decode ( stripslashes ( $info ) );
		$id = $data->id_user;
		$this->db->where ( 'id_user', $id );
		$this->db->delete ( 'mst_users' );
		return ($this->db->affected_rows () > 0) ? TRUE : FALSE;
		echo json_encode ( array (
				"success" => mysql_errno () == 0,
				"msg" => mysql_errno () == 0 ? "Data cannot be Deleted " : mysql_error () 
		) );
	}	}?>