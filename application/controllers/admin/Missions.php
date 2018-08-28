<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Missions extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
				check_employee();
        $this->load->model('common_model');
        $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Missions';
        $data['missions'] = $this->common_model->get_all_missions();
        $data['main_content'] = $this->load->view('admin/missions/all_missions', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index', $data);
    }

		public function add()
		{
				if ($_POST) {

					$data = array(
							'mission_name' => $_POST['mission_name'],
							'street' => $_POST['street'],
							'city' => $_POST['city'],
							'state' => $_POST['state'],
							'zip' => $_POST['zip']
					);

						$data = $this->security->xss_clean($data);
						$id = $this->common_model->insert($data, 'missions');

						//-- image upload code


						$this->session->set_flashdata('msg', 'Mission added Successfully');
						redirect(base_url('admin/missions'));
				}

				$data = array();
				$data['page_title'] = 'Missions';
				//$data['categories'] = $this->common_model->get_categories();
				$data['main_content'] = $this->load->view('admin/missions/add_mission', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);
		}


		//-- edit item
		public function edit($id)
		{
				if ($_POST) {

						$data = array(
								'mission_name' => $_POST['mission_name'],
								'street' => $_POST['street'],
								'city' => $_POST['city'],
								'state' => $_POST['state'],
								'zip' => $_POST['zip']
						);

						$data = $this->security->xss_clean($data);
						$this->common_model->edit_mission($data, $id, 'missions');

						$this->session->set_flashdata('msg', 'Mission edited Successfully');
						redirect(base_url('admin/missions'));

				}

				$data['mission'] = $this->common_model->get_mission_by_id($id, 'missions');
				//$data['categories'] = $this->common_model->get_categories();
				$data['main_content'] = $this->load->view('admin/missions/edit_mission', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}


		public function delete($id)
    {
       if (($this->common_model->get_constrain('customers','mission_id',$id))) {
         $this->session->set_flashdata('error_msg', 'Missions with customers associated with cannot be deleted');
         redirect(base_url('admin/missions'));
       }
        $this->common_model->delete($id,'missions');
				$this->session->set_flashdata('msg', 'Mission Deleted');
        redirect(base_url('admin/missions'));
    }







}
