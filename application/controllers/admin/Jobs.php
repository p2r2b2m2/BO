<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
				check_employee();
        $this->load->model('common_model');
        $this->load->model('login_model');
				$this->load->model('settings_model');
				$this->load->helper('download');
				$this->load->helper("URL", "DATE", "URI", "FORM");
				$this->load->library('form_validation');
				$this->load->helper('email');
        $this->load->library('email');
			//	$this->load->library('upload');

    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'All Jobs';
        $data['jobs'] = $this->common_model->get_all_jobs();
        $data['main_content'] = $this->load->view('admin/jobs/all_jobs', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index', $data);
    }

		public function jobs_in_water()
    {
        $data = array();
        $data['page_title'] = 'Jobs In Water';
        $data['jobs'] = $this->common_model->get_jobs_in_water();
        $data['main_content'] = $this->load->view('admin/jobs/all_jobs', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index', $data);
    }

		public function new_jobs()
    {
        $data = array();
        $data['page_title'] = 'New Jobs';
        $data['jobs'] = $this->common_model->get_new_jobs();
        $data['main_content'] = $this->load->view('admin/jobs/all_jobs', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
        $this->load->view('admin/index', $data);
    }

		//jobs_bl_pending
		public function jobs_bl_pending()
 	 {
 			 $data = array();
 			 $data['page_title'] = 'BL Pending Jobs';
 			 $data['jobs'] = $this->common_model->get_bl_pending_jobs();
 			 $data['main_content'] = $this->load->view('admin/jobs/all_jobs', $data, TRUE);
 			 $data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
 			 $this->load->view('admin/index', $data);
 	 }

	 public function pending_emails()
		{
				$data = array();
				$data['page_title'] = 'Pending Emails';
				$data['emails'] = $this->common_model->get_equeue_all();
				$data['main_content'] = $this->load->view('admin/jobs/pending_emails', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);
		}


		public function add()
		{
				if ($_POST) {



					$data = array(
							'customer_id' 			=> $_POST['customer_id'],
							'job_type_id' 			=> $_POST['job_type_id'],
							'job_class' 				=> $_POST['job_class'],
							'invoice_number' 		=> $_POST['invoice_number'],
							'load_port'			 		=> $_POST['load_port'],
							'discharge_port' 		=> $_POST['discharge_port'],
							'final_destination' => $_POST['final_destination']

					);

				  	$data=array_map('trim',$data);

					//	insert into job table
						$data = $this->security->xss_clean($data);
						$id = $this->common_model->insert($data, 'jobs');

						$data1 = array(
							 'asl_reference_no' 			=> $id,
							 'hbl_number'							=> $id
						 );
						 $data1=array_map('trim',$data1);
						 $data1 = $this->security->xss_clean($data1);
						 $this->common_model->update($data1, $id, 'jobs');

						$data2 = array(
							  'job_id'	=> $id,
								'pa_1' => $_POST['pa_1'],
								'pa_2' => $_POST['pa_2'],
								'pa_city' => $_POST['pa_city'],
								'pa_state' => $_POST['pa_state'],
								'pa_zip' => $_POST['pa_zip'],
								'pa_country' => $_POST['pa_country'],
								'da_1' => $_POST['da_1'],
								'da_2' => $_POST['da_2'],
								'da_city' => $_POST['da_city'],
								'da_state_province' => $_POST['da_state_province'],
								'pa_country' => $_POST['pa_country']
							);

				//insert $data2 into job_addr table
				//we may not have values for this table from front end
				//In that case just create a row in job_addr table for this job
				   $data2 = $this->security->xss_clean($data2);

					$data2=array_map('trim',$data2);
					$id2 = $this->common_model->insert($data2, 'job_addr');

					//insert a row for document control
					$data3 = array(
							'job_id'	=> $id
						);

					$id3 = $this->common_model->insert($data3, 'doc_control');

					//add a placeholder BL template_mail
					$this->common_model->insert_bl_templates($id,'bl_generation');
					$this->common_model->insert_bl_templates($id,'hbl_generation');


				//-- Create a document upload folder for this job
						$upload_path = './uploads/job_docs/'.$id;
						if (!is_dir($upload_path)) {
						mkdir($upload_path, 0777, TRUE);
						}


						$this->session->set_flashdata('msg', 'Job Created Successfully');
						redirect(base_url('admin/jobs/edit/'.$id));
				}

				$data = array();
				$data['page_title'] = 'Jobs';
				$data['customers'] = $this->common_model->select_customers();
				$data['jobtypes'] = $this->common_model->select_job_types();
				$data['main_content'] = $this->load->view('admin/jobs/add_job', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);
		}


		//-- edit job tab 1. This is the default tab with edit naming convension
		// all other tabs will call their own functions i.e. job_status($id)
		public function edit($id)
		{
				if ($_POST) {

						$data = array(
							'customer_id' 			=> $_POST['customer_id'],
							'job_type_id' 			=> $_POST['job_type_id'],
							'job_class' 				=> $_POST['job_class'],
							'invoice_number' 		=> $_POST['invoice_number'],
							'hbl_number' 				=> $_POST['hbl_number'],
							'load_port'			 		=> $_POST['load_port'],
							'discharge_port' 		=> $_POST['discharge_port'],
							'final_destination' => $_POST['final_destination']
						);

						$data = $this->security->xss_clean($data);
						$data=array_map('trim',$data);
						$this->common_model->update($data, $id, 'jobs');

						$data2 = array(
								'pa_1' => $_POST['pa_1'],
								'pa_2' => $_POST['pa_2'],
								'pa_city' => $_POST['pa_city'],
								'pa_state' => $_POST['pa_state'],
								'pa_zip' => $_POST['pa_zip'],
								'pa_country' => $_POST['pa_country'],
								'da_1' => $_POST['da_1'],
								'da_2' => $_POST['da_2'],
								'da_city' => $_POST['da_city'],
								'da_state_province' => $_POST['da_state_province'],
								'pa_country' => $_POST['pa_country']
							);

				//insert $data2 into job_addr table
				//we may not have values for this table from front end
				//In that case just create a row in job_addr table for this job
					 $data2 = $this->security->xss_clean($data2);

					$data2=array_map('trim',$data2);
					$id2 = $this->common_model->update_with_job_id($data2,$id,'job_addr');

						$this->session->set_flashdata('msg', 'Job Information Edited Successfully');
						redirect(base_url('admin/jobs/edit/'.$id));

				}

				$this->common_model->save_user_history($id,$this->session->userdata('id'));
				$data['jobs'] = $this->common_model->get_job_info($id);
				$data['customers'] = $this->common_model->select_customers();
				$data['jobtypes'] = $this->common_model->select_job_types();
				$data['jobs_addr'] = $this->common_model->get_item_by_job_id($id,'job_addr');
				$data['main_content'] = $this->load->view('admin/jobs/edit_job', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}

		public function shipinfo($id)
		{
				if ($_POST) {

						$data = array(
							'c_booking_number' 			=> $_POST['c_booking_number'],
							'container_number' 			=> $_POST['container_number'],
							'seal_number' 				=> $_POST['seal_number'],
							'carrier' 						=> $_POST['carrier'],
							'vessel_voyage'			 		=> $_POST['vessel_voyage'],
							'equipment_type_id' 		=> $_POST['equipment_type_id'],
							'bl_number' => $_POST['bl_number'],
							'weight' => $_POST['weight'],
							'measure' => $_POST['measure'],
							'aes_itn' => $_POST['aes_itn'],
							'sail_date' => $_POST['sail_date'],
							'eta' => $_POST['eta']
						);

						$data = $this->security->xss_clean($data);
						$data=array_map('trim',$data);
						$this->common_model->update($data, $id, 'jobs');

						$data2 = array(
								'agent_name' => $_POST['agent_name'],
								'agent_phone' => $_POST['agent_phone'],
								'agent_email' => $_POST['agent_email'],
								'aga_1' => $_POST['aga_1'],
								'aga_2' => $_POST['aga_2'],
								'aga_city' => $_POST['aga_city'],
								'aga_state_province' => $_POST['aga_state_province'],
								'aga_country' => $_POST['aga_country']
							);

				//insert $data2 into job_addr table
				//we may not have values for this table from front end
				//In that case just create a row in job_addr table for this job
					 $data2 = $this->security->xss_clean($data2);

					$data2=array_map('trim',$data2);
					$id2 = $this->common_model->update_with_job_id($data2,$id,'job_addr');

						$this->session->set_flashdata('msg', 'Shipment Information Edited Successfully');
						redirect(base_url('admin/jobs/shipinfo/'.$id));

				}

				$data['jobs'] = $this->common_model->get_ship_info($id);
				$data['equipments'] = $this->common_model->select_equipment_types();
				$data['jobs_addr'] = $this->common_model->get_item_by_job_id($id,'job_addr');
				$data['main_content'] = $this->load->view('admin/jobs/ship_info', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}


		public function doccontrol($id)
		{
				if ($_POST) {

					if(isset($_POST['aes']) && ($_POST['aes'] == 'N')){ $aes = 'N';} else { $aes = '';}
					if(isset($_POST['ins']) && ($_POST['ins'] == 'N')){ $ins = 'N';} else { $ins = '';}
					if(isset($_POST['pl']) && ($_POST['pl'] == 'N')){ $pl = 'N';} else { $pl = '';}
					if(isset($_POST['dr']) && ($_POST['dr'] == 'N')){ $pl = 'N';} else { $dr = '';}
					if(isset($_POST['mlb_sent']) && ($_POST['mlb_sent'] == 'N')){ $mlb_sent = 'N';} else { $mlb_sent = '';}
					if(isset($_POST['mlb_approved']) && ($_POST['mlb_approved'] == 'N')){ $mlb_approved = 'N';} else { $mlb_approved = '';}
					if(isset($_POST['line_paid']) && ($_POST['line_paid'] == 'N')){ $line_paid = 'N';} else { $line_paid = '';}
					if(isset($_POST['mlb_received']) && ($_POST['mlb_received'] == 'N')){ $mlb_received = 'N';} else { $mlb_received = '';}
					if(isset($_POST['ds_to_customer']) && ($_POST['ds_to_customer'] == 'N')){ $ds_to_customer = 'N';} else { $ds_to_customer = '';}
					if(isset($_POST['ds_to_agent']) && ($_POST['ds_to_agent'] == 'N')){ $ds_to_agent = 'N';} else { $ds_to_agent = '';}
					if(isset($_POST['agent_paid']) && ($_POST['agent_paid'] == 'N')){ $agent_paid = 'N';} else { $agent_paid = '';}
					if(isset($_POST['signed_do']) && ($_POST['signed_do'] == 'N')){ $signed_do = 'N';} else { $signed_do = '';}



						$data = array(
							'aes' 			=> $aes,
							'aes_date' 			=> $_POST['aes_date'],
							'ins' 			=> $ins,
							'ins_date' 			=> $_POST['ins_date'],
							'pl' 			=> $pl,
							'pl_date' 			=> $_POST['pl_date'],
							'dr' 			=> $dr,
							'dr_date' 			=> $_POST['dr_date'],
							'mlb_sent' 			=> $mlb_sent,
							'mlb_sent_date' 			=> $_POST['mlb_sent_date'],
							'mlb_approved' 			=> $mlb_approved,
							'mlb_approved_date' 			=> $_POST['mlb_approved_date'],
							'invoiced_date' 			=> $_POST['invoiced_date'],
							'payment_date' 			=> $_POST['payment_date'],
							'payment_comment' 			=> $_POST['payment_comment'],
							'line_paid' 			=> $line_paid,
							'line_paid_date' 			=> $_POST['line_paid_date'],
							'mlb_received' 			=> $mlb_received,
							'mlb_received_date' 			=> $_POST['mlb_received_date'],
							'mlb_received_comment' 			=> $_POST['mlb_received_comment'],
							'ds_to_customer' 			=> $ds_to_customer,
							'ds_to_customer_date' 			=> $_POST['ds_to_customer_date'],
							'ds_to_agent' 			=> $ds_to_agent,
							'ds_to_agent_date' 			=> $_POST['ds_to_agent_date'],
							'agent_paid' 			=> $agent_paid,
							'agent_paid_date' 			=> $_POST['agent_paid_date'],
							'signed_do' 			=> $signed_do,
							'signed_do_date' 			=> $_POST['signed_do_date'],
							'file_closed' 			=> $_POST['file_closed']
						/*	'seal_number' 				=> $_POST['seal_number'],
							'carrier' 						=> $_POST['carrier'],
							'vessel_voyage'			 		=> $_POST['vessel_voyage'],
							'equipment_type_id' 		=> $_POST['equipment_type_id'],
							'bl_number' => $_POST['bl_number'],
							'weight' => $_POST['weight'],
							'measure' => $_POST['measure'],
							'aes_itn' => $_POST['aes_itn'],
							'sail_date' => $_POST['sail_date'],
							'eta' => $_POST['eta'],*/
						);

						$data = $this->security->xss_clean($data);
					//	$data=array_map('trim',$data);
						$this->common_model->update_with_job_id($data, $id, 'doc_control');



						$this->session->set_flashdata('msg', 'Doc Control Information Edited Successfully');
						redirect(base_url('admin/jobs/doccontrol/'.$id));

				}

				$data['jobs'] = $this->common_model->get_item_by_job_id($id, 'doc_control');
				$data['main_content'] = $this->load->view('admin/jobs/doc_control', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}






		public function job_status($id)
		{
				if ($_POST) {

					//check if this status is eligable for an emal updated_by
					$status_id = $_POST['status_id'];
					$domail = $this->common_model->do_email($status_id);

						$data = array(
								'job_id' => $id,
								'status_id' => $_POST['status_id'],
								'comment' => $_POST['comment'],
								'updated_by' => $this->session->userdata('email'),
								'updated_on' => current_datetime()
						);

						$data = $this->security->xss_clean($data);
						$data=array_map('trim',$data);

						//insert the row to status_history table
						$status_history_id = $this->common_model->insert($data, 'status_history');

						//make the linkage between status_history and job table with newest id
						$data1 = array(
							 'status_history_id' 			=> $status_history_id
						 );

						 $this->common_model->update($data1, $id, 'jobs');

						 // if email needs to be sent insert this status update to email_queue
						 if ($domail){

							 $from = $this->settings_model->get_option('template_mail',$status_id);
							 $to = $this->common_model->get_customer_email_by_job($id);
							 $subject = $this->settings_model->get_option('template_subject',$status_id);
							 $content = $this->settings_model->get_option('template_content',$status_id);

							 //Replace the key words with dynamic data
							 $data_map = array(
									 '[[CUSTOMER_NAME]]' => $this->common_model->get_customer_name_by_job($id),
									 '[[BL_NUMBER]]' => $this->common_model->get_bl_number($id),
									 '[[STATUS_CODE]]' => $this->common_model->get_status_description($status_id),
									 '[[COMMENT]]' => $_POST['comment']
							 );

							 $content = str_replace(array_keys($data_map), array_values($data_map), $content);

							 $data2 = array(
	 								'job_id' => $id,
	 								'status_history_id' => $status_history_id,
									'email_from' => $from,
									'email_to' => $to,
									'subject' => $subject,
									'content' => $content
	 						);
						$email_id =	$this->common_model->insert($data2, 'email_queue');

						$this->session->set_flashdata('msg', 'New status added.Email loaded to the queue');
						redirect(base_url('admin/jobs/job_status/'.$id));

						 }



						$this->session->set_flashdata('msg', 'New Status Added Successfully');
						redirect(base_url('admin/jobs/job_status/'.$id));

				}

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				$data['statuses'] = $this->common_model->select_status_types();
				$data['status_hist'] = $this->common_model->get_status_history($id);
				$data['equeue'] = $this->common_model->get_equeue_for_job($id);
				$data['main_content'] = $this->load->view('admin/jobs/job_status', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}

		public function edit_email($id)
		{

			$jobid = $this->common_model->get_job_id_by_children_id($id,'email_queue');

			$this->form_validation->set_error_delimiters("<span class='incorrect'>", "</span>");
			$this->form_validation->set_rules('email_from', 'email_from', 'trim|valid_email');
			//$this->form_validation->set_rules('email_to', 'email_to', 'trim|valid_email');
			$this->form_validation->set_rules('subject', 'subject', 'trim');
			$this->form_validation->set_rules('content', 'content', 'trim');

			if($this->form_validation->run($this) == FALSE)
			{
					// mail settings //
					$data['id'] = $id;
					$data['jobid'] = $jobid;
					$data['email_from'] = $this->common_model->get_option('email_from',$id);
					$data['email_to'] = $this->common_model->get_option('email_to',$id);
					$data['subject'] = $this->common_model->get_option('subject',$id);
					$data['content'] = $this->common_model->get_option('content',$id);
					$data['main_content'] = $this->load->view('admin/jobs/edit_email', $data, TRUE);
					$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
					$this->load->view('admin/index', $data);
			}else{
					$this->common_model->update_email($id);
					$this->session->set_flashdata('msg', 'Email successfully updated');
					redirect(base_url('admin/jobs/edit_email/'.$id));
			}
		}

		public function send_mail($id)
		{
			$jobid = $this->common_model->get_job_id_by_children_id($id,'email_queue');
			$config['mailtype'] = 'html';
			$this->email->set_newline("\r\n");
			$this->email->set_header('MIME-Version', '1.0; charset=utf-8'); //must add this line
			$this->email->set_header('Content-type', 'text/html'); //must add this line
			$this->email->initialize($config);
			$this->email->from($this->common_model->get_option('email_from',$id), "ASLTracking"); // your mail address
			$this->email->to($this->common_model->get_option('email_to',$id)); //  customer mail address
			$this->email->subject($this->common_model->get_option('subject',$id));
			// select template from database
			$message = $this->common_model->get_option('content',$id);
			// make replacement with array against data_mail before send

			// send email
			$this->email->message($message);
			//$this->email->send();

			if ( ! $this->email->send())
					{
						$this->session->set_flashdata('error_msg', 'Email sending error occured.');
							redirect(base_url('admin/jobs/job_status/'.$jobid));
					}
					else
					{
						//email was sent. Next step is to update the email_queue table with sent Information.
						$data = array(
							 'sent' 			=> 1,
							 'sent_date'	=> current_datetime()
						 );

						 $this->common_model->update($data, $id, 'email_queue');

						$this->session->set_flashdata('msg', 'Email Sent to '.$this->common_model->get_option('email_to',$id));
						redirect('admin/jobs/job_status/'.$jobid);
					}

		}

		public function edit_bl($id)
		{

		//	$jobid = $this->common_model->get_job_id_by_children_id($id,'email_queue');

			if ($_POST) {
				$this->common_model->update_bl($id,'bl_generation');
				$this->session->set_flashdata('msg', 'BL Doc changes saved');
				redirect(base_url('admin/jobs/edit_bl/'.$id));
		  	}

					$data['id'] = $id;
					$data['generated_ind'] = $this->common_model->get_bl_content('generated_ind',$id,'bl_generation');
					$data['content'] = $this->common_model->get_bl_content('content',$id,'bl_generation');
					$data['main_content'] = $this->load->view('admin/jobs/edit_bl', $data, TRUE);
					$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
					$this->load->view('admin/index', $data);
		}

		public function edit_bl_data_from_db($id)
		{

		$content = $this->common_model->get_bl_content('content',$id,'bl_generation');

		$dbdata = $this->common_model->get_info_bl_template($id);

		//Replace the key words with dynamic data
		$data_map = array(
				'[[C_NAME]]' 						=> $dbdata->C_NAME,
				'[[ASL_REF]]' 					=> $dbdata->ASL_REF,
				'[[CBN]]'								=> $dbdata->CBN,
				'[[AGENT_NAME]]' 				=> $dbdata->AGENT_NAME,
				'[[AG_ADDR_1]]' 				=> $dbdata->AG_ADDR_1,
				'[[AG_ADDR_2]]' 				=> $dbdata->AG_ADDR_2,
				'[[AG_CITY]]' 					=> $dbdata->AG_CITY,
				'[[AG_STATE_PROVINCE]]' => $dbdata->AG_STATE_PROVINCE,
				'[[AG_COUNTRY]]' 				=> $dbdata->AG_COUNTRY,
				'[[AG_PHONE]]' 					=> $dbdata->AG_PHONE,
				'[[LOAD_PORT]]' 				=> $dbdata->LOAD_PORT,
				'[[PICK_UP_COUNTRY]]' 	=> $dbdata->PICK_UP_COUNTRY,
				'[[VESSEL_VOYAGE]]' 		=> $dbdata->VESSEL_VOYAGE,
				'[[DISCHARGE_PORT]]' 		=> $dbdata->DISCHARGE_PORT,
				'[[FINAL_DESTINATION]]' => $dbdata->FINAL_DESTINATION,
				'[[CONTAINER_NUMBER]]' 	=> $dbdata->CONTAINER_NUMBER,
				'[[SEAL_NUMBER]]' 			=> $dbdata->SEAL_NUMBER,
				'[[EQUIPMENT_TYPE]]' 		=> $dbdata->EQUIPMENT_TYPE,
				'[[AES_NUMBER]]' 				=> $dbdata->AES_NUMBER,
				'[[WEIGHT]]' 						=> $dbdata->WEIGHT,
				'[[MEASUREMENT]]' 			=> $dbdata->MEASUREMENT,
				'[[DATE_TODAY]]'				=> str_replace('-',' ',date('F-j-Y'))//current_date(time()->format('F j Y'))
		);

		$content = str_replace(array_keys($data_map), array_values($data_map), $content);

		$data = array(
				'content' => $content,
				'generated_ind' => '1'
		);

		$this->common_model->update_with_job_id($data,$id,'bl_generation');
		$this->session->set_flashdata('msg', 'Document refreshed from database');
		redirect(base_url('admin/jobs/edit_bl/'.$id));
		}

		//bl_refresh_copy
		public function bl_refresh_copy($id)
		{

		$master_bl_id = 0;

		$content = $this->common_model->get_bl_content('content',$master_bl_id,'bl_generation');

		$data = array(
				'content' => $content,
				'generated_ind' => '0'
		);

		$this->common_model->update_with_job_id($data,$id,'bl_generation');
		$this->session->set_flashdata('msg', 'Document refreshed with master copy');
		redirect(base_url('admin/jobs/edit_bl/'.$id));
		}


		public function create_bl($id)
		{

				$posted_editor = $this->common_model->get_bl_content('content',$id,'bl_generation');
				$file_name = 'MBL_'.$id.'.pdf';
				$path = './uploads/job_docs/'.$id.'/'.$file_name; //specify the file save location and the file name


				$pdf = new \Mpdf\Mpdf(['format' => 'A3']);
				$pdf->WriteHTML($posted_editor);
				$pdf->Output($path,'F');
				$url = 'uploads/job_docs/'.$id.'/'.$file_name;
				$data = array(
						'job_id' => $id,
						'doc_type_id' => $this->common_model->get_doc_id_bl('MBL'),
						'url' => $url,
						'file_name' => $file_name,
						'uploaded_by' => 'SYSTEM/'.$this->session->userdata('email'),
						'uploaded_date' => current_datetime()
				);

				$data = $this->security->xss_clean($data);
				$this->common_model->insert($data,'job_docs');

				$data = array(
						'uploaded' => '1',
						'manually_uploaded' => '0'
				);

				$this->common_model->update_with_job_id($data,$id,'bl_generation');

				$this->session->set_flashdata('msg', 'MBL created and uploaded');
				redirect(base_url('admin/jobs/job_docs/'.$id));
		//	}

	}

		//create_bl
		public function preview_bl($id)
		{

			$mpdf = new \Mpdf\Mpdf(['format' => 'A3']);
			$mpdf->use_kwt = true;

			$html = $this->common_model->get_bl_content('content',$id,'bl_generation');
			$mpdf->use_kwt = true;
			$mpdf->WriteHTML($html);
			$mpdf->Output(); // opens in browser
			$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name


		//	$this->common_model->update_with_job_id($data,$id,'bl_generation');
		 // $this->session->set_flashdata('msg', 'BL created and uploaded');
		//	redirect(base_url('admin/jobs/job_docs/'.$id));
		}

		public function edit_hbl($id)
		{

		//	$jobid = $this->common_model->get_job_id_by_children_id($id,'email_queue');

			if ($_POST) {
				$this->common_model->update_bl($id,'hbl_generation');
				$this->session->set_flashdata('msg', 'HBL Doc changes saved');
				redirect(base_url('admin/jobs/edit_hbl/'.$id));
		  	}

					$data['id'] = $id;
					$data['generated_ind'] = $this->common_model->get_bl_content('generated_ind',$id,'hbl_generation');
					$data['content'] = $this->common_model->get_bl_content('content',$id,'hbl_generation');
					$data['main_content'] = $this->load->view('admin/jobs/edit_hbl', $data, TRUE);
					$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
					$this->load->view('admin/index', $data);
		}

		public function edit_hbl_data_from_db($id)
		{

		$content = $this->common_model->get_bl_content('content',$id,'hbl_generation');

		$dbdata = $this->common_model->get_info_hbl_template($id);

		//Replace the key words with dynamic data
		$data_map = array(
				'[[C_NAME]]' 						=> $dbdata->C_NAME,
				'[[HBL_NUMBER]]' 					=> $dbdata->HBL_NUMBER,
				'[[CBN]]'								=> $dbdata->CBN,
				'[[PICK_UP_ADDR_1]]' 				=> $dbdata->PICK_UP_ADDR_1,
				'[[PICK_UP_ADDR_2]]' 				=> $dbdata->PICK_UP_ADDR_2,
				'[[PICK_UP_CITY]]' 					=> $dbdata->PICK_UP_CITY,
				'[[PICK_UP_STATE]]' => $dbdata->PICK_UP_STATE,
				'[[PICK_UP_ZIP]]' => $dbdata->PICK_UP_ZIP,
				'[[PICK_UP_COUNTRY]]' 				=> $dbdata->PICK_UP_COUNTRY,
				'[[C_PHONE]]' 					=> $dbdata->C_PHONE,
				'[[DEST_ADDR_1]]' 				=> $dbdata->DEST_ADDR_1,
				'[[DEST_ADDR_2]]' 				=> $dbdata->DEST_ADDR_2,
				'[[DEST_CITY]]' 					=> $dbdata->DEST_CITY,
				'[[DEST_STATE_PROVINCE]]' => $dbdata->DEST_STATE_PROVINCE,
				'[[DEST_COUNTRY]]' 				=> $dbdata->DEST_COUNTRY,
				'[[LOAD_PORT]]' 				=> $dbdata->LOAD_PORT,
				'[[PICK_UP_COUNTRY]]' 	=> $dbdata->PICK_UP_COUNTRY,
				'[[VESSEL_VOYAGE]]' 		=> $dbdata->VESSEL_VOYAGE,
				'[[DISCHARGE_PORT]]' 		=> $dbdata->DISCHARGE_PORT,
				'[[FINAL_DESTINATION]]' => $dbdata->FINAL_DESTINATION,
				'[[CONTAINER_NUMBER]]' 	=> $dbdata->CONTAINER_NUMBER,
				'[[SEAL_NUMBER]]' 			=> $dbdata->SEAL_NUMBER,
				'[[EQUIPMENT_TYPE]]' 		=> $dbdata->EQUIPMENT_TYPE,
				'[[AES_NUMBER]]' 				=> $dbdata->AES_NUMBER,
				'[[WEIGHT]]' 						=> $dbdata->WEIGHT,
				'[[MEASUREMENT]]' 			=> $dbdata->MEASUREMENT,
				'[[DATE_TODAY]]'				=> str_replace('-',' ',date('F-j-Y'))//current_date(time()->format('F j Y'))
		);

		$content = str_replace(array_keys($data_map), array_values($data_map), $content);

		$data = array(
				'content' => $content,
				'generated_ind' => '1'
		);

		$this->common_model->update_with_job_id($data,$id,'hbl_generation');
		$this->session->set_flashdata('msg', 'Document refreshed from database');
		redirect(base_url('admin/jobs/edit_hbl/'.$id));
		}

		//bl_refresh_copy
		public function hbl_refresh_copy($id)
		{

		$master_hbl_id = 0;

		$content = $this->common_model->get_bl_content('content',$master_hbl_id,'hbl_generation');

		$data = array(
				'content' => $content,
				'generated_ind' => '0'
		);

		$this->common_model->update_with_job_id($data,$id,'hbl_generation');
		$this->session->set_flashdata('msg', 'Document refreshed with master copy');
		redirect(base_url('admin/jobs/edit_hbl/'.$id));
		}


		public function create_hbl($id)
		{

				$posted_editor = $this->common_model->get_bl_content('content',$id,'hbl_generation');
				$file_name = 'HBL_'.$id.'.pdf';
				$path = './uploads/job_docs/'.$id.'/'.$file_name; //specify the file save location and the file name


				$pdf = new \Mpdf\Mpdf(['format' => 'A3']);
				$pdf->WriteHTML($posted_editor);
				$pdf->Output($path,'F');
				$url = 'uploads/job_docs/'.$id.'/'.$file_name;
				$data = array(
						'job_id' => $id,
						'doc_type_id' => $this->common_model->get_doc_id_bl('HBL'),
						'url' => $url,
						'file_name' => $file_name,
						'uploaded_by' => 'SYSTEM/'.$this->session->userdata('email'),
						'uploaded_date' => current_datetime()
				);

				$data = $this->security->xss_clean($data);
				$this->common_model->insert($data,'job_docs');

				$data = array(
						'uploaded' => '1',
						'manually_uploaded' => '0'
				);

				$this->common_model->update_with_job_id($data,$id,'hbl_generation');

				$this->session->set_flashdata('msg', 'HBL created and uploaded');
				redirect(base_url('admin/jobs/job_docs/'.$id));
		//	}

	}







		public function job_docs($id)
		{
				if ($_POST) {

					 $this->load->library('upload');


					  $config['upload_path'] = './uploads/job_docs/'.$id;
						$config['allowed_types'] = 'gif|jpg|png|pdf|txt|doc|docx|xls|xlsx|csv';
						$config['max_size']     = '0';
 					  $config['overwrite']     = FALSE;
					  $config['remove_spaces']     = TRUE;

					 //echo $config['upload_path'];
				//	return;

				$url = 'uploads/job_docs/'.$id;

				if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
				}


					 $this->load->library('upload', $config);
					 $this->upload->initialize($config);

					 if ( ! $this->upload->do_upload('userfile'))
							 {
								 $this->session->set_flashdata('error_msg', $this->upload->display_errors());
					         redirect(base_url('admin/jobs/job_docs/'.$id));
							 }
							 else

						   $upload_data 	= $this->upload->data();
							 $file_name 	=   $upload_data['file_name'];
							 $url 	=   $url.'/'.$upload_data['file_name'];


							 // Insert Data for current file
							 $data = array(
									 'job_id' => $id,
									 'doc_type_id' => $_POST['doc_type_id'],
									 'url' => $url,
									 'file_name' => $file_name,
									 'uploaded_by' => $this->session->userdata('email'),
									 'uploaded_date' => current_datetime()
							 );

							 $data = $this->security->xss_clean($data);
						   $job_docs_id =  $this->common_model->insert($data,'job_docs');
							 $template = $this->common_model->get_template_type($job_docs_id);

							if($template->template == '1')
					 		{
					 			$this->common_model->set_template_table_manual_upload($id,$template->template_table);
					 		}

							 //Create a view containing just the text "Uploaded successfully"
							 $this->session->set_flashdata('msg', 'File Uploaded');
	  						redirect(base_url('admin/jobs/job_docs/'.$id));


					 }

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				$data['jdocs'] = $this->common_model->get_jdocs_by_id($id, 'job_docs');
				$data['dtypes'] = $this->common_model->get_available_doc_types($id);
				$data['main_content'] = $this->load->view('admin/jobs/job_docs', $data, TRUE);
				$data['recentjobs'] = $this->common_model->recent_jobs($this->session->userdata('id'));
				$this->load->view('admin/index', $data);

		}

private function set_upload_options($id){
	//  upload an image options
    $config = array();
    $config['upload_path'] = 'uploads/job_docs/'.$id;
    $config['allowed_types'] = 'gif|jpg|png|pdf|txt|doc|docx|xsl|xlxs|csv';
    $config['max_size']      = '0';
    $config['overwrite']     = TRUE;
		$config['remove_spaces']     = TRUE;


    return $config;
}

		public function doc_download($id)
		{

		  	$file = $this->common_model->get_item_by_id($id,'job_docs'); //getting all the file details
                                                      //for $file_id (all details are stored in DB)

				$this->load->helper('file');
				$this->load->helper('download');
        $data = file_get_contents($file->url); // Read the file's contents

			  $name = $file->file_name;

			force_download($name,$data);
		}




	/*	public function delete($id)
    {
      // if (($this->common_model->get_constrain('customers','mission_id',$id)) > 0) {
      //   $this->session->set_flashdata('error_msg', 'Missions with customers Cannot be deleted');
      //   redirect(base_url('admin/missions'));
      // }
        $this->common_model->delete($id,'jobs');
				$this->session->set_flashdata('msg', 'Job Deleted');
        redirect(base_url('admin/missions'));
    }
		*/




public function delete_doc($id)
{
	  $file = $this->common_model->get_item_by_id($id,'job_docs');
		$job_id = $file->job_id;

		$this->load->helper("file");

		if ( ! unlink($file->url))
				{
					 $this->session->set_flashdata('error_msg', display_errors());
						redirect(base_url('admin/jobs/job_docs/'.$job_id));
				}
				else

		$doc_type = $this->common_model->get_template_type($id);
		$this->common_model->delete($id,'job_docs');

		if($doc_type->template == '1')

		{
			$this->common_model->reset_template_table($job_id,$doc_type->template_table);
		}

		$this->session->set_flashdata('msg', 'Document Deleted');
		redirect(base_url('admin/jobs/job_docs/'.$job_id));
}

public function delete_email_queue($id)
{

	 $jobid = $this->common_model->get_job_id_by_children_id($id,'email_queue');

	 if (($this->common_model->invalid_delete_email($id))) {
	   $this->session->set_flashdata('error_msg', 'Sent emails cannot be deleted');
	   redirect(base_url('admin/jobs/job_status/'.$jobid));
	 }

		$this->common_model->delete($id,'email_queue');
		$this->session->set_flashdata('msg', 'Email Deleted');
		redirect(base_url('admin/jobs/job_status/'.$jobid));
}







}
