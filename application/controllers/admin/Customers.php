<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->model('common_model');
        $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Customers';
        $data['customers'] = $this->common_model->get_all_customers();
        $data['main_content'] = $this->load->view('admin/customers/all_customers', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

		public function add()
		{
				if ($_POST) {

					$data = array(
							'first_name' => $_POST['first_name'],
							'last_name' => $_POST['last_name'],
							'mission_id' => $_POST['mission_id'],
							'email' => $_POST['email'],
							'phone' => $_POST['phone']
						//	'street' => $_POST['street'],
						//	'city' => $_POST['city'],
						//	'state' => $_POST['state'],
					//		'zip' => $_POST['zip'],
						//	'country_id' => $_POST['country_id']
					);

						$data = $this->security->xss_clean($data);
						$id = $this->common_model->insert($data, 'customers');

						//-- image upload code


						$this->session->set_flashdata('msg', 'Mission added Successfully');
						$this->session->set_flashdata('tab', 'address');
						redirect(base_url('admin/customers/edit/'.$id));
				}

				$data = array();
				$data['page_title'] = 'Customers';
				$data['missions'] = $this->common_model->select_missions('missions','id');
				$data['main_content'] = $this->load->view('admin/customers/add_customer', $data, TRUE);
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
						$this->common_model->edit_customer($data, $id, 'customers');

						$this->session->set_flashdata('msg', 'Customer details edited Successfully');
						redirect(base_url('admin/customers'));

				}

				$data['customer'] = $this->common_model->get_item_by_id($id, 'customers');
				$data['missions'] = $this->common_model->select_missions('missions','id');
				$data['main_content'] = $this->load->view('admin/customers/edit_customer', $data, TRUE);
				$this->load->view('admin/index', $data);

		}


		public function delete($id)
    {
      // if (($this->common_model->get_constrain('jobs','customer_id',$id)) > 0) {
      //   $this->session->set_flashdata('error_msg', 'Customers with Jobs Cannot be deleted');
      //   redirect(base_url('admin/customers'));
      // }
        $this->common_model->delete($id,'customers');
				$this->session->set_flashdata('msg', 'Customer Deleted');
        redirect(base_url('admin/customers'));
    }







}
