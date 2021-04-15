<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 
		//vamos verificar se o usuario esta logado para acessar a pagina
		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();
		
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio();

		$this->load->model('marca_model','modelmarcas');
	
				// vamos cria uma var "$categorias" e carrega-la com o resultado 
		$this->marcas = $this->modelmarcas->listar_marcas(); 

	}

	public function index()
	{

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		$dados = array(
			'marcas' 			=> $this->marcas,  
			'titulo' 		 	=> 'Painel de Controle',
			'subtitulo'  	=> 'Marca do Produto'
		
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/marca');
		$this->load->view('backend/template/html-footer'); 

	}

	public function inserir()
	{
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'desmarca',        // id do input (template)
		'Nome da Marca',		// nome da label (template)
		'required|min_length[3]|is_unique[marca.desmarca]'); 

		if ($this->form_validation->run() == FALSE){

				$this->index();   // se nao validar, retorna para a pagina

		} else {

			$desmarca= $this->input->post('desmarca');

			if ($this->modelmarcas->adicionar($desmarca)){
				$mensagem ="Marca Adicionada Com Sucesso!"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Marca!"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/marca'));

		}

	}

	public function excluir($id){

		if ($this->modelmarcas->excluir($id)){

			$mensagem ="Marca  Excluida Com Sucesso !"; 

			$this->session->set_userdata('mensagem',$mensagem); 

		} else {

			$mensagem ="Houve um ERRO ao Excluir Marca!";

			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

		redirect(base_url('admin/marca'));

	}

	public function alterar($id){

		$dados = array(
			'marca' 	=> $this->modelmarcas->listar_marca($id),  
			'titulo' 		 	=> 'Painel de Controle',
			'subtitulo'  	=> 'Alteração - Marca do Produto'
			
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/alterar-marca');
		$this->load->view('backend/template/html-footer'); 

	}


	public function salvar_alteracoes(){
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'desmarca',        // id do input (template)
		'Nome da Marca',		// nome da label (template)
		'required|min_length[3]'); //requerido|minimo 3 caract|
				
		if ($this->form_validation->run() == FALSE){

			$this->index();   // se nao validar, retorna para a pagina

		} else {

			$desmarca= $this->input->post('desmarca');
			$idmarca= $this->input->post('idmarca');

			if ($this->modelmarcas->alterar($desmarca, $idmarca)){

				$mensagem ="Marca Alterada Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 

			} else {

				$mensagem = "Houve um erro ao Alterar Marca!"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}
			
			redirect(base_url('admin/marca'));

		}

	}

}