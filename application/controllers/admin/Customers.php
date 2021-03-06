<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {

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
        $data['page_title'] = 'Customers';
        $data['customers'] = $this->common_model->get_all_customers();
        $data['main_content'] = $this->load->view('admin/customers/all_customers', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index', $data);
    }

		public function add()
		{
				if ($_POST) {

					$password = $this->random_password();
					$data = array(
							'name' => $_POST['name'],
							'mission_id' => $_POST['mission_id'],
							'email' => $_POST['email'],
							'phone' => $_POST['phone'],
							'street' => $_POST['street'],
							'city' => $_POST['city'],
							'state' => $_POST['state'],
							'zip' => $_POST['zip'],
							'country_id' => $_POST['country_id'],
							'password' => $password
					);

						$data = $this->security->xss_clean($data);
						$email = $this->common_model->check_email_customer($_POST['email']);


            if (empty($email)) {
						$id = $this->common_model->insert($data, 'customers');

						//-- Login creation
						$password = md5($password);
						$data1 = array(
								'customer_id' => $id,
								'password' => $password
						);


						$id1 = $this->common_model->insert($data1, 'customer_login');


						$this->session->set_flashdata('msg', 'Customer added Successfully');
						redirect(base_url('admin/customers'));
					}
					else
					{
						$this->session->set_flashdata('error_msg', 'Email already exist, try another email');
						redirect(base_url('admin/customers/add'));
					}
				}

				$data = array();
				$data['page_title'] = 'Customers';
				$data['missions'] = $this->common_model->select_missions('missions','id');
				$data['country'] = $this->common_model->select_country('country');
				$data['main_content'] = $this->load->view('admin/customers/add_customer', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);
		}


		//-- edit item
		public function edit($id)
		{
				if ($_POST) {

						$data = array(
								'name' => $_POST['name'],
								'mission_id' => $_POST['mission_id'],
								'email' => $_POST['email'],
								'phone' => $_POST['phone'],
								'street' => $_POST['street'],
								'city' => $_POST['city'],
								'state' => $_POST['state'],
								'zip' => $_POST['zip'],
								'country_id' => $_POST['country_id']
						);

						$data = $this->security->xss_clean($data);

						$email = $this->common_model->check_email_customer_edit($_POST['email'],$id);

						if (empty($email)) {
						$this->common_model->update($data, $id, 'customers');

						$this->session->set_flashdata('msg', 'Customer details edited Successfully');
						redirect(base_url('admin/customers'));
					  }
						else {
							$this->session->set_flashdata('error_msg', 'Email is assigned to a different customer');
							redirect(base_url('admin/customers/edit/'.$id));
						}

				}

				$data['customer'] = $this->common_model->get_item_by_id($id, 'customers');
				$data['country'] = $this->common_model->select_country('country');
				$data['missions'] = $this->common_model->select_missions('missions','id');
				$data['main_content'] = $this->load->view('admin/customers/edit_customer', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}

		public function easy_customer(){

			if ($_POST) {

				$password = $this->random_password();
				$data = array(
						'name' => $_POST['name'],
						'mission_id' => $_POST['mission_id'],
						'email' => $_POST['email'],
						'password' => $password
				);

					$data = $this->security->xss_clean($data);
					$email = $this->common_model->check_email_customer($_POST['email']);


					if (empty($email)) {
					$id = $this->common_model->insert($data, 'customers');

					//-- Login creation
					$password = md5($password);
					$data1 = array(
							'customer_id' => $id,
							'password' => $password
					);


					$id1 = $this->common_model->insert($data1, 'customer_login');


					$this->session->set_flashdata('msg', 'Customer added Successfully');
					redirect(base_url('admin/jobs/add/'.$id));
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Email already exist, try another email');
					redirect(base_url('admin/jobs/add/0'));
				}
			}

		}

function random_password()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password = array();
    $alpha_length = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++)
    {
        $n = rand(0, $alpha_length);
        $password[] = $alphabet[$n];
    }
    return implode($password);
}



		public function delete($id)
    {
       if (($this->common_model->get_constrain('jobs','customer_id',$id))) {
         $this->session->set_flashdata('error_msg', 'Customers with Jobs Cannot be deleted');
         redirect(base_url('admin/customers'));
       }
        $this->common_model->delete($id,'customers');
				$this->common_model->delete_with_customer($id,'customer_login');
				$this->session->set_flashdata('msg', 'Customer Deleted');
        redirect(base_url('admin/customers'));
    }







}
