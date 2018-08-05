<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Category';
        $data['categories'] = $this->common_model->get_categories();
        $data['main_content'] = $this->load->view('admin/category/categories',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    // insert category
    public function add()
    {
        if($_POST)
        {
            $data=array(
                'name' => $_POST['name'],
                'title' => $_POST['title'],
                'parent_id' => 0,
                'status' => 1,
                'created_at' => current_datetime()
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->insert($data, 'category');
            $this->session->set_flashdata('msg', 'Category added Successfully');
            redirect(base_url('admin/category'));
         }

    }

    // edit category
    public function edit()
    {
        if($_POST)
        {
            $id = $_POST['id'];
            $data=array(
                'name' => $_POST['name'],
                'title' => $_POST['title']
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->edit_option($data, $id, 'category');
            $this->session->set_flashdata('msg', 'Category editted Successfully');
            redirect(base_url('admin/category'));
        }
    }


    public function active($id)
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'category');
        $this->session->set_flashdata('msg', 'Category activate Successfully');
        redirect(base_url('admin/category'));
    }

    public function deactive($id)
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'category');
        $this->session->set_flashdata('msg', 'Category deactivate Successfully');
        redirect(base_url('admin/category'));
    }

    public function delete($id)
    {
       if (($this->common_model->get_constrain('items','category_id',$id)) > 0) {
         $this->session->set_flashdata('error_msg', 'Category Cannot be deleted because of existing items');
         redirect(base_url('admin/category'));
       }
        $this->common_model->delete($id,'category');
        echo json_encode(array('st' => 1));
    }

}
