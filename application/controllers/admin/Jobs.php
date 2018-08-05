<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->model('common_model');
        $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Jobs';
        $data['jobs'] = $this->common_model->get_all_jobs();
        $data['main_content'] = $this->load->view('admin/jobs/all_jobs', $data, TRUE);
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

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				//$data['categories'] = $this->common_model->get_categories();
				$data['main_content'] = $this->load->view('admin/jobs/edit_jobs', $data, TRUE);
				$this->load->view('admin/index', $data);

		}

		public function edit_job_status($id)
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

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				//$data['categories'] = $this->common_model->get_categories();
				$data['main_content'] = $this->load->view('admin/jobs/edit_job_status', $data, TRUE);
				$this->load->view('admin/index', $data);

		}


		public function delete($id)
    {
      // if (($this->common_model->get_constrain('customers','mission_id',$id)) > 0) {
      //   $this->session->set_flashdata('error_msg', 'Missions with customers Cannot be deleted');
      //   redirect(base_url('admin/missions'));
      // }
        $this->common_model->delete($id,'missions');
				$this->session->set_flashdata('msg', 'Mission Deleted');
        redirect(base_url('admin/missions'));
    }







}
