<?php/** * blogroll model * table name 'mst_blogrolls' **/class B01_model extends RAR_Model{	function ReadB01()	{		//servername,cpu,mem,hdd,uptimeos,linkgw,linkxchng,staging,search,idx,rate,lastupdate		$this->db->select("a.id_monit,(c.nm_inventory),(b.nm_provider),a.cpuinfo,a.meminfo,a.hddinfo,a.uptimeos,a.linkgw,a.linkxchng,a.staging,a.search,a.idx,a.rate,a.last_update");		$this->db->from('mst_monits a');		$this->db->join('mst_providers b','a.operator_id = b.id_provider');		$this->db->join('mst_inventorys c','a.inventory_id = c.id_inventory');		$this->db->where('c.nm_inventory','BANK01');		$this->db->order_by('a.id_monit','DESC');		$SqlRead = $this->db->get();			if($SqlRead->num_rows()!=0){			foreach($SqlRead->result() as $row)			{				$arr[] = $row;			}			echo '{ metaData: { "root": "data" }';			echo ',"success":true,"data":' . json_encode($arr) . ', "totalCount":"'.$SqlRead->num_rows().'" }';		}		else		{			return '({"metaData":"0","data":[]})';		}	}		function readB01usagez()	{		//servername,cpu,mem,hdd,uptimeos,linkgw,linkxchng,staging,search,idx,rate,lastupdate		$this->db->select("*");		$this->db->from('v_g_monits');		$SqlRead = $this->db->get();		if($SqlRead->num_rows()!=0){			foreach($SqlRead->result() as $row)			{				$arr[] = $row;			}			echo '{ metaData: { "root": "data" }';			echo ',"success":true,"data":' . json_encode($arr) . ', "totalCount":"'.$SqlRead->num_rows().'" }';		}		else		{			return '({"metaData":"0","data":[]})';		}	}		function readB01usage($limit=null, $start=null)	{		//servername,cpu,mem,hdd,uptimeos,linkgw,linkxchng,staging,search,idx,rate,lastupdate		$this->db->select("a.id_monit,(c.nm_inventory),(b.nm_provider),a.cpuinfo,a.meminfo,a.hddinfo,a.uptimeos,a.linkgw,a.linkxchng,a.staging,a.search,a.idx,a.rate,a.last_update");		$this->db->from('mst_monits a');		$this->db->join('mst_providers b','a.operator_id = b.id_provider');		$this->db->join('mst_inventorys c','a.inventory_id = c.id_inventory');		$this->db->where('c.nm_inventory','BANK01');		$this->db->order_by('a.id_monit','DESC');		$this->db->limit($limit, $start);		$SqlRead = $this->db->get();		if($SqlRead->num_rows()!=0){			foreach($SqlRead->result() as $row)			{				$arr[] = $row;			}			echo '{ metaData: { "root": "data" }';			echo ',"success":true,"data":' . json_encode($arr) . ', "totalCount":"'.$SqlRead->num_rows().'" }';		}		else		{			return '({"metaData":"0","data":[]})';		}	}}?>