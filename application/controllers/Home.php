<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		// como vai aparecer em todas a paginas, chamamos o model aqui no construtor - PJCS 
		// vamos chamar o model "Categorias_model" para listagem dos models cadastrados
				// como fosse:
				// modelcategorias = new Categorias_model(); 
		//$this->load->model('categorias_model','modelcategorias');

		$this->load->model('produto_model','modelprodutos'); 
		$this->load->model('picklist_model','model_tipo_pagamento');
		$this->load->model('venda_model','modelvendas');
		
				// vamos cria uma var "$categorias" e carrega-la com o resultado 
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 

	}

	public function index()
	{

		$dados['titulo'] = "ACESSO AO SISTEMA";
		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/acesso');


	}

	


}
