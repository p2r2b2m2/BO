<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
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
        $data['page_title'] = 'Jobs';
        $data['jobs'] = $this->common_model->get_all_jobs();
        $data['main_content'] = $this->load->view('admin/jobs/all_jobs', $data, TRUE);
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
							 'asl_reference_no' 			=> 'ASL'.$id
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
					$this->common_model->insert_bl_template($id);


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

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				$data['customers'] = $this->common_model->select_customers();
				$data['jobtypes'] = $this->common_model->select_job_types();
				$data['jobs_addr'] = $this->common_model->get_item_by_job_id($id,'job_addr');
				$data['main_content'] = $this->load->view('admin/jobs/edit_job', $data, TRUE);
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

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				$data['equipments'] = $this->common_model->select_equipment_types();
				$data['jobs_addr'] = $this->common_model->get_item_by_job_id($id,'job_addr');
				$data['main_content'] = $this->load->view('admin/jobs/ship_info', $data, TRUE);
				$this->load->view('admin/index', $data);

		}


		public function doccontrol($id)
		{
				if ($_POST) {

						$data = array(
							'aes' 			=> $_POST['aes'],
							'aes_date' 			=> $_POST['aes_date'],
							'ins' 			=> $_POST['ins'],
							'ins_date' 			=> $_POST['ins_date'],
							'pl' 			=> $_POST['pl'],
							'pl_date' 			=> $_POST['pl_date'],
							'dr' 			=> $_POST['dr'],
							'dr_date' 			=> $_POST['dr_date'],
							'mlb_sent' 			=> $_POST['mlb_sent'],
							'mlb_sent_date' 			=> $_POST['mlb_sent_date'],
							'mlb_approved' 			=> $_POST['mlb_approved'],
							'mlb_approved_date' 			=> $_POST['mlb_approved_date'],
							'invoiced_date' 			=> $_POST['invoiced_date'],
							'payment_date' 			=> $_POST['payment_date'],
							'payment_comment' 			=> $_POST['payment_comment'],
							'line_paid' 			=> $_POST['line_paid'],
							'line_paid_date' 			=> $_POST['line_paid_date'],
							'mlb_received' 			=> $_POST['mlb_received'],
							'mlb_received_date' 			=> $_POST['mlb_received_date'],
							'mlb_received_comment' 			=> $_POST['mlb_received_comment'],
							'ds_to_customer' 			=> $_POST['ds_to_customer'],
							'ds_to_customer_date' 			=> $_POST['ds_to_customer_date'],
							'ds_to_agent' 			=> $_POST['ds_to_agent'],
							'ds_to_agent_date' 			=> $_POST['ds_to_agent_date'],
							'agent_paid' 			=> $_POST['agent_paid'],
							'agent_paid_date' 			=> $_POST['agent_paid_date'],
							'signed_do' 			=> $_POST['signed_do'],
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
						$data=array_map('trim',$data);
						$this->common_model->update_with_job_id($data, $id, 'doc_control');



						$this->session->set_flashdata('msg', 'Doc Control Information Edited Successfully');
						redirect(base_url('admin/jobs/doccontrol/'.$id));

				}

				$data['jobs'] = $this->common_model->get_item_by_job_id($id, 'doc_control');
				$data['main_content'] = $this->load->view('admin/jobs/doc_control', $data, TRUE);
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
				$this->load->view('admin/index', $data);

		}

		public function edit_email($id)
		{

			$jobid = $this->common_model->get_job_id_by_children_id($id,'email_queue');

			$this->form_validation->set_error_delimiters("<span class='incorrect'>", "</span>");
			$this->form_validation->set_rules('email_from', 'email_from', 'trim|valid_email');
			$this->form_validation->set_rules('email_to', 'email_to', 'trim|valid_email');
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
				$this->common_model->update_bl($id);
				$this->session->set_flashdata('msg', 'BL Doc changes saved');
				redirect(base_url('admin/jobs/edit_bl/'.$id));
		  	}

					$data['id'] = $id;
					$data['generated_ind'] = $this->common_model->get_bl_content('generated_ind',$id);
					$data['content'] = $this->common_model->get_bl_content('content',$id);
					$data['main_content'] = $this->load->view('admin/jobs/edit_bl', $data, TRUE);
					$this->load->view('admin/index', $data);
		}

		public function edit_bl_data_from_db($id)
		{

		$content = $this->common_model->get_bl_content('content',$id);

		//Replace the key words with dynamic data
		$data_map = array(
				'[[COMPANY_NAME]]' => 'AIR SEA LAND SHIPPING AND MOVING INC.'
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

		$content = $this->common_model->get_bl_content('content',$master_bl_id);

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
			//if((isset($_POST['content'])) && (!empty(trim($_POST['content'])))) //if content of CKEditor ISN'T empty
		//	{
				$posted_editor = $this->common_model->get_bl_content('content',$id);//$_POST['content']; //get content of CKEditor
				$path = './uploads/job_docs/'.$id.'/BL.pdf'; //specify the file save location and the file name


				$pdf = new \Mpdf\Mpdf(['format' => 'A3']);
			//	define('_MPDF_TTFONTDATAPATH', sys_get_temp_dir()."/");
				$pdf->WriteHTML($posted_editor);
				$pdf->Output($path,'F');
				$url = 'uploads/job_docs/'.$id.'/BL.pdf';
				$data = array(
						'job_id' => $id,
						'doc_type_id' => $this->common_model->get_doc_id_bl(),
						'url' => $url,
						'file_name' => 'BL.pdf',
						'uploaded_by' => $this->session->userdata('email'),
						'uploaded_date' => current_datetime()
				);

				$data = $this->security->xss_clean($data);
				$this->common_model->insert($data,'job_docs');
				$this->session->set_flashdata('msg', 'BL created and uploaded');
				redirect(base_url('admin/jobs/job_docs/'.$id));
		//	}

	}

	function exportPDF($text,$path)
	{
		try
		{
			$pdf = new \Mpdf\Mpdf(['format' => 'A3']);
			$pdf->WriteHTML($text);
			$pdf->Output($path,'F'); //$pdf->Output('../files/example.pdf','F');

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
		//create_bl
		public function create_bl_1($id)
		{

			$mpdf = new \Mpdf\Mpdf(['format' => 'A3']);
			$mpdf->use_kwt = true;

			$html = $this->common_model->get_bl_content('content',$id);
			$mpdf->use_kwt = true;
			$mpdf->WriteHTML($html);
			$mpdf->Output(); // opens in browser
			$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name


		//	$this->common_model->update_with_job_id($data,$id,'bl_generation');
		 // $this->session->set_flashdata('msg', 'BL created and uploaded');
		//	redirect(base_url('admin/jobs/job_docs/'.$id));
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
							 $this->common_model->insert($data,'job_docs');

							 //Create a view containing just the text "Uploaded successfully"
							 $this->session->set_flashdata('msg', 'File Uploaded');
	  						redirect(base_url('admin/jobs/job_docs/'.$id));


					 }

				$data['jobs'] = $this->common_model->get_mission_by_id($id, 'jobs');
				$data['jdocs'] = $this->common_model->get_jdocs_by_id($id, 'job_docs');
				$data['dtypes'] = $this->common_model->get_available_doc_types($id);
				$data['main_content'] = $this->load->view('admin/jobs/job_docs', $data, TRUE);
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




		public function delete($id)
    {
      // if (($this->common_model->get_constrain('customers','mission_id',$id)) > 0) {
      //   $this->session->set_flashdata('error_msg', 'Missions with customers Cannot be deleted');
      //   redirect(base_url('admin/missions'));
      // }
        $this->common_model->delete($id,'jobs');
				$this->session->set_flashdata('msg', 'Job Deleted');
        redirect(base_url('admin/missions'));
    }




public function delete_doc($id)
{
	  $file = $this->common_model->get_item_by_id($id,'job_docs');
		$job_id = $file->job_id;

		$this->load->helper("file");

		if ( ! unlink($file->url))
				{
					 $this->session->set_flashdata('error_msg', display_errors());
						redirect(base_url('admin/jobs/job_docs/'.$job_id));
							 // $error = array('error' => $this->upload->display_errors());

							 // $this->load->view('upload_form', $error);
				}
				else

		$this->common_model->delete($id,'job_docs');
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

public function bl_test()
	{
		$mpdf = new \Mpdf\Mpdf(['format' => 'A3']);
		$mpdf->use_kwt = true;
		$html = '<title></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<div class="container" style="min-width: 245px;max-width: 1920px;position: relative;padding: 10px;border: 1px dotted #ddd;background-color: #eee;">
		<div class="header" style="border: 1px dotted #ddd;min-height: 800px;border-radius: 5px 5px 0 0;background-color: #fff;padding: 10px 0;">
		<h3 dir="ltr" style="text-align: center;">&nbsp; &nbsp; &nbsp;<strong><span style="font-size:16px;"> </span><span style="color:#0000FF;"><span style="font-size:14px;">AIR SEA LAND SHIPPING &amp; MOVING INC.</span><span style="font-size:16px;">&nbsp; </span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:12px;">BILL OF LADING</span></span></strong></h3>

		<h5 dir="ltr" style="text-align: center;"><span style="font-size:12px;"><font color="#0000ff"><b>FMC-OTI No.024377NF&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;FOR PORT-TO-PORT OR COMBINED TRANSPORT</b></font></span></h5>
		<style type="text/css">.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;border-left:none;border-right: none;font-size:14px;padding: 0px 2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg th{font-family:Arial, sans-serif;border-left:none;border-right: none;font-size:14px;font-weight:normal;padding:0px 2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
		.tg .tg-cpu2{border-color:#000000;vertical-align:top}
		.tg .tg-us36{border-color:inherit;vertical-align:top}
		@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;}}
		</style>
		<div class="tg-wrap">
		<table align="center" border="0" cellpadding="0" class="tg" dir="ltr" style="height:500px;width:800px;">
			<tbody>
				<tr>
					<td class="tg-cpu2" colspan="2" rowspan="2">
					<p><span style="font-size:10px;"><strong><span style="color:#0000FF;">SHIPPER</span></strong></span><br />
					<span style="font-size:10px;"><strong>AIR SEA LAND SHIPPING &amp;MOVING INC<br />
					AS AGENT FOR MR. IMMANUEL HAMUNYELA<br />
					211 EAST 43RD ST, SUIT # 1206<br />
					NEW YORK, NY 10017</strong></span></p>
					</td>
					<td class="tg-us36">
					<p><strong style="font-family: Arial, sans-serif; font-size: 14px;"><span style="font-size:10px;"><span style="color: rgb(0, 0, 255);">REFERENCE<span style="font-size: 12px;"><span style="color: rgb(0, 0, 255);"> </span></span>NO</span></span><span style="font-size: 12px;"><span style="color: rgb(0, 0, 255);">.</span></span></strong><br />
					<span style="font-size:10px;"><strong>003570-00</strong></span></p>
					</td>
					<td class="tg-us36">
					<p><strong style="font-family: Arial, sans-serif; font-size: 14px;"><span style="font-size:10px;"><span style="color: rgb(0, 0, 255);">CARRIER BOOKING<span style="font-size: 12px;"><span style="color: rgb(0, 0, 255);"> </span></span>NO.</span></span></strong><br />
					<span style="font-size:10px;"><strong>965840633</strong></span></p>
					</td>
				</tr>
				<tr>
					<td class="tg-us36" colspan="2">
					<p><span style="font-size:10px;"><font color="#0000ff"><b>EXPORT REFERENCES</b></font></span><br />
					<span style="font-size:10px;"><strong>003570-00</strong></span></p>
					</td>
				</tr>
				<tr>
					<td class="tg-us36" colspan="2" rowspan="2">
					<p><strong style="font-family: Arial, sans-serif; font-size: 14px;"><span style="font-size:10px;"><span style="color: rgb(0, 0, 255);">CONSIGNEE - ( NOT NEOTIABLE UNLESS CONSIGNED TO<span style="font-size: 12px;"><span style="color: rgb(0, 0, 255);"> </span></span>ORDER)</span></span></strong><br />
					<span style="font-size:10px;"><strong>MR.&nbsp;&nbsp;</strong><span style="font-family: Arial, sans-serif;"><strong>IMMANUEL HAMUNYELA<br />
					C/O STUTTSFOED VAN LINES<br />
					7-9 DANZING STREET<br />
					LAFRENZ, WINDHOEK NAMIBIA<br />
					TEL : 264 61 22 4691</strong></span></span></p>
					</td>
					<td class="tg-us36" colspan="2"><b style="color: rgb(0, 0, 255); font-family: Arial, sans-serif; font-size: 12px;"><span style="font-size:10px;">FORWARDING AGENT</span> - <span style="font-size:10px;">Reference</span></b><br />
					<strong style="font-family: Arial, sans-serif; font-size: 10px;">003570-00</strong></td>
				</tr>
				<tr>
					<td class="tg-us36" colspan="2"><span style="font-size:10px;"><font color="#0000ff"><b>POINT AND COUNTRY OF ORIGIN</b></font></span><br />
					<span style="font-size: 10px;"><b>UNITED STATES OF AMERICA</b></span></td>
				</tr>
				<tr>
					<td class="tg-us36" colspan="2" rowspan="2"><span style="font-size:10px;"><font color="#0000ff"><b>NOTIFY PARTY</b></font></span><br />
					<b style="font-family: Arial, sans-serif; font-size: 10px;">WORLD NET LOGISTICS (PTY) LTD<br />
					LANGER HEINRICH STREET, SAPHIER PARK UNIT 8 , NEW INDUS TRAIL AREA<br />
					WALVIS BAY NAMIBIA.<br />
					EMAIL: EXAMPLE@ONE.COM<br />
					TEL: 2245666552</b></td>
					<td class="tg-us36" colspan="2" rowspan="2"><b style="color: rgb(0, 0, 255); font-family: Arial, sans-serif; font-size: 12px;"><span style="font-size:10px;">ALSO NOTIFY - ROUTING</span> <span style="font-size:10px;">INSTRUCTIONS</span></b></td>
				</tr><tr><span style="color:#0000FF;"></span></tr>
				<tr>
					<td class="tg-us36"><span style="font-size:10px;"><font color="#0000ff"><b>PIER</b></font></span></td>
					<td class="tg-us36"><span style="font-size:10px;"><font color="#0000ff"><b>PLACE OF RECEIPT by PRE-CARRIER</b></font></span></td>
					<td class="tg-us36" colspan="2" rowspan="3"><span style="font-size:10px;"><font color="#0000ff"><b>RELEASE AGENT</b></font></span></td>
				</tr>
				<tr>
					<td class="tg-us36"><span style="font-size:10px;"><font color="#0000ff"><b>VESSEL AND VOYAGE NUMBER</b></font></span><br />
					<span style="font-size: 10px;"><b>CONTI EVEREST 832E</b></span></td>
					<td class="tg-us36"><span style="font-size:10px;"><font color="#0000ff"><b>PORT OF LOADING</b></font></span><br />
					<span style="font-size: 10px;"><b>NEWARK</b></span></td>
				</tr>
				<tr>
					<td class="tg-us36"><span style="font-size:10px;"><font color="#0000ff"><b>PORT OF DISCHARGE</b></font></span><br />
					<span style="font-size: 10px;"><b>WALVIS BAY, NAMIBIA</b></span></td>
					<td class="tg-us36"><span style="font-size:10px;"><font color="#0000ff"><b>PLACE OF DELIVERY</b></font></span><br />
					<b style="font-family: Arial, sans-serif; font-size: 10px;">WALVIS BAY, NAMIBIA</b></td>
				</tr>
			</tbody>
		</table>
		</div>

		<p dir="ltr">&nbsp;</p>

		<p dir="ltr">&nbsp;</p>
		</div>

		<p dir="ltr" style="text-align: center;"><span style="font-size: 12px;"><b>www.airsealandinc.net</b></span></p>
		</div>';
		$mpdf->use_kwt = true;
		$mpdf->WriteHTML($html);
		$mpdf->Output(); // opens in browser
	//	$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
	}





}
