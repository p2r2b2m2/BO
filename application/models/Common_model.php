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

    //-- delete function
    function delete($id,$table){
        $this->db->delete($table, array('id' => $id));
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
			$query = $this->db->query('SELECT id,first_name FROM customers order by first_name');
				$query = $query->result_array();
				return $query;
		}

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

		function get_mission_by_id($id,$table){
				$this->db->select();
				$this->db->from($table);
				$this->db->where('id', $id);
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



		function get_available_doc_types($id){
		  	$query = $this->db->query('SELECT id,type FROM doc_types WHERE status = 1 AND id NOT IN (SELECT doc_type_id FROM job_docs WHERE job_id  = '.$id.')');
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
				$this->db->select();
				$this->db->from('jobs');
				$this->db->order_by('id', 'ASC');
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


		function get_constrain($table,$field,$id)
		{

			$this->db->select('count(*) as total');
			$this->db->from($table);
			$this->db->where($field, $id);
			$query = $this->db->get();
			$rowcount = $query->num_rows();
			return $rowcount;

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

}
