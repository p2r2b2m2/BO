<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* @property settings_model $settings_model */

class Mailing_settings extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        check_login_user();
        check_employee();
        $this->load->library('form_validation');
        $this->load->model('settings_model');
        $this->load->model('common_model');
        $this->load->model('login_model');
        $this->load->helper('email');
        $this->load->library('email');

    }

    function index()
    {
      $data = array();
      $data['page_title'] = 'Email Templates';
      $data['templates'] = $this->common_model->get_all_templates();
      $data['main_content'] = $this->load->view('admin/templates/all_templates', $data, TRUE);
      $data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
      $this->load->view('admin/index', $data);
    }

    function edit($id)
    {
        $this->form_validation->set_error_delimiters("<span class='incorrect'>", "</span>");
        $this->form_validation->set_rules('activation_mail', 'activation_mail', 'trim|valid_email');
        $this->form_validation->set_rules('activation_subject', 'activation_subject', 'trim');
        $this->form_validation->set_rules('activation_content', 'activation_content', 'trim');

        if($this->form_validation->run($this) == FALSE)
        {
            // mail settings //
            $data['id'] = $id;
            $data['activation_mail'] = $this->settings_model->get_option('template_mail',$id);
            $data['activation_subject'] = $this->settings_model->get_option('template_subject',$id);
            $data['activation_content'] = $this->settings_model->get_option('template_content',$id);
            $data['main_content'] = $this->load->view('admin/templates/settings_edit', $data, TRUE);
            $data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
            $this->load->view('admin/index', $data);
        }else{
            $this->settings_model->update($id);
            $this->session->set_flashdata('msg', 'settings successfully updated');
            redirect(base_url('admin/mailing_settings/edit/'.$id));
        }
    }

    function send_mail($id) {

        // add any data you want in this array

        $data_map = array(
            '[[CUSTOMER_NAME]]' => 'Pahan Mahakumara',
            '[[BL_NUMBER]]' => 'BL#2555225',
            '[[STATUS_CODE]]' => 'Deivered',
            '[[COMMENT]]' => 'Your shipment arrived at discharge port and signed by the agent'
        );

        $config['mailtype'] = 'html';
        $this->email->set_newline("\r\n");
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
        $this->email->set_header('Content-type', 'text/html'); //must add this line
        $this->email->initialize($config);
        $this->email->from($this->settings_model->get_option('template_mail',$id), "ASLTracking"); // your mail address
        $this->email->to($this->session->userdata('email')); //  customer mail address
        $this->email->subject($this->settings_model->get_option('template_subject',$id));
        // select template from database
        $template = $this->settings_model->get_option('template_content',$id);
        // make replacement with array against data_mail before send
        $message = str_replace(array_keys($data_map), array_values($data_map), $template);
        // send email
        $this->email->message($message);
        //$this->email->send();

        if ( ! $this->email->send())
            {
              $this->session->set_flashdata('error_msg', 'Email sending error occured.');
                redirect(base_url('admin/mailing_settings/edit/'.$id));
            }
            else
            {
              $this->session->set_flashdata('msg', 'Test Email Sent to '.$this->session->userdata('email'));
              redirect('admin/mailing_settings/edit/'.$id);
            }




    }

}





/* End of file settings.php */
/* Location: ./application/controllers/admin/Settings.php */
