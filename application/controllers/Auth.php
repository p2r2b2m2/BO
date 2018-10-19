<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('login_model');
    }


    public function index(){
        $data = array();
        $data['page'] = 'Auth';
        $this->load->view('admin/login', $data);
    }


    public function log(){

        if($_POST){

          //Customer check
          $query = $this->login_model->validate_customer();
          //-- if valid
          if($query){
              $data = array();
              foreach($query as $row){
                  $data = array(
                      'id' => $row->id,
                      'customer_id' => $row->customer_id,
                      'name' => $row->name,
                      'email' =>$row->email,
                      'is_login' => TRUE,
                      'type' => 'C'
                  );
                  $this->session->set_userdata($data);
                  $url = base_url('customer/dashboard');
              }
              echo json_encode(array('st'=>1,'url'=> $url)); //--success
          }

          else if($this->login_model->validate_user()){
              $query = $this->login_model->validate_user();
                $data = array();
                foreach($query as $row){
                    $data = array(
                        'id' => $row->id,
                        'name' => $row->first_name,
                        'email' =>$row->email,
                        'role' =>$row->role,
                        'is_login' => TRUE,
                        'type' => 'E'
                    );
                    $this->session->set_userdata($data);
                    $url = base_url('admin/dashboard');
                }
                echo json_encode(array('st'=>1,'url'=> $url)); //--success
            }

            else{
                echo json_encode(array('st'=>0)); //-- error
            }

        }
        else{

            $this->load->view('auth',$data);
        }
    }



    function logout(){
        $this->session->sess_destroy();
        $data = array();
        $data['page'] = 'logout';
        $this->load->view('admin/login', $data);
    }

}
