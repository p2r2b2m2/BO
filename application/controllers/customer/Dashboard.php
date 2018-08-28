<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->model('customer_model');
    }


    public function index(){
        $data = array();
        $data['page_title'] = 'Dashboard';
        //$data['count'] = $this->common_model->get_user_total();
			//	$data['jobs'] = $this->common_model->get_dashboard_jobs();
			//	$data['jw'] = $this->common_model->count_jobs_in_water();
			 // $data['eq'] = $this->common_model->count_pending_mails();
			//	$data['nj'] = $this->common_model->count_new_jobs();
			//	$data['bl'] = $this->common_model->count_pending_bl();
      //  $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
			//	$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('customer/index');
    }



}
