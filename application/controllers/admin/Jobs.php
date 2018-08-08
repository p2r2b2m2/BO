<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->model('common_model');
        $this->load->model('login_model');
				$this->load->helper('download');
				$this->load->helper("URL", "DATE", "URI", "FORM");
				$this->load->library('form_validation');
			//	$this->load->library('upload');

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
							'customer_id' => $_POST['customer_id'],
							'booking_number' => $_POST['booking_number']
					);

						$data = $this->security->xss_clean($data);
						$id = $this->common_model->insert($data, 'jobs');

						//-- Create a document upload folder for this job
						$upload_path = './uploads/job_docs/'.$id;


						if (!is_dir($upload_path)) {
						mkdir($upload_path, 0777, TRUE);
						}


						$this->session->set_flashdata('msg', 'job added Successfully');
						redirect(base_url('admin/jobs/add'));
				}

				$data = array();
				$data['page_title'] = 'Jobs';
				$data['customers'] = $this->common_model->select_customers();
				$data['main_content'] = $this->load->view('admin/jobs/add_job', $data, TRUE);
				$this->load->view('admin/index', $data);
		}


		//-- edit job tab 1. This is the default tab with edit naming convension
		// all other tabs will call their own functions i.e. job_status($id)
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

		public function job_docs($id)
		{
				if ($_POST) {

					 $this->load->library('upload');


					  $config['upload_path'] = './uploads/job_docs/'.$id;
						$config['allowed_types'] = 'gif|jpg|png|pdf|txt|doc|docx|xls|xlsx|csv';
						$config['max_size']     = '0';
 					  $config['overwrite']     = TRUE;
					  $config['remove_spaces']     = TRUE;

					 //echo $config['upload_path'];
				//	return;

				$url = 'uploads/job_docs/'.$id;

				if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
				}


					 $this->load->library('upload', $config);
					 $this->upload->initialize($config);

					 if ( ! $this->upload->do_upload('userfile'))
							 {
								 $this->session->set_flashdata('error_msg', $this->upload->display_errors());
					         redirect(base_url('admin/jobs/job_docs/'.$id));
							 }
							 else

						   $upload_data 	= $this->upload->data();
							 $file_name 	=   $upload_data['file_name'];
							 $url 	=   $url.'/'.$upload_data['file_name'];


							 // Insert Data for current file
							 $data = array(
									 'job_id' => $id,
									 'doc_type_id' => $_POST['doc_type_id'],
									 'url' => $url,
									 'file_name' => $file_name,
									 'uploaded_by' => $this->session->userdata('email'),
									 'uploaded_date' => current_datetime()
							 );

							 $data = $this->security->xss_clean($data);
							 $this->common_model->insert($data,'job_docs');

							 //Create a view containing just the text "Uploaded successfully"
							 $this->session->set_flashdata('msg', 'File Uploaded');
	  						redirect(base_url('admin/jobs/job_docs/'.$id));


					 }

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				$data['jdocs'] = $this->common_model->get_jdocs_by_id($id, 'job_docs');
				$data['dtypes'] = $this->common_model->get_available_doc_types($id);
				$data['main_content'] = $this->load->view('admin/jobs/job_docs', $data, TRUE);
				$this->load->view('admin/index', $data);

		}

private function set_upload_options($id){
	//  upload an image options
    $config = array();
    $config['upload_path'] = 'uploads/job_docs/'.$id;
    $config['allowed_types'] = 'gif|jpg|png|pdf|txt|doc|docx|xsl|xlxs|csv';
    $config['max_size']      = '0';
    $config['overwrite']     = TRUE;
		$config['remove_spaces']     = TRUE;


    return $config;
}

		public function doc_download($id)
		{

		  	$file = $this->common_model->get_item_by_id($id,'job_docs'); //getting all the file details
                                                      //for $file_id (all details are stored in DB)

				$this->load->helper('file');
				$this->load->helper('download');
        $data = file_get_contents($file->url); // Read the file's contents

			  $name = $file->file_name;

			force_download($name,$data);
		}




		public function delete($id)
    {
      // if (($this->common_model->get_constrain('customers','mission_id',$id)) > 0) {
      //   $this->session->set_flashdata('error_msg', 'Missions with customers Cannot be deleted');
      //   redirect(base_url('admin/missions'));
      // }
        $this->common_model->delete($id,'jobs');
				$this->session->set_flashdata('msg', 'Job Deleted');
        redirect(base_url('admin/missions'));
    }




public function delete_doc($id)
{
	  $file = $this->common_model->get_item_by_id($id,'job_docs');
		$job_id = $file->job_id;

		$this->load->helper("file");

		if ( ! unlink($file->url))
				{
					 $this->session->set_flashdata('error_msg', display_errors());
						redirect(base_url('admin/jobs/job_docs/'.$job_id));
							 // $error = array('error' => $this->upload->display_errors());

							 // $this->load->view('upload_form', $error);
				}
				else

		$this->common_model->delete($id,'job_docs');
		$this->session->set_flashdata('msg', 'Document Deleted');
		redirect(base_url('admin/jobs/job_docs/'.$job_id));
}





}
