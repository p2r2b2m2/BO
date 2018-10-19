<?php
class Common_model extends CI_Model {

    //-- insert function
	public function insert($data,$table){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    //-- edit function
    function edit_option($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    }

		function edit_mission($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    }


    //-- update function
    function update($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    }

		function update_with_job_id($action, $id, $table){
				$this->db->where('job_id',$id);
				$this->db->update($table,$action);
				return;
		}

    //-- delete function
    function delete($id,$table){
        $this->db->delete($table, array('id' => $id));
        return;
    }

		//delete_with_customer
		function delete_with_customer($id,$table){
        $this->db->delete($table, array('customer_id' => $id));
        return;
    }

    //-- user role delete function
    function delete_user_role($id,$table){
        $this->db->delete($table, array('user_id' => $id));
        return;
    }


    //-- select function
    function select($table){
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

//$query = $this->db->query('YOUR QUERY HERE');

//DROP DOWNS START
		function select_country($table){
			$query = $this->db->query('SELECT 0 as id, \'select\' as name UNION SELECT id,name FROM country order by id');
				$query = $query->result_array();
				return $query;
		}

		function select_missions($table,$orderby){
			$query = $this->db->query('SELECT 0 as id, \'None\' as mission_name UNION SELECT id,mission_name FROM missions order by '.$orderby.'');
				$query = $query->result_array();
				return $query;
		}



		function select_customers(){
			$query = $this->db->query('SELECT c.id,concat(c.name,\' \',IFNULL(m.mission_name,\'\')) as name ,m.mission_name  FROM customers c left join missions m ON c.mission_id = m.id order by c.name');
				$query = $query->result_array();
				return $query;
		}

		function select_job_types(){
			$query = $this->db->query('SELECT id,type FROM job_types WHERE status = 1 ORDER BY type');
				$query = $query->result_array();
				return $query;
		}


		function select_equipment_types(){
			$query = $this->db->query('SELECT 0 as id, \' select\' as type UNION SELECT id,type FROM equipment_types WHERE status = 1 ORDER BY type');
				$query = $query->result_array();
				return $query;
		}


		function get_available_doc_types($id){
				$query = $this->db->query('SELECT id,type FROM doc_types WHERE status = 1 AND id NOT IN (SELECT doc_type_id FROM job_docs WHERE job_id  = '.$id.')');
				$query = $query->result_array();
				return $query;
		}

		function select_status_types(){
			$query = $this->db->query('SELECT id,status,enable_email FROM shipment_status WHERE active_ind = 1 ORDER BY status');
				$query = $query->result_array();
				return $query;
		}


		//END OF DROP DOWNS



    //-- select by id
    function select_option($id,$table){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    //-- select by id
    function get_item_by_id($id,$table){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

		function get_item_by_job_id($id,$table){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('job_id', $id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

		function get_mission_by_id($id,$table){
				$this->db->select();
				$this->db->from($table);
				$this->db->where('id', $id);
				$query = $this->db->get();
				$query = $query->row();
				return $query;
		}

		function get_info_bl_template($id){
				$this->db->select();
				$this->db->from('v_bl_template');
				$this->db->where('id', $id);
				$query = $this->db->get();
				$query = $query->row();
				return $query;
		}

		function get_info_hbl_template($id){
				$this->db->select();
				$this->db->from('v_hbl_template');
				$this->db->where('id', $id);
				$query = $this->db->get();
				$query = $query->row();
				return $query;
		}


//get_ship_info
		function get_ship_info($id){
			$this->db->select('j.*, bl.uploaded');
			$this->db->from('jobs j');
			$this->db->join('bl_generation bl', 'bl.job_id = j.id');
			$this->db->where('j.id', $id);
			$query = $this->db->get();
			$query = $query->row();
			return $query;
		}

		//get_job_info
		function get_job_info($id){
			$this->db->select('j.*, bl.uploaded');
			$this->db->from('jobs j');
			$this->db->join('hbl_generation bl', 'bl.job_id = j.id');
			$this->db->where('j.id', $id);
			$query = $this->db->get();
			$query = $query->row();
			return $query;
		}



		function get_jdocs_by_id($id,$table){
			$this->db->select('jd.*, dt.type as type');
			$this->db->from('job_docs jd');
			$this->db->join('doc_types dt', 'dt.id = jd.doc_type_id');
			$this->db->where('jd.job_id', $id);
			$this->db->order_by('jd.id', 'DESC');
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

    //get category
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        return $query->row();
    }


    //-- get categories
    function get_categories(){
        $this->db->select();
        $this->db->from('category');
        $this->db->where('parent_id', 0);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

		function get_doc_types(){
				$this->db->select();
				$this->db->from('doc_types');
				$this->db->order_by('type', 'ASC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}

		//get_template_type
		function get_template_type($id){
			$this->db->select('dt.*');
			$this->db->from('job_docs jd');
			$this->db->join('doc_types dt', 'dt.id = jd.doc_type_id');
			$this->db->where('jd.id', $id);
			$query = $this->db->get();
			$query = $query->row();
			return $query;
		}




function get_equipment_types(){
		$this->db->select();
		$this->db->from('equipment_types');
		$this->db->order_by('type', 'ASC');
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
}


	function get_job_types(){
		$this->db->select();
		$this->db->from('job_types');
		$this->db->order_by('type', 'ASC');
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}



		function get_status_types(){
				$this->db->select();
				$this->db->from('shipment_status');
				$this->db->order_by('status', 'ASC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}


		//get_status_history
		function get_status_history($id){
				$this->db->select('h.*,s.status');
				$this->db->from('status_history h');
				$this->db->join('shipment_status s', 's.id = h.status_id');
				$this->db->where('h.job_id', $id);
				$this->db->order_by('h.updated_on', 'DESC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}

		//get_equeue_for_job
		function get_equeue_for_job($id){
				$this->db->select('e.*,h.comment,s.status');
				$this->db->from('status_history h');
				$this->db->join('email_queue e', 'e.status_history_id = h.id');
				$this->db->join('shipment_status s', 's.id = h.status_id');
				$this->db->where('h.job_id', $id);
				$this->db->order_by('e.sent', 'ASC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}

		function get_equeue_all(){
				$this->db->select('e.*,h.comment,s.status,j.asl_reference_no');
				$this->db->from('status_history h');
				$this->db->join('email_queue e', 'e.status_history_id = h.id');
				$this->db->join('shipment_status s', 's.id = h.status_id');
				$this->db->join('jobs j', 'j.id = h.job_id');
				$this->db->where('e.sent', 0);
				$this->db->order_by('e.sent', 'ASC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}

	//	get_customer_email_by_job
	function get_customer_email_by_job($id){
			$this->db->select('c.email');
			$this->db->from('jobs j');
			$this->db->join('customers c', 'c.id = j.customer_id');
			$this->db->where('j.id', $id);
			$query = $this->db->get();
			return $query->row()->email;
	}

	//get_customer_name
	function get_customer_name_by_job($id){
			$this->db->select('c.name as name');
			$this->db->from('jobs j');
			$this->db->join('customers c', 'c.id = j.customer_id');
			$this->db->where('j.id', $id);
			$query = $this->db->get();
			return $query->row()->name;
	}

 //get_bl_number
 function get_bl_number($id){
		 $this->db->select('bl_number');
		 $this->db->from('jobs ');
		 $this->db->where('id', $id);
		 $query = $this->db->get();
		 return $query->row()->bl_number;
 }

 //get_status_description
 function get_status_description($id){
 		$this->db->select('status');
 		$this->db->from('shipment_status ');
 		$this->db->where('id', $id);
 		$query = $this->db->get();
 		return $query->row()->status;
 }

 function get_job_id_by_children_id($id,$table){
		 $this->db->select('job_id');
		 $this->db->from($table);
		 $this->db->where('id', $id);
		 $query = $this->db->get();
		 return $query->row()->job_id;
 }

 function get_doc_id_bl($doctype){
		 $this->db->select('id');
		 $this->db->from('doc_types');
		 $this->db->where('type', $doctype);
		 $query = $this->db->get();
		 return $query->row()->id;
 }


    //-- get sub categories
    function get_sub_categories(){
        $this->db->select();
        $this->db->from('category');
        $this->db->where('parent_id !=', 0);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    //-- get categories
    function get_all_items(){
        $this->db->select('items.*, category.name as category_name');
        $this->db->from('items');
        $this->db->join('category', 'category.id = items.category_id');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

		function get_all_missions(){
				$this->db->select();
				$this->db->from('missions');
				$this->db->order_by('mission_name', 'ASC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}



		function get_all_jobs(){
				$this->db->select('j.id,j.asl_reference_no,j.invoice_number,c.name as customer,m.mission_name,jt.type,CASE WHEN j.sail_date = \'0000-00-00\' THEN NULL ELSE j.sail_date END AS sail_date,CASE WHEN j.eta = \'0000-00-00\' THEN NULL ELSE j.eta END AS eta');
				$this->db->from('jobs j');
				$this->db->join('customers c','c.id = j.customer_id');
				$this->db->join('missions m','m.id = c.mission_id','LEFT');
				$this->db->join('job_types jt','jt.id = j.job_type_id');
				$this->db->order_by('j.id', 'DESC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}

		function get_jobs_in_water(){

			 $sql = 'SELECT * FROM open_jobs where type = \'Ocean Export\' and sail_date <=CURRENT_DATE';
			 $query = $this->db->query($sql);
			 $query = $query->result_array();
			 return $query;
	 }

	 //get_new_jobs WHERE create_date >= DATE_SUB( CURDATE( ) , INTERVAL 30 DAY )
	 function get_new_jobs(){
			 $this->db->select('j.id,j.asl_reference_no,j.invoice_number,c.name as customer,m.mission_name,jt.type,CASE WHEN j.sail_date = \'0000-00-00\' THEN NULL ELSE j.sail_date END AS sail_date,CASE WHEN j.eta = \'0000-00-00\' THEN NULL ELSE j.eta END AS eta');
			 $this->db->from('jobs j');
			 $this->db->join('customers c','c.id = j.customer_id');
			 $this->db->join('missions m','m.id = c.mission_id','LEFT');
			 $this->db->join('job_types jt','jt.id = j.job_type_id');
			 $this->db->where('create_date >= DATE_SUB( CURDATE( ) , INTERVAL 30 DAY )');
			 $this->db->order_by('j.id', 'DESC');
			 $query = $this->db->get();
			 $query = $query->result_array();
			 return $query;
	 }

	 //get_bl_pending_jobs
	 //'INNER JOIN bl_generation bl ON bl.job_id = j.id AND jt.type = \'Ocean Export\' AND bl.uploaded = 0';
	 function get_bl_pending_jobs(){
			 $this->db->select('j.id,j.asl_reference_no,j.invoice_number,c.name as customer,m.mission_name,jt.type,CASE WHEN j.sail_date = \'0000-00-00\' THEN NULL ELSE j.sail_date END AS sail_date,CASE WHEN j.eta = \'0000-00-00\' THEN NULL ELSE j.eta END AS eta');
			 $this->db->from('jobs j');
			 $this->db->join('customers c','c.id = j.customer_id');
			 $this->db->join('missions m','m.id = c.mission_id','LEFT');
			 $this->db->join('job_types jt','jt.id = j.job_type_id');
			 $this->db->join('bl_generation bl','bl.job_id = j.id');
			 $this->db->where('jt.type','Ocean Export');
			 $this->db->where('bl.uploaded',0);
			 $this->db->order_by('j.id');
			 $query = $this->db->get();
			 $query = $query->result_array();
			 return $query;
	 }


		//get_dashboard_jobs
		function get_dashboard_jobs(){
				$this->db->select();
				$this->db->from('open_jobs');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}

		function get_all_customers(){
				$this->db->select('c.*');
				$this->db->select('m.mission_name as mission, m.id as mission_id');
				$this->db->select('co.name as country, co.id as country_id');
				$this->db->from('customers c');
				$this->db->join('missions m','m.id = c.mission_id','LEFT');
				$this->db->join('country co','co.id = c.country_id','LEFT');
				$this->db->order_by('c.id','DESC');
				$query = $this->db->get();
				$query = $query->result_array();
				return $query;
		}


		function get_all_templates(){
			$query = $this->db->query('SELECT s.id,s.status,CASE WHEN s.enable_email = 1 THEN \'Y\' ELSE \'N\' END AS \'email\' FROM tboptions o inner join shipment_status s on s.id = o.shipment_staus_id where o.shipment_staus_id <> 0 GROUP BY s.id,s.status,CASE WHEN s.enable_email = 1 THEN \'Y\' ELSE \'N\' END');
				$query = $query->result_array();
				return $query;
		}

		function get_constrain($table,$field,$id)
		{

			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($field, $id);
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() >= 1) {
					return true;
			}else{
					return false;
			}

		}

		function iscurrent_status($jobid,$id){

			$this->db->select('*');
			$this->db->from('jobs');
			$this->db->where('id', $jobid);
			$this->db->where('status_history_id', $id);
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() >= 1) {
					return true;
			}else{
					return false;
			}
		}

		function unlink_status_history($jobid,$id){
			$sql = 'UPDATE jobs SET status_history_id = NULL WHERE id = '.$jobid.' AND status_history_id = '.$id.'';
			$this->db->query($sql);

		}

		function link_max_status_history($jobid,$id){
			$sql = 'UPDATE jobs SET status_history_id = (SELECT MAX(id)FROM status_history WHERE job_id = '.$jobid.' AND id <> '.$id.') WHERE id = '.$jobid.'';
			$this->db->query($sql);

		}


		//invalid_delete_email
		function invalid_delete_email($id)
		{

			$this->db->select('*');
			$this->db->from('email_queue');
			$this->db->where('id', $id);
			$this->db->where('sent', '1');
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() >= 1) {
					return true;
			}else{
					return false;
			}

		}


		function do_email($id){
			$this->db->select('*');
			$this->db->from('shipment_status');
			$this->db->where('id', $id);
			$this->db->where('enable_email','1');
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() >= 1) {
					return true;
			}else{
					return false;
			}


		}


    //-- check user role power
    function check_power($type){
        $this->db->select('ur.*');
        $this->db->from('user_role ur');
        $this->db->where('ur.user_id', $this->session->userdata('id'));
        $this->db->where('ur.action', $type);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function check_email($email){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return $query->result();
        }else{
            return false;
        }
    }

		public function check_email_customer($email){
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return $query->result();
        }else{
            return false;
        }
    }

		public function check_email_customer_edit($email,$id){
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('email', $email);
				$this->db->where('id !=', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return $query->result();
        }else{
            return false;
        }
    }

    public function check_exist_power($id){
        $this->db->select('*');
        $this->db->from('user_power');
        $this->db->where('power_id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return $query->result();
        }else{
            return false;
        }
    }


    //-- get all power
    function get_all_power($table){
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('power_id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- get logged user info
    function get_user_info(){
        $this->db->select('u.*');
        $this->db->select('c.name as country_name');
        $this->db->from('user u');
        $this->db->join('country c','c.id = u.country','LEFT');
        $this->db->where('u.id',$this->session->userdata('id'));
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    //-- get single user info
    function get_single_user_info($id){
        $this->db->select('u.*');
        $this->db->select('c.name as country_name');
        $this->db->from('user u');
        $this->db->join('country c','c.id = u.country','LEFT');
        $this->db->where('u.id',$id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }

    //-- get single user info
    function get_user_role($id){
        $this->db->select('ur.*');
        $this->db->from('user_role ur');
        $this->db->where('ur.user_id',$id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    //-- get all users with type 2
    function get_all_user(){
        $this->db->select('u.*');
        $this->db->select('c.name as country, c.id as country_id');
        $this->db->from('user u');
        $this->db->join('country c','c.id = u.country','LEFT');
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    //-- count active, inactive and total user
    function get_user_total(){
        $this->db->select('*');
        $this->db->select('count(*) as total');
        $this->db->select('(SELECT count(user.id)
                            FROM user
                            WHERE (user.status = 1)
                            )
                            AS active_user',TRUE);

        $this->db->select('(SELECT count(user.id)
                            FROM user
                            WHERE (user.status = 0)
                            )
                            AS inactive_user',TRUE);

        $this->db->select('(SELECT count(user.id)
                            FROM user
                            WHERE (user.role = "admin")
                            )
                            AS admin',TRUE);

        $this->db->from('user');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    //-- image upload function with resize option
    function upload_image($max_size){

            //-- set upload path
            $config['upload_path']  = "./assets/images/";
            $config['allowed_types']= 'gif|jpg|png|jpeg';
            $config['max_size']     = '92000';
            $config['max_width']    = '92000';
            $config['max_height']   = '92000';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload("photo")) {


                $data = $this->upload->data();

                //-- set upload path
                $source             = "./assets/images/".$data['file_name'] ;
                $destination_thumb  = "./assets/images/thumbnail/" ;
                $destination_medium = "./assets/images/medium/" ;
                $main_img = $data['file_name'];
                // Permission Configuration
                chmod($source, 0777) ;

                /* Resizing Processing */
                // Configuration Of Image Manipulation :: Static
                $this->load->library('image_lib') ;
                $img['image_library'] = 'GD2';
                $img['create_thumb']  = TRUE;
                $img['maintain_ratio']= TRUE;

                /// Limit Width Resize
                $limit_medium   = $max_size ;
                $limit_thumb    = 200 ;

                // Size Image Limit was using (LIMIT TOP)
                $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;

                // Percentase Resize
                if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                    $percent_medium = $limit_medium/$limit_use ;
                    $percent_thumb  = $limit_thumb/$limit_use ;
                }

                //// Making THUMBNAIL ///////
                $img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
                $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_thumb-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = ' 100%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_thumb ;

                $thumb_nail = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                ////// Making MEDIUM /////////////
                $img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
                $img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_medium-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = '100%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_medium ;

                $mid = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                //-- set upload path
                $images = 'assets/images/medium/'.$mid;
                $thumb  = 'assets/images/thumbnail/'.$thumb_nail;
                unlink($source) ;

                return array(
                    'images' => $images,
                    'thumb' => $thumb
                );
            }
            else {
                echo "Failed! to upload image" ;
            }

    }

		function update_email($id)
    {
        $this->db->where('id',$id);
        //shipment_staus_id
        $this->db->set('email_from',$this->input->post('email_from'));
        $this->db->update('email_queue');

				$this->db->where('id',$id);
        $this->db->set('email_to',$this->input->post('email_to'));
        $this->db->update('email_queue');

				$this->db->where('id',$id);
        $this->db->set('subject',$this->input->post('subject'));
        $this->db->update('email_queue');

				$this->db->where('id',$id);
        $this->db->set('content',$this->input->post('content'));
        $this->db->update('email_queue');

    }

		function get_option($Field,$id)
    {
         $this->db->where('id',$id);
         $this->db->select($Field);
         $result= $this->db->get('email_queue');
        return $result->row()->$Field;
    }

		//get_bl_content

		function get_bl_content($Field,$id,$table)
		{
				 $this->db->where('job_id',$id);
				 $this->db->select($Field);
				 $result= $this->db->get($table);
				return $result->row()->$Field;
		}

		function update_bl($id,$table)
    {
				$this->db->where('job_id',$id);
        $this->db->set('content',$this->input->post('content',FALSE));
        $this->db->update($table);

    }

		function reset_template_table($id,$table)
		{
			$this->db->where('job_id',$id);
			$this->db->set('generated_ind','0');
			$this->db->set('uploaded','0');
			$this->db->set('manually_uploaded','0');
			$this->db->update($table);
		}

		//set_template_table_manual_upload
		function set_template_table_manual_upload($id,$table)
		{
			$this->db->where('job_id',$id);
			$this->db->set('generated_ind','0');
			$this->db->set('uploaded','1');
			$this->db->set('manually_uploaded','1');
			$this->db->update($table);
		}


		function insert_bl_templates($id,$table)
    {
      $sql = 'INSERT INTO '.$table.' (job_id,content)
      select '.$id.',content
      from '.$table.'
      where job_id = 0
      and NOT EXISTS(
      select job_id,content  from '.$table.' where job_id= '.$id.')
      LIMIT 1';
      $this->db->query($sql);

    }

		//Dashboard counts

  //count_jobs_in_water
		function count_jobs_in_water(){

 		   $sql = 'SELECT COUNT(*) total FROM open_jobs where type = \'Ocean Export\' and sail_date <=CURRENT_DATE';
 			 $query = $this->db->query($sql);
 			 return $query->row()->total;
 	 }


 //count_pending_mails
	 function count_pending_mails(){

			$sql = 'SELECT COUNT(*) total FROM email_queue WHERE sent = 0';
			$query = $this->db->query($sql);
			return $query->row()->total;
	}


	 //count_new_jobs
	 function count_new_jobs(){

	 	 $sql = 'SELECT COUNT(*) total FROM jobs WHERE create_date >= DATE_SUB( CURDATE( ) , INTERVAL 30 DAY )';
	 	 $query = $this->db->query($sql);
	 	 return $query->row()->total;
	 }


	 //count_pending_bl
	 function count_pending_bl(){

			$sql = 'SELECT COUNT(*) total FROM jobs j INNER JOIN job_types jt ON jt.id = j.job_type_id INNER JOIN bl_generation bl ON bl.job_id = j.id AND jt.type = \'Ocean Export\' AND bl.uploaded = 0';
			$query = $this->db->query($sql);
			return $query->row()->total;
	}

	function save_user_history($job_id,$user_id){

		$sql = 'DELETE FROM recent_jobs WHERE user_id = '.$user_id.' AND job_id = '.$job_id.'';
		$this->db->query($sql);

		$sql = 'INSERT INTO recent_jobs (user_id,job_id) SELECT '.$user_id.','.$job_id.'';
		$this->db->query($sql);

		$sql = 'DELETE FROM recent_jobs WHERE user_id = '.$user_id.' AND id NOT IN (select id from (select id FROM recent_jobs WHERE user_id = '.$user_id.' ORDER BY create_date DESC LIMIT 5) x)';
		$this->db->query($sql);

	}

	function recent_jobs($id)
	{
	 $this->db->select();
 	 $this->db->from('recent_jobs');
	 $this->db->where('user_id',$id);
 	 $this->db->order_by('create_date', 'DESC');
	 $this->db->limit(5);
 	 $query = $this->db->get();
 	 $query = $query->result_array();
 	 return $query;

	}

	function validatepassword($password){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('id', $this->session->userdata('id'));
		$this->db->where('password', md5($password));
		$this->db->where('status', '1');
		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			 return true;
		}
		else{
				return false;
		}
	}





}
