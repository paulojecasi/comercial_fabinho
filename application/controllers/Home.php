<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

	}

	public function index()
	{
		// encerrar a secao TIPO_ACESSO ao entrar novamente sem deslogar 
	  $this->session->unset_userdata('tipo_acesso');
	  
		$dados['titulo'] = "ACESSO AO SISTEMA";
		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/home');


	}

	


}
