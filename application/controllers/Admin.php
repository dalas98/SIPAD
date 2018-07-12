<?php 
defined('BASEPATH') OR exit ('No direct script access allowed');

	/**
	 * 
	 */
	class Admin extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			if (!$this->session->has_userdata('status')) {
				redirect('login');
			}else if($this->session->userdata('divisi') =='Kasatker'){
				redirect('kasatker');
			}
			else if($this->session->userdata('bagian') =='PPK'){
				redirect('ppk1');
			}
		}

		public function index () 
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$data['jmluser'] = $this->Datauser_model->JumlahUser();
			$data['jmlppk'] = $this->Datappk_model->JumlahPPK();
			$this->load->view('admin/dashboard' , $data);
			$this->load->view('admin/footer');
		}

		public function inputkasatker ()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$this->load->view('admin/inputkasatker');
			$this->load->view('admin/footer1');
		}

		public function daftarkasatker ()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$this->load->view('admin/daftarkasatker');
			$this->load->view('admin/footer1');
		}

		public function daftaruser () 
		{
			$this->load->view('admin/header');
			$data['user'] = $this->Datauser_model->datauser();
			$this->load->view('admin/sidebar');
			$this->load->view('admin/daftaruser', $data);
			$this->load->view('admin/footer1');
		}

		public function daftarppk () 
		{
			$this->load->view('admin/header');
			$data['get_ppk']=$this->Datappk_model->datappk();
			$this->load->view('admin/sidebar');
			$this->load->view('admin/daftarppk', $data);
			$this->load->view('admin/footer1');
		}
		public function inputppk ()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$this->load->view('admin/inputppk');
			$this->load->view('admin/footer1');
		}		
		public function inputtahun ()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$this->load->view('admin/inputtahun');
			$this->load->view('admin/footer1');	
		}
		public function createuser ()
		{
			$this->load->view('admin/header');
			$data = array ('get_ppk' => $this->Datappk_model->datappk());
			$this->load->view('admin/sidebar');
			$this->load->view('admin/createuser',$data);
			$this->load->view('admin/footer1');
		}
		public function profile ()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$this->load->view('admin/profile');
			$this->load->view('admin/footer1');
		}
		public function changepassword ()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$this->load->view('admin/changepassword');
			$this->load->view('admin/footer1');
		}
		// Fungsi Tambah Akun PPK
		public function TambahAkun ()
		{
			$this->form_validation->set_rules('nip', 'NIP' ,'trim|required|numeric|max_length[12]');
			$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
			$this->form_validation->set_rules('divisi', 'Divisi' , 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('username','Username', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/header');
				$this->load->view('admin/sidebar');
				$this->load->view('admin/createuser');
				$this->load->view('admin/footer1');
			}
			else {
				$nip 		= $this->input->post('nip');
				$nama 		= $this->input->post('nama');
				$divisi 	= $this->input->post('divisi');
				$email 		= $this->input->post('email');
				$alamat 	= $this->input->post('alamat');
				$username   = $this->input->post('username');
				$this->load->library('generate_token');
				$password 	= $this->generate_token->get_token(8);
				// $password 	= $this->input->post('password');
				$data = array
				(
					'id_user'		=> $this->Penomoran_model->IDDaftar(),
					'nip'			=> $nip,
					'nama'			=> $nama,
					'bagian'		=> 'PPK',
					'email'			=> $email,
					'alamat'		=> $alamat,
					'username'		=> $username,
					'password'		=> md5($password),
					// 'password'		=> $password,
					'foto'			=> "user1.jpg",
					'id_ppk'		=> $divisi
				);
				$resultchecknip = $this->Datauser_model->ceknipuser($nip);
				if ($resultchecknip > 0) {
					$this->session->set_flashdata('nipsalah','true');
					redirect('admin/createuser');
				}
				else {
					$input = $this->Datauser_model->Tambahuser($data,'user');
					if ($input > 0) {
						$this->load->library('email');
					    $config = array();
					    $config['charset'] = 'utf-8';
					    $config['useragent'] = 'Codeigniter';
					    $config['protocol']= "smtp";
					    $config['mailtype']= "html";
					    $config['smtp_host']= "ssl://smtp.mail.yahoo.com";//pengaturan smtp
					    $config['smtp_port']= "465";
					    $config['smtp_timeout']= "400";
					    $config['smtp_user']= "hans.inside@yahoo.com"; // isi dengan email kamu
					    $config['smtp_pass']= "tangerang030298"; // isi dengan password kamu
					    $config['crlf']="\r\n"; 
					    $config['newline']="\r\n"; 
					    $config['wordwrap'] = TRUE;
					    //memanggil library email dan set konfigurasi untuk pengiriman email
					   
					    $this->email->initialize($config);
					    //konfigurasi pengiriman
					    $this->email->from($config['smtp_user']);
					    $this->email->to($email);
					    $this->email->subject("Notifikasi");
					    $this->email->message(
					     "Selamat , ".$nama." akun anda berhasil dibuat harap  login dengan password ".$password
					    );
				  
				    if($this->email->send())
				    {
						$this->session->set_flashdata('berhasil','true');
						redirect(base_url('admin/createuser'));	
						// echo "berhasil";
					}
						}
					else{
						$this->session->set_flashdata('gagal','true');
						redirect(base_url('admin/createuser'));
					}			
				}
			}			
		}

		//Fungsi Tambah PPK
		public function TambahPPK()
		{
			$this->form_validation->set_rules('nama', 'Nama PPK', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/header');
				$this->load->view('admin/sidebar');
				$this->load->view('admin/inputppk');
				$this->load->view('admin/footer1');
			}
			else {
				$nama       = $this->input->post('nama');
				$keterangan = $this->input->post('keterangan');
				$data = array (
					'id_ppk' 	 => $this->Penomoran_model->IDPPK(),
					'nama'		 => $nama,
					'keterangan' => $keterangan
				);
				$input = $this->Datappk_model->Tambahppk($data,'ppk');
					if ($input > 0) {
						$this->session->set_flashdata('berhasil','true');
						redirect(base_url('admin/inputppk'));
					}
					else{
						$this->session->set_flashdata('gagal','true');
						redirect(base_url('admin/inputppk'));
					}			
			}
		}
		//Fungsi Edit PPK
		public function editppk ($id_ppk)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$data = array ('get_ppk' => $this->Datappk_model->datappk());
			$ppk = $this->Datappk_model->GetWherePPK("where id_ppk ='$id_ppk'");
			$data = array (
				"id_ppk" => $ppk[0]['id_ppk'],
				"nama" => $ppk[0]['nama'],
				"keterangan" => $ppk[0]['keterangan'],
			);
			$this->load->view('admin/editppk', $data);
			$this->load->view('admin/footer1');
		}
		//Fungsi Update PPK
		public function updateppk ()
		{
			$id_ppk 	= $this->input->post('id_ppk');
			$nama    	= $this->input->post('nama');
			$keterangan = $this->input->post('keterangan');

			$data_update = array (
				'id_ppk' 	 => $id_ppk,
				'nama' 	 	 => $nama,
				'keterangan' => $keterangan
			);
			$where = array ('id_ppk' => $id_ppk);
			$result = $this->Datappk_model->UpdateDataPPK('ppk', $data_update, $where);

			if ($result > 0) {
				$this->session->set_flashdata('updateberhasil','true');
				redirect('admin/daftarppk');
			}
			else {
				$this->session->set_flashdata('updategagal','true');
				redirect('admin/daftarppk');
			}
		}

		public function hapusppk ($id_ppk)
		{
			$where = array ('id_ppk' =>$id_ppk);
			$result = $this->Datappk_model->hapusppk($where, 'ppk');
			$this->session->set_flashdata('deleteberhasil','true');
			redirect(base_url('admin/daftarppk'));
			
		}

		//----- User-------
		//Amil data & Edit User
		public function edituser ($id_user)
		{
			$this->load->view('admin/header');
			$this->load->view('admin/sidebar');
			$data['user'] = $this->Datauser_model->GetWhereUser($id_user);
			$data['get_ppk']=$this->Datappk_model->datappk();
			// $data = array (
			// 	"id_user" 	=> $user[0]['id_user'],
			// 	"nama"	  	=> $user[0]['nama'],
			// 	"NIP"	  	=> $user[0]['NIP'],
			// 	"divisi"	=> $user[0]['divisi'],
			// 	"email"		=> $user[0]['email'],
			// 	"username"	=> $user[0]['username']
			// );


			$this->load->view('admin/edituser',$data);
			$this->load->view('admin/footer1');
		}
		//Fungsi Update PPK
		public function updateuser ()
		{
			$id_user 	= $this->input->post('id_user');
			$NIP    	= $this->input->post('NIP');
			$nama    	= $this->input->post('nama');
			$divisi    	= $this->input->post('divisi');
			$email    	= $this->input->post('email');
			$username 	= $this->input->post('username');

			$data_update = array (
				'id_user'	 =>$id_user,
				'NIP'		 => $NIP,
				'nama' 	 	 => $nama,
				'divisi' 	 => $divisi,
				'email' 	 => $email,
				'username'   => $username
			);
			
			$result = $this->Datauser_model->UpdateDataUser($data_update, $id_user);

			if ($result > 0) {
				$this->session->set_flashdata('updateberhasil','true');
				redirect('admin/daftaruser');
			}
			else {
				$this->session->set_flashdata('updategagal','true');
				redirect('admin/daftaruser');
			}
		}
		public function hapususer ($id_user)
		{
			$where = array ('id_user' =>$id_user);
			$result = $this->Datauser_model->hapususer($where, 'user');
			$this->session->set_flashdata('deleteberhasil','true');
			redirect(base_url('admin/daftaruser'));
			
		}
		public function test()
		{
			$this->load->library('email');
		    $config = array();
		    $config['charset'] = 'utf-8';
		    $config['useragent'] = 'Codeigniter';
		    $config['protocol']= "smtp";
		    $config['mailtype']= "html";
		    $config['smtp_host']= "ssl://smtp.mail.yahoo.com";//pengaturan smtp
		    $config['smtp_port']= "465";
		    $config['smtp_timeout']= "400";
		    $config['smtp_user']= "hans.inside@yahoo.com"; // isi dengan email kamu
		    $config['smtp_pass']= "tangerang030298"; // isi dengan password kamu
		    $config['crlf']="\r\n"; 
		    $config['newline']="\r\n"; 
		    $config['wordwrap'] = TRUE;
		    //memanggil library email dan set konfigurasi untuk pengiriman email
		   
		    $this->email->initialize($config);
		    //konfigurasi pengiriman
		    $this->email->from($config['smtp_user']);
		    $this->email->to('tegarferdyla@gmail.com');
		    $this->email->subject("Notifikasi");
		    $this->email->message(
		     "terkirim"
		    );
	  
	    if($this->email->send())
	    {
			echo "terkirim";
		}
	}
	public function test2()
	{
		md5('');
	}
	}
?>