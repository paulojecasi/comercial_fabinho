<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		//vamos verificar se o usuario esta logado para acessar a pagina
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

				// vamos chamar o model "Categorias_model" para listagem dos models cadastrados
				// como fosse:
				// modelcategorias = new Categorias_model(); 
		$this->load->model('estoque_model','modelestoque');
		$this->estoques = $this->modelestoque->listar_entradas(); 

	}

	public function index()
	{

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		$dados = array(
			'estoques' 	=> $this->estoques,
			'estoque_entrada' 	
										=> $this->modelestoque->listar_estoque($idestoque=null),   
			'titulo' 		 	=> 'Painel de Controle',
			'subtitulo'  	=> 'Estoque '
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/estoque');
		$this->load->view('backend/template/html-footer'); 

	}

	public function inserir()
	{
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'nrnota','Numero da Nota de Entrada','required|is_unique[estoque_entrada.nrnota]'); 
		$this->form_validation->set_rules('serie','Serie da Nota?','required'); 
		$this->form_validation->set_rules('emitente','Emisor da Nota');
		$this->form_validation->set_rules('valornota','Valor da Nota','required');

		if ($this->form_validation->run() == FALSE){

				$this->index();   // se nao validar, retorna para a pagina

		} else {

			$nrnota  		= $this->input->post('nrnota');
			$serie   		= $this->input->post('serie');
			$emitente 	= $this->input->post('emitente');
			$valornota  = $this->input->post('valornota');

			if ($this->modelestoque->adicionar($nrnota, $serie, $emitente, $valornota)){
				$mensagem ="Nota Adicionada Com Sucesso! Agora Adicione os itens";
				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 

				// consultando a nota adicionada para exibir 
				//$idestoque = $this->db->insert_id();
				//$this->consulta_nota_adicionada(md5($idestoque)); 
				redirect(base_url('admin/estoque'));
				
			} else {

				$mensagem = "Houve um erro ao adicionar Nota !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

				redirect(base_url('admin/estoque'));
			}

		}

	}


	public function itens($idestoque){

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		$dados = array(
			'estoque_entrada' => $this->modelestoque->listar_estoque($idestoque),
			'estoque_itens'		=> $this->modelestoque->listar_estoque_itens($idestoque) 
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/estoque-itens');
		$this->load->view('backend/template/html-footer'); 

	}


}