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

		
		$this->load->model('estoque_model','modelestoque');
		$this->load->model('produto_model','modelprodutos');
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

	public function itens($idestoque, $idproduto=null){

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		if ($idproduto){
			$dados['produtoitem'] = $this->modelprodutos->listar_produto($idproduto); 
		}else{
			$dados['produtoitem'] = null; 
		}
		$dados['produtos'] = $this->modelprodutos->listar_produtos();
		$dados['estoque_entrada'] = $this->modelestoque->listar_estoque($idestoque);
		$dados['estoque_entrada_itens']=$this->modelestoque->listar_estoque_itens($idestoque); 


		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/estoque-itens');
		//if ($idproduto){
		//		$this->load->view('backend/estoque-item-consultado');
		//}
		$this->load->view('backend/template/html-footer'); 

	}

	public function buscar_produto()
	{
		
		$idestoque_entrada  = $this->input->post('idestoque');
		$idcodbarras  = $this->input->post('idcodbarras');
		$idcodproduto = $this->input->post('idcodproduto');
		$iddesproduto = $this->input->post('iddesproduto');
		

		if ($idcodproduto && $iddesproduto 
				||
				$idcodproduto && $idcodbarras 
				||
				$iddesproduto && $idcodbarras){

				$mensagem ="ATENÇÃO! Selecione Somente Uma Opcao: Cod Barras, Código Produto ou Nome Produto.";

				$this->session->set_userdata('mensagemErro',$mensagem);

				$this->itens($idestoque_entrada);

		}elseif (!$idcodproduto && !$iddesproduto && !$idcodbarras){

				$mensagem ="ATENÇÃO! Selecione ao menos Uma Opcao: Cod Barras, Código Produto ou Nome Produto.";

				$this->session->set_userdata('mensagemErro',$mensagem);

				$this->itens($idestoque_entrada);
		}else{

			if ($idcodproduto){
				$idproduto = $idcodproduto;
			}elseif ($iddesproduto) {
				$idproduto = $iddesproduto;
			}else {
				$idproduto = $idcodbarras;
			}
			// vamor verficar se o item ja foi gravado 
			if ($this->modelestoque->verifica_item_existente($idproduto,$idestoque_entrada)){

					$mensagem ="ATENÇÃO! Produto já está cadastrado na Nota, verifique!";
					$this->session->set_userdata('mensagemErro',$mensagem);
					$this->itens($idestoque_entrada);  // se nao validar, retorna para a pagina

			}else{
				// vamos chamar o metodo itens com o idproduto definido - PJCS 
				$this->itens($idestoque_entrada, $idproduto);
			} 

			
			
		}
	} 

	public function inserir_estoque_item()
	{
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules('vlunitario','Valor Unitario','required'); 
		$this->form_validation->set_rules('quantidade','Quantidade Itens','required');
		$this->form_validation->set_rules('vltotal','Valor Total','required');  

		if ($this->form_validation->run() == FALSE){

				$idestoque = $this->input->post('idestoque_entrada'); 
				$this->itens($idestoque);   // se nao validar, retorna para a pagina

		} else {

			$idproduto= $this->input->post('idproduto');
			$idestoque = $this->input->post('idestoque');
			$vlunitario = $this->input->post('vlunitario');
			$quantidade = $this->input->post('quantidade');
			$vltotal = $this->input->post('vltotal'); 
			
			if ($this->modelestoque->inserir_estoque_item($idproduto, $idestoque,$vlunitario,$quantidade,$vltotal)){
				$mensagem ="Item da Nota/Estoque Adicionada Com Sucesso !"; 

				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Item da Nota/Estoque !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/estoque/itens/'.md5($idestoque)));

		}

	}

}