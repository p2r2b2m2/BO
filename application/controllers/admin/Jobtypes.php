<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobtypes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        check_employee();
        $this->load->model('common_model');
    }


    public function index()
    {


        $data = array();
        $data['page_title'] = 'Job Types';
        $data['jobtypes'] = $this->common_model->get_job_types();
        $data['main_content'] = $this->load->view('admin/job_types/job_types',$data,TRUE);
        $data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index',$data);
    }

    // insert doc type
    public function add()
    {
        if($_POST)
        {
            $data=array(
                'type' => $_POST['type'],
                'long_description' => $_POST['long_description'],
                'status' => 1
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->insert($data, 'job_types');
            $this->session->set_flashdata('msg', 'Job Type added Successfully');
            redirect(base_url('admin/jobtypes'));
         }

    }

    // edit doc type
    public function edit()
    {
        if($_POST)
        {
            $id = $_POST['id'];
            $data=array(
                'type' => $_POST['type'],
                'long_description' => $_POST['long_description']
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->edit_option($data, $id, 'job_types');
            $this->session->set_flashdata('msg', 'Job Type editted Successfully');
            redirect(base_url('admin/jobtypes'));
        }
    }


    public function active($id)
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'job_types');
        $this->session->set_flashdata('msg', 'job Type activated');
        redirect(base_url('admin/jobtypes'));
    }

    public function deactive($id)
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'job_types');
        $this->session->set_flashdata('msg', 'Job Type deactivated');
        redirect(base_url('admin/jobtypes'));
    }

    public function delete($id)
    {
       if (($this->common_model->get_constrain('jobs','job_type_id',$id)) > 0) {
         $this->session->set_flashdata('error_msg', 'Job Type Cannot be deleted because of existing jobs');
         redirect(base_url('admin/jobtypes'));
       }

        $this->common_model->delete($id,'job_types');
        $this->session->set_flashdata('msg', 'Job Type Deleted');
        redirect(base_url('admin/jobtypes'));
    }

}
