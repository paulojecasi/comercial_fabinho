<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 

		//vamos verificar se o usuario esta logado para acessar a pagina
	
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}
	
	}

	public function index()
	{


		// dados a serem enviados para o cabeçalho
		$dados['titulo'] 		= 'Painel de Controle';
		$dados['subtitulo'] = 'Administração do Sistema - Comercial Fabinho';


		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/home');
		$this->load->view('backend/template/html-footer'); 

	}


}
