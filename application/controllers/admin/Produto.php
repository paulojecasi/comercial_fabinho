<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		//vamos verificar se o usuario esta logado para acessar a pagina
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

				// vamos chamar o model produto_model
		$this->load->model('produto_model','modelproduto');
				// vamos chamar o model categorias_model
		$this->load->model('categorias_model','modelcategorias');
		$this->load->model('picklist_model','modellistaescolha'); 
		$this->load->model('marca_model','modelmarcas'); 

				// vamos cria uma var e carrega-la com o resultado 
		//$this->produtos 	= $this->modelproduto->listar_produtos(); 
		$this->categorias = $this->modelcategorias->listar_categorias(); 
		$this->opcoes 		= $this->modellistaescolha->lista_opcoes(); 
		$this->cores 			= $this->modellistaescolha->lista_cores(); 
		$this->marcas 		= $this->modelmarcas->listar_marcas(); 

	}

	public function index($pular=null, $produtos_por_pagina=null)
	{

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table');
		$this->load->library('pagination');  

		// vamos verificar a quantidade de itens da pagina
		if (!$this->session->userdata('itensPorPagina')){
			$this->itensporpagina();
		}

		// configuração de paginação 
		// OBS. NAO ESQUECER DE COLAR O "pagination.php" na pasta "config"
		$config['base_url']= base_url("admin/produto");
		$config['total_rows']= $this->modelproduto->contar();
		$produtos_por_pagina = $this->session->userdata('itensPorPagina'); 
		$config['per_page']= $produtos_por_pagina;

		$this->pagination->initialize($config);

		$dados = array(
			'produtos' 		=>
						 $this->modelproduto->listar_produtos($pular,$produtos_por_pagina), 
			'titulo' 			=> 'Painel de Controle',
			'subtitulo' 	=> 'Produtos', 
			'links_paginacao' => $this->pagination->create_links()
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/produto');
		$this->load->view('backend/template/html-footer'); 

	}

	public function itensporpagina($info=null){

		if ($info == 'a'){
				$qtditens = 5;
		} elseif ($info == 'b'){
				$qtditens = 10;
		} elseif ($info == 'c'){
				$qtditens = 15;
		} elseif ($info == 'd'){
				$qtditens = 20;
		} elseif ($info == 'e'){
				$qtditens = 25;
		} elseif ($info == 'f'){
				$qtditens = 30;
		} elseif ($info == 'g'){
				$qtditens = 40;
		} elseif ($info == 'h'){
				$qtditens = 50;
		} else {
				$info = 'c'; 
				$qtditens = 15; 
		}

		$this->session->set_userdata('itensPorPagina',$qtditens);
		$this->session->set_userdata('qtdItensInfo',$info);
		// depois de selecionar a quantidade de itens, vamos para a pagina principal
		redirect(base_url('admin/produto'));

	}

	public function tipolistagem($tipolista){

		$this->session->set_userdata('tipolista',$tipolista);
		// vamos redirecionar para "admin/produto", que a listagemem será refeita no
		// modelproduto->listar_produtos, que sera invocado no metodo construtor
		//e fara a lista baseado no tipo carregado na SESSION - PJCS 
		redirect(base_url('admin/produto'));
		
	}

	public function cadastro(){
			$dados = array(
			'titulo' 			=> 'Painel de Controle',
			'subtitulo' 	=> 'Manutenção de Produtos - Cadastro', 
			'categorias' 	=> $this->categorias,
			'opcoes'			=> $this->opcoes,
			'cores'				=> $this->cores,
			'marcas'			=> $this->marcas
		); 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/produto-cadastro');
		$this->load->view('backend/template/html-footer'); 
	}

	public function inserir()
	{
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-desproduto',          // name do input (template)
		'Descrição do Produto',		 // nome da label (template)
		'required|min_length[3]'); 
		$this->form_validation->set_rules('codbarras','Codigo de Barras','required');
		$this->form_validation->set_rules('corproduto','Cor do Produto','required');

		$this->form_validation->set_rules('idcategoria','Categoria do Produto','required');
		$this->form_validation->set_rules('idmarca','Marca do Produto','required');

		$this->form_validation->set_rules('vlpreco','Preço Varejo','required');

		$this->form_validation->set_rules('vlpromocao','Valor Promoção Varejo');

		$this->form_validation->set_rules('vlprecoatacado','Preço Atacado','required');

		$this->form_validation->set_rules('vlpromocaoatacado','Valor Promoção Atacado');

		$this->form_validation->set_rules('vllargura','Largura');

		$this->form_validation->set_rules('vlaltura','Altura');

		$this->form_validation->set_rules('vlcomprimento','Comprimento');

		$this->form_validation->set_rules('vlpeso','Peso');

		$this->form_validation->set_rules('produtoativo','Produto Ativo?','required');

		$this->form_validation->set_rules('produtodestaque','Produto Destaque?',
			'required');
		$this->form_validation->set_rules('produtosite','Produto no Site?','required');
		$this->form_validation->set_rules('qtatacado','Qt Itens Atacado');


		if ($this->form_validation->run() == FALSE){

				$this->cadastro();   // se nao validar, retorna para a pagina

		} else {

			$idcategoria= $this->input->post('idcategoria');
			$idmarca= $this->input->post('idmarca');
			$desproduto= $this->input->post('txt-desproduto');
			$codbarras= $this->input->post('codbarras');
			$codproduto= " ";
			$corproduto= $this->input->post('corproduto');
			$vlpreco= $this->input->post('vlpreco');
			$vlpromocao= $this->input->post('vlpromocao');
			$vlprecoatacado= $this->input->post('vlprecoatacado');
			$vlpromocaoatacado= $this->input->post('vlpromocaoatacado');
			$vllargura= $this->input->post('vllargura');	
			$vlaltura= $this->input->post('vlaltura');
			$vlcomprimento= $this->input->post('vlcomprimento');
			$vlpeso= $this->input->post('vlpeso');
			$produtoativo= $this->input->post('produtoativo');
			$produtodestaque= $this->input->post('produtodestaque');
			$produtosite= $this->input->post('produtosite');
			$qtatacado= $this->input->post('qtatacado');

			if ($this->modelproduto->adicionar($idcategoria,$idmarca,$desproduto,$codbarras,$codproduto,$corproduto, $vlpreco, $vlpromocao, $vlprecoatacado, $vlpromocaoatacado, $vllargura,$vlaltura,$vlcomprimento,$vlpeso,$produtoativo,$produtodestaque,$produtosite,$qtatacado)){

				$mensagem ="Produto Adicionado Com Sucesso !"; 
				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Produto !"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/produto'));
		}
	}

	public function alterar($id)
	{
		// vamos carregar a biblioteca de TABELAS
		$produto = $this->modelproduto->listar_produto($id); 

		$dados = array(
			'produto' 		=> $produto, 
		  'categorias' 	=> $this->categorias,
			'titulo' 			=> 'Painel de Controle',
			'subtitulo' 	=> 'Manutenção de Produtos', 
			'opcoes'			=> $this->opcoes,
			'cores'				=> $this->cores,
			'marcas'			=> $this->marcas
		
		); 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/produto-altera');
		$this->load->view('backend/template/html-footer'); 
	}

	public function excluir($id){

		if ($this->modelproduto->excluir($id)) {
			$mensagem ="Produto Excluido Com Sucesso!"; 
			$this->session->set_userdata('mensagem',$mensagem); 
		} else {
			$mensagem ="Erro ao Excluir Produto!"; 
			$this->session->set_userdata('mensagemErro',$mensagem);
		}

		redirect(base_url('admin/produto'));
	}

	public function salvar_alteracoes(){

		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-desproduto',          // name do input (template)
		'Descrição do Produto',		 // nome da label (template)
		'required|min_length[3]'); 
		$this->form_validation->set_rules('codbarras','Codigo de Barras','required');
		$this->form_validation->set_rules('codproduto','Codigo do Produto');
		$this->form_validation->set_rules('corproduto','Cor do Produto','required');

		$this->form_validation->set_rules('idcategoria','Categoria do Produto','required');
		$this->form_validation->set_rules('idmarca','Marca do Produto','required');

		$this->form_validation->set_rules('vlpreco','Preço','required');
		$this->form_validation->set_rules('vlprecoatacado','Preço Atacado','required');

		$this->form_validation->set_rules('vllargura','Largura');

		$this->form_validation->set_rules('vlaltura','Altura');

		$this->form_validation->set_rules('vlcomprimento','Comprimento');

		$this->form_validation->set_rules('vlpeso','Peso');

		$this->form_validation->set_rules('vlpromocao','Valor Promoção');

		$this->form_validation->set_rules('vlpromocaoatacado','Valor Promoção Atacado');

		$this->form_validation->set_rules('produtoativo','Produto Ativo?','required');

		$this->form_validation->set_rules('produtodestaque','Produto Destaque?',
			'required');

		$this->form_validation->set_rules('produtosite','Produto no Site?','required');
		$this->form_validation->set_rules('qtatacado','Qt Itens Atacado');

		if ($this->form_validation->run() == FALSE){
				// se nao validar, retorna para a pagina
				$this->alterar($this->input->post('idproduto'));   
		} else {
			$idproduto= $this->input->post('idproduto');
			$idcategoria= $this->input->post('idcategoria');
			$idmarca= $this->input->post('idmarca');
			$desproduto= $this->input->post('txt-desproduto');
			$codbarras= $this->input->post('codbarras');
			$codproduto= $this->input->post('codproduto');
			$corproduto= $this->input->post('corproduto');
			$vlpreco= $this->input->post('vlpreco');
			$vlprecoatacado= $this->input->post('vlprecoatacado');
			$vllargura= $this->input->post('vllargura');	
			$vlaltura= $this->input->post('vlaltura');
			$vlcomprimento= $this->input->post('vlcomprimento');
			$vlpeso= $this->input->post('vlpeso');
			$vlpromocao= $this->input->post('vlpromocao');
			$vlpromocaoatacado= $this->input->post('vlpromocaoatacado');
			$produtoativo= $this->input->post('produtoativo');
			$produtodestaque= $this->input->post('produtodestaque');
			$produtosite= $this->input->post('produtosite');
			$qtatacado= $this->input->post('qtatacado');

			if ($this->modelproduto->alterar($idproduto,$idcategoria,$idmarca,$desproduto,$codbarras,$codproduto,$corproduto, $vlpreco,$vlprecoatacado,$vllargura,$vlaltura,$vlcomprimento,$vlpeso,$vlpromocao,$vlpromocaoatacado,$produtoativo,$produtodestaque,$produtosite, $qtatacado)){

				$mensagem ="Produto Alterado Com Sucesso !"; 
				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao Alterar Produto !"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/produto/alterar/'.md5($idproduto)));

		}

	}

	public function nova_imagem(){

		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

		$idproduto = $this->input->post('id_produto'); 
		$config['upload_path']= './assets/frontend/img/products'; 
		$config['allowed_types']= 'jpg'; 
		$config['file_name']= $idproduto.'.jpg';
		$config['overwrite']= TRUE;  // sobrepor a imagem sempre que for alterada(mesmo ID)
		$this->load->library('upload', $config); 

		$redirect = base_url('admin/produto/alterar/'.$idproduto);

		if (!$this->upload->do_upload()){

				$mensagem = "ERRO!".$this->upload->display_errors(); 
				$this->session->set_userdata('mensagemErro',$mensagem);

				redirect($redirect);

		} else {

				$config2['source_image']= './assets/frontend/img/products/'.$idproduto.'.jpg';
				$config2['create_thumb']= FALSE;
				$config2['width']= 800;   // largura da imagem
				$config2['height']= 600; 	// altura da imagem

				$this->load->library('image_lib', $config2); 

				if ($this->image_lib->resize()){

						$dir_imagem = $config2['source_image'];

						if ($this->modelproduto->alterar_img($idproduto, $dir_imagem)){

								$mensagem = "Upload da Imagem Realizado Com Sucesso!";
								$this->session->set_userdata('mensagem',$mensagem);
						} else{
								$mensagem = "Erro ao Realizar o Upload da Imagem!";
								$this->session->set_userdata('mensagemErro',$mensagem);
						}

						redirect($redirect); 

				} else {

						$mensagem = "ERRO!".$this->image_lib->display_errors();
						$this->session->set_userdata('mensagemErro',$mensagem);

						redirect($redirect); 
						
				}

		}

	}

}
