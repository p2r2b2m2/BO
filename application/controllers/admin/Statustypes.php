<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statustypes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        check_employee();
        $this->load->model('common_model');
        $this->load->model('settings_model');
    }


    public function index()
    {


        $data = array();
        $data['page_title'] = 'Status Types';
        $data['statustypes'] = $this->common_model->get_status_types();
        $data['main_content'] = $this->load->view('admin/status_types/status_types',$data,TRUE);
        $data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index',$data);
    }

    // insert doc type
    public function add()
    {
        if($_POST)
        {
          if($_POST['enable_email'] == '1')
          {
            $template = TRUE;
          }
          else {
            $template = FALSE;
          }
            $data=array(
                'status' => $_POST['status'],
                'enable_email' => $_POST['enable_email'],
                'active_ind' => 1
            );
            $data = $this->security->xss_clean($data);
            $id = $this->common_model->insert($data, 'shipment_status');
            if($template)
            {
              $this->settings_model->insert($id);
              $this->session->set_flashdata('msg', 'Status Type and Email Template added Successfully');
              redirect(base_url('admin/statustypes'));
            }
            $this->session->set_flashdata('msg', 'Status Type added Successfully');
            redirect(base_url('admin/statustypes'));
         }

    }

    // edit doc type
    public function edit()
    {
        if($_POST)
        {
            $id = $_POST['id'];
            if($_POST['enable_email'] == '1')
            {
              $template = TRUE;
            }
            else {
              $template = FALSE;
            }

            $data=array(
                'status' => $_POST['status'],
                'enable_email' => $_POST['enable_email']
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->edit_option($data, $id, 'shipment_status');
            if($template)
            {
              $this->settings_model->insert($id);
              $this->session->set_flashdata('msg', 'Status Type edited and Email Template configured');
              redirect(base_url('admin/statustypes'));
            }
            $this->session->set_flashdata('msg', 'Status Type editted Successfully');
            redirect(base_url('admin/statustypes'));
        }
    }


    public function active($id)
    {
        $data = array(
            'active_ind' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'shipment_status');
        $this->session->set_flashdata('msg', 'Status Type activated');
        redirect(base_url('admin/statustypes'));
    }

    public function deactive($id)
    {
        $data = array(
            'active_ind' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'shipment_status');
        $this->session->set_flashdata('msg', 'Status Type deactivated');
        redirect(base_url('admin/statustypes'));
    }

    public function delete($id)
    {
       if (($this->common_model->get_constrain('status_history','status_id',$id))) {
         $this->session->set_flashdata('error_msg', 'Status Cannot be deleted due to existing history');
         redirect(base_url('admin/statustypes'));
       }
        $this->common_model->delete($id,'shipment_status');
        $this->session->set_flashdata('msg', 'Status type deleted');
        redirect(base_url('admin/statustypes'));
    }

}
