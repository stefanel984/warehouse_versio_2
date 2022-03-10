<?php


class Document extends MY_Controller
{
	function __construct() {
		parent::__construct();
	}
	function index(){
		$document = $this->document_model->getDocument();
		$type_document = $this->settings_model->getDocType();
		$users = $this->admin_model->getUser();
		$data = array(
			"content"	=> "document/document",
			"tab"       => "Документи",
			"title"     => "Документи",
			"type_document" => $type_document,
			"document"  => $document,
			"users" => $users
		);

		$this->load->view('template',$data);
	}
	function add_document(){
		$all_document_type = $this->settings_model->getDocType();
		$data = array(
			"content"	=> "document/add_document",
			"tab"       => "Документи",
			"document_type" => $all_document_type
		);
		$this->load->view('template',$data);

	}
	function upload_document(){

		$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';

		$upload_path = 'document/';

		$year_array = explode(".",$_POST['date_of_document']);
		$year_folder = $year_array[2];
		$upload_path = $upload_path.$year_folder.'/';
		$config['upload_path']          = './document/'.$year_folder.'/';
		if(!file_exists($upload_path)){
			mkdir($upload_path, 0777, true);
		}
		$date=date_create($_POST['date_of_document']);
		$date_of_document=  date_format($date,"Y-m-d");

		$data = array(
			          'serial_number'=>$_POST['serial_number'],
			          'date_of_document'=>$date_of_document,
			          'date_entered' => date("Y-m-d H:i:s"),
			          'created_by'=> $this->user_info['user_id'],
			          'type' => $_POST['type']
		              );

		$doc_id = $this->document_model->insert($data);
		$this->load->library('upload', $config);
		$files = $_FILES;
		$cpt = count($_FILES['document']['name']);
		for($i=0; $i<$cpt; $i++)
		{
			$_FILES['document']['name']= $files['document']['name'][$i];
			$_FILES['document']['type']= $files['document']['type'][$i];
			$_FILES['document']['tmp_name']= $files['document']['tmp_name'][$i];
			$_FILES['document']['error']= $files['document']['error'][$i];
			$_FILES['document']['size']= $files['document']['size'][$i];

			if($this->upload->do_upload('document')) {
				$data_upload = array('upload_data' => $this->upload->data());
				$data = array(
					'file_path' => $upload_path . $data_upload['upload_data']['file_name'],
					'related_to_doc' => $doc_id
				);
				$this->document_model->insert_doc_upload($data);
			}
		}
		redirect("document/index");

	}
	function document_detail(){
		$doc_id = $this->uri->segment(3);
		$document_upload = $this->document_model->getUploadDocument('related_to_doc',$doc_id);
		$document = $this->document_model->getDocument($doc_id, true);
		$data = array(
			"tab"       => "Прикачени документи",
			"title"      => "Прикачени документи",
			"document_upload" => $document_upload,
			"document" => $document

		);
		$this->load->view('document/document_upload',$data);
	}
	function add_upload_document(){


		$doc_id = $this->uri->segment(3);

		$documents = $this->document_model->getDocument($doc_id);



		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';

		$upload_path = 'document/';

		$year_array = explode("-",$documents[0]['date_of_document']);
		$year_folder = $year_array[0];
		$upload_path = $upload_path.$year_folder.'/';
		$config['upload_path'] = './document/'.$year_folder.'/';

		$this->load->library('upload', $config);
		$files = $_FILES;
		$cpt = count($_FILES['document']['name']);
		for($i=0; $i<$cpt; $i++)
		{
			$_FILES['document']['name']= $files['document']['name'][$i];
			$_FILES['document']['type']= $files['document']['type'][$i];
			$_FILES['document']['tmp_name']= $files['document']['tmp_name'][$i];
			$_FILES['document']['error']= $files['document']['error'][$i];
			$_FILES['document']['size']= $files['document']['size'][$i];

			if($this->upload->do_upload('document')) {
				$data_upload = array('upload_data' => $this->upload->data());
				$data = array(
					'file_path' => $upload_path . $data_upload['upload_data']['file_name'],
					'related_to_doc' => $doc_id
				);
				$this->document_model->insert_doc_upload($data);
			}
		}
		redirect("document/document_detail/".$doc_id);

	}
	function delete_upload_doc(){
		$id = $this->input->post('id');
		$data = array(
			'deleted' => 1,
		);
		$this->document_model->update_doc_upload('id',$id,$data);

		$res = array('result'=>'success');

		echo json_encode($res);


	}
	function delete_document(){
		$id = $this->input->post('id');
		$data = array(
			'deleted' => 1,
		);
		$this->document_model->update('id',$id,$data);

		$data = array(
			'deleted' => 1,
		);
		$this->document_model->update_doc_upload('related_to_doc',$id,$data);

		$res = array('result'=>'success');

		echo json_encode($res);


	}

}
