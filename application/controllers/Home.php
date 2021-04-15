<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();

	}

	public function index()
	{

		$dados['titulo'] = "ACESSO AO SISTEMA";
		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/home');


	}

	
}
