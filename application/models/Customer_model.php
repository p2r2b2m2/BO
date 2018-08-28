<?php
class Customer_model extends CI_Model {

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

    //-- user role delete function


		//Dashboard counts

  //count_jobs_in_water
		function count_jobs_in_water(){

 		   $sql = 'SELECT COUNT(*) total FROM open_jobs where type = \'Ocean Export\' and sail_date <=CURRENT_DATE';
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







}
