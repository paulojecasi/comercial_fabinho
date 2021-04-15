<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct(); 

		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral(); 
	 
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio(); 
	
	}

	public function index()
	{

		// dados a serem enviados para o cabeçalho
		$dados['titulo'] 		= 'Painel de Controle';
		$dados['subtitulo'] = 'M F - Administração do Sistema';


		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/home');
		$this->load->view('backend/template/html-footer'); 

	}


}
