<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctypes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        $this->load->model('common_model');
    }


    public function index()
    {


        $data = array();
        $data['page_title'] = 'Document Types';
        $data['doctypes'] = $this->common_model->get_doc_types();
        $data['main_content'] = $this->load->view('admin/doc_types/doc_types',$data,TRUE);
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
            $this->common_model->insert($data, 'doc_types');
            $this->session->set_flashdata('msg', 'Document Type added Successfully');
            redirect(base_url('admin/doctypes'));
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
            $this->common_model->edit_option($data, $id, 'doc_types');
            $this->session->set_flashdata('msg', 'Document Type editted Successfully');
            redirect(base_url('admin/doctypes'));
        }
    }


    public function active($id)
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'doc_types');
        $this->session->set_flashdata('msg', 'Document Type activated');
        redirect(base_url('admin/doctypes'));
    }

    public function deactive($id)
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'doc_types');
        $this->session->set_flashdata('msg', 'Document Type deactivated');
        redirect(base_url('admin/doctypes'));
    }

    public function delete($id)
    {
       if (($this->common_model->get_constrain('job_docs','doc_type_id',$id))) {
         $this->session->set_flashdata('error_msg', 'Document Type Cannot be deleted because of existing Jobs');
         redirect(base_url('admin/doctypes'));
       }

        $this->common_model->delete($id,'doc_types');
        $this->session->set_flashdata('msg', 'Document Type Deleted');
        redirect(base_url('admin/doctypes'));
    }

}
