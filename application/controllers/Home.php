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
		
				// vamos cria uma var "$categorias" e carrega-la com o resultado 
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 

	}

	public function index()
	{

		$idcaixa=1; 
		$produtos_temp = $this->modelprodutos->listar_produtos_temp($idcaixa);
		if ($produtos_temp){
			$this->load->library('table'); 
			$dados['produtos_temp'] = $produtos_temp;
		} else {
			$dados['produtos_temp'] = null; 
		}
		$dados['tipo_pagamento'] = $this->tipo_pagamento; 
		$dados['produtoitem'] = null; 
		$dados['produtos']=$this->produtos;

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		$this->load->view('backend/mensagem');
		$this->load->view('frontend/home');
		$this->load->view('frontend/template/aside');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer'); 

	}

	public function listar_produto($idproduto){

		$this->load->library('table'); 

		$dados['tipo_pagamento'] = $this->tipo_pagamento;
		$dados['produtos']=$this->produtos;
		$produto_temp =  
					$dados['produtoitem'] = $this->modelprodutos->listar_produto($idproduto); 
		$dados['quantidade_item'] = $this->session->userdata('quantidade');

		if ($this->session->userdata('solicitante') == "venda"){
				// --- aqui, vamos adicionar temporariamente o item da vendas
				$this->inserir_temporario($produto_temp);
				$this->session->unset_userdata('solicitante'); 
		}  
	
		
		$idcaixa=1; 
		$dados['produtos_temp'] = $this->modelprodutos->listar_produtos_temp($idcaixa);
	
		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		$this->load->view('backend/mensagem');
		$this->load->view('frontend/home');
		$this->load->view('frontend/template/aside');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');  

	}


	public function inserir_temporario($produto_temp) 
	{
		foreach ($produto_temp as $produto_t) {

			$idcaixa= 1;   
			$idproduto= $produto_t->idproduto;
			$codproduto= $produto_t->codproduto; 
			$desproduto= $produto_t->desproduto;
			$vlpreco= $produto_t->vlpreco;
			$vlprecoatacado= $produto_t->vlprecoatacado;
			$qtatacado=  $produto_t->qtatacado;
			$vlpromocao= $produto_t->vlpromocao;
			$vlpromocaoatacado= $produto_t->vlprecoatacado;
			$quantidadeitens = $this->session->userdata('quantidade'); 
			$valordesconto = 0; 
			$valoracrescimo =0; 
			$valortotal = $vlpreco * $quantidadeitens;
			
		} 

		if ($this->modelprodutos->adicionar_temp($idcaixa,	$idproduto,$codproduto,$desproduto,$vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal)){
			
		} else {

			$mensagem = "Houve um erro ao adicionar Produto !"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

	}

}
