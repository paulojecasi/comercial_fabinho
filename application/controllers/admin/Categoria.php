<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		//vamos verificar se o usuario esta logado para acessar a pagina

		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();
		
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio();

				// vamos chamar o model "Categorias_model" para listagem dos models cadastrados
				// como fosse:
				// modelcategorias = new Categorias_model(); 
		$this->load->model('categorias_model','modelcategorias');
		$this->load->model('picklist_model','modellistaescolha');

				// vamos cria uma var "$categorias" e carrega-la com o resultado 
		$this->categorias = $this->modelcategorias->listar_categorias(); 
		$this->opcoes 		= $this->modellistaescolha->lista_opcoes();

	}

	public function index()
	{

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		$dados = array(
			'categorias' 	=> $this->categorias,  
			'titulo' 		 	=> 'Painel de Controle',
			'subtitulo'  	=> 'Categoria',
			'opcoes'   		=> $this->opcoes
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/categoria');
		$this->load->view('backend/template/html-footer'); 

	}

	public function inserir()
	{
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-categoria',        // id do input (template)
		'Nome da Categoria',		// nome da label (template)
		'required|min_length[3]|is_unique[categoria.titulo]'); 


		if ($this->form_validation->run() == FALSE){

				$this->index();   // se nao validar, retorna para a pagina

		} else {

			$addcategoria_titulo= $this->input->post('txt-categoria');
			$destaquenosite   	= 1;


			if ($this->modelcategorias->adicionar($addcategoria_titulo, $destaquenosite)){
				$mensagem ="Categoria Adicionada Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Categoria !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			//-carregar html de categorias 
			$this->modelcategorias->carrega_categorias_html(); 

			redirect(base_url('admin/categoria'));

		}

	}

	public function excluir($id){

		if ($this->modelcategorias->excluir($id)){

			$mensagem ="Categoria Excluida Com Sucesso !"; 

			$this->session->set_userdata('mensagem',$mensagem); 

		} else {

			$mensagem ="Houve um ERRO ao Excluir Categoria !";

			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

		//-carregar html de categorias 
		$this->modelcategorias->carrega_categorias_html();

		redirect(base_url('admin/categoria'));

	}

	public function alterar($id){

		$dados = array(
			'categoria' 	=> $this->modelcategorias->listar_categoria($id),  
			'titulo' 		 	=> 'Painel de Controle',
			'subtitulo'  	=> 'Categoria - Alteração',
			'opcoes'   		=> $this->opcoes
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/alterar-categoria');
		$this->load->view('backend/template/html-footer'); 

	}


	public function salvar_alteracoes(){
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-categoria',        // id do input (template)
		'Nome da Categoria',		// nome da label (template)
		'required|min_length[3]'); //requerido|minimo 3 caract|
				
		if ($this->form_validation->run() == FALSE){

			$this->index();   // se nao validar, retorna para a pagina

		} else {

			$alterar_categoria= $this->input->post('txt-categoria');
			$destaquenosite   = $this->input->post('categoriadest');
			$id= $this->input->post('txt-id');

			if ($this->modelcategorias->alterar($alterar_categoria, $destaquenosite, $id)){

				$mensagem ="Categoria Alterada Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 

			} else {

				$mensagem = "Houve um erro ao Alterar Categoria!"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}
			
			//-carregar html de categorias 
			$this->modelcategorias->carrega_categorias_html();

			redirect(base_url('admin/categoria'));

		}

	}

}
