<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

	public function __construct()	{

		parent::__construct(); 

		// como vai aparecer em todas a paginas, chamamos o model aqui no construtor - PJCS 
		// vamos chamar o model "Categorias_model" para listagem dos models cadastrados
				// como fosse:
				// modelcategorias = new Categorias_model(); 
		$this->load->model('categorias_model','modelcategorias');

				// vamos cria uma var "$categorias" e carrega-la com o resultado 
		$this->categorias = $this->modelcategorias->listar_categorias(); 
	}

	public function index($id, $slug=null) {

		// vamos carregar os "$dados" com a variavel "$categoria" carregado no CONSTRUTOR
		$dados['categorias'] = $this->categorias; 

		//como se fosse:  modelpublicacoes = new Publicacoes_model();
		$this->load->model('publicacoes_model','modelpublicacoes'); 
		$dados['postagens'] = $this->modelpublicacoes->categoria_pub($id); 

		// dados a serem enviados para o cabeçalho
		$dados['nomeblog'] 	= "Blog do Paulão"; 
		$dados['titulo'] 		= 'Categorias';
		$dados['subtitulo'] = $slug;

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		$this->load->view('frontend/categoria');
		$this->load->view('frontend/template/aside');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer'); 

	}


}
