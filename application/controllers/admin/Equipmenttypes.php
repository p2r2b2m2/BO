<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipmenttypes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        $this->load->model('common_model');
    }


    public function index()
    {


        $data = array();
        $data['page_title'] = 'Equipment Types';
        $data['equipmenttypes'] = $this->common_model->get_equipment_types();
        $data['main_content'] = $this->load->view('admin/equipment_types/equipment_types',$data,TRUE);
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
            $this->common_model->insert($data, 'equipment_types');
            $this->session->set_flashdata('msg', 'Equipment Type added Successfully');
            redirect(base_url('admin/equipmenttypes'));
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
            $this->common_model->edit_option($data, $id, 'equipment_types');
            $this->session->set_flashdata('msg', 'Equipment Type editted Successfully');
            redirect(base_url('admin/equipmenttypes'));
        }
    }


    public function active($id)
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'equipment_types');
        $this->session->set_flashdata('msg', 'Equipment Type activated');
        redirect(base_url('admin/equipmenttypes'));
    }

    public function deactive($id)
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'equipment_types');
        $this->session->set_flashdata('msg', 'Equipment Type deactivated');
        redirect(base_url('admin/equipmenttypes'));
    }

    public function delete($id)
    {
       if (($this->common_model->get_constrain('jobs','equipment_type_id',$id)) > 0) {
         $this->session->set_flashdata('error_msg', 'Equipment Type Cannot be deleted because of existing Jobs');
         redirect(base_url('admin/equipmenttypes'));
       }

        $this->common_model->delete($id,'equipment_types');
        $this->session->set_flashdata('msg', 'Equipment Type Deleted');
        redirect(base_url('admin/equipmenttypes'));
    }

}
