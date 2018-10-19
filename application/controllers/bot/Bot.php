<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bot extends CI_Controller {

	public function __construct(){
        parent::__construct();
      //  check_login_user();
        //$this->load->model('bot_model');
    }


    public function index(){
			header('Content-Type: application/json');
		 $myObj1 =new \stdClass();
			$myObj1->text = "Pahan Mahakumara was the first name  given from bot api";
			$myObj2 =new \stdClass();
			$myObj2->text = "Udeshika Mendis was the second name  given from bot api";

			$myObj4 =new \stdClass();
			$myObj4 ->text ="Pahan gave this as Text to put in attribute 'text'";
			$myObj4 ->text1 ="And Then Pahan gave this as Text1 to put in attribute 'text1'";



		$myArray = array();    // create array
		$myArray[] = $myObj1;   // add first object
		$myArray[] = $myObj2;

		$myArray1 = array();
		$myArray1[] = $myObj4;

		$myObj3 =new \stdClass();
		$myObj3 ->set_attributes = $myObj4;
		$myObj3 ->messages = $myArray;

//   $myArray = array('messages'=>array($myObj));
//   $myArray = array('messages' =>array('text' => 'Welcome','text' => 'My text'));


	 echo json_encode($myObj3);
	 unset($myObj1);unset($myObj2);unset($myObj3);unset($myObj4);unset($myArray);unset($myArray1);
	 return true;
    }



}
