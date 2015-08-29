<?php/** * blogroll model * table name 'mst_blogrolls' **/class ST01_model extends RAR_Model{	function ReadST01() {
		if (isset ( $_POST ['query'] )) {
			$this->db->select ( 'a.id_inventory,a.nm_inventory,(b.nm_tipe),a.brand,a.sn,a.os,a.ipaddress,a.location' );
			$this->db->from ( 'mst_inventorys a' );
			$this->db->join ( 'mst_tipe b', 'a.tipe_id = b.id_tipe' );
			/* $this->db->where('a.status','1'); */
			$this->db->like ( 'nm_inventory', $_POST ['query'] );
			$SqlRead = $this->db->get ();
		} else {
			$this->db->select ( 'a.id_inventory,a.nm_inventory,(b.nm_tipe),a.brand,a.sn,a.os,a.ipaddress,a.location' );
			$this->db->from ( 'mst_inventorys a' );
			$this->db->join ( 'mst_tipe b', 'a.tipe_id = b.id_tipe' );
			/* $this->db->where('a.status','1'); */
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
	}		function InsertST01() {
		$nm_inventory = $this->input->post ( 'nm_inventory', TRUE );
		$nm_tipe = $this->input->post ( 'nm_tipe', TRUE );		$brand = $this->input->post ( 'brand', TRUE );		$sn = $this->input->post ( 'sn', TRUE );		$os = $this->input->post ( 'os', TRUE );		$ipaddress = $this->input->post ( 'ipaddress', TRUE );		$location = $this->input->post ( 'location', TRUE );
		$dataInsert = array (
				'nm_inventory' => mysql_real_escape_string(strtoupper($nm_inventory)),
				'tipe_id' => mysql_real_escape_string(strtoupper($nm_tipe)),
				'brand' => mysql_real_escape_string(strtoupper($brand)),
				'sn' => mysql_real_escape_string(strtoupper($sn)),
				'os' => mysql_real_escape_string(strtoupper($os)),
				'ipaddress' => mysql_real_escape_string(strtoupper($ipaddress)),
				'location' => mysql_real_escape_string(strtoupper($location))
		);
		$this->db->insert ( 'mst_inventorys', $dataInsert );
	}		function UpdateST01() {		$inventory_id = $this->input->post ( 'id_inventory', TRUE );
		$nm_inventory = $this->input->post ( 'nm_inventory', TRUE );		$nm_tipe = $this->input->post ( 'nm_tipe', TRUE );		$brand = $this->input->post ( 'brand', TRUE );		$sn = $this->input->post ( 'sn', TRUE );		$os = $this->input->post ( 'os', TRUE );		$ipaddress = $this->input->post ( 'ipaddress', TRUE );		$location = $this->input->post ( 'location', TRUE );
		$data = array (
				'nm_inventory' => mysql_real_escape_string(strtoupper($nm_inventory)),				'tipe_id' => mysql_real_escape_string(strtoupper($nm_tipe)),				'brand' => mysql_real_escape_string(strtoupper($brand)),				'sn' => mysql_real_escape_string(strtoupper($sn)),				'os' => mysql_real_escape_string(strtoupper($os)),				'ipaddress' => mysql_real_escape_string(strtoupper($ipaddress)),				'location' => mysql_real_escape_string(strtoupper($location))
		);
		$this->db->where ( 'id_inventory', $inventory_id );
		$this->db->update ( 'mst_inventorys', $data );
	}
	function DelST01() {
		$info = $this->input->post ( "data" );
		$data = json_decode ( stripslashes ( $info ) );
		$id = $data->id_blogroll;
		$this->db->where ( 'id_inventory', $id );
		$this->db->delete ( 'mst_inventorys' );
		return ($this->db->affected_rows () > 0) ? TRUE : FALSE;
		echo json_encode ( array (
				"success" => mysql_errno () == 0,
				"msg" => mysql_errno () == 0 ? "Data cannot be Deleted " : mysql_error () 
		) );
	}		function ReadTipeST01() {
		$this->db->select ( "*" );
		$this->db->from ( 'mst_tipe' );
		$SqlRead = $this->db->get ();
		
		if ($SqlRead->num_rows () != 0) {
			foreach ( $SqlRead->result () as $row ) {
				$arr [] = $row;
			}
			echo '{ metaData: { "root": "tipe"}';
			echo ',"success":true, "tipe":' . json_encode ( $arr ) . '}';
		} else {
			return '({"metaData":"0","tipe":[]})';
		}
	}	}?>