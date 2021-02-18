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
		$this->load->model('picklist_model','modellist'); 
		$this->estoques = $this->modelestoque->listar_entradas(); 
		$this->situacao_nota = $this->modellist->situacao_nota(); 

	}

	public function index()
	{

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		$dados = array(
			'estoques' 	=> $this->estoques,
			'estoque_entrada' 	
										=> $this->modelestoque->listar_estoque($idestoque_entrada=null),   
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

			$retorno = $this->modelestoque->adicionar($nrnota,$serie,$emitente,$valornota); 

			if ($retorno){
				$mensagem ="Nota -(".$nrnota.")- foi Adicionada com Sucesso! Agora Adicione os ITENS";
				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 

				// vamos pegar o id do nota adicionada e redirecionar diretamente
				// para a template de cadastro dos itens
				$idestoque_entrada = $this->db->insert_id();
				redirect(base_url('admin/estoque/itens/'.md5($idestoque_entrada)));
				
			} else {

				$mensagem = "Houve um erro ao adicionar Nota !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

				redirect(base_url('admin/estoque'));
			}

		}

	}

	public function itens($idestoque_entrada, $idproduto=null){

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		if ($idproduto){
			$dados['produtoitem'] = $this->modelprodutos->listar_produto($idproduto); 
		}else{
			$dados['produtoitem'] = null; 
		}
		$dados['situacao_nota']= $this->situacao_nota;
		$dados['produtos'] = $this->modelprodutos->listar_produtos();
		$dados['estoque_entrada'] = $this->modelestoque->listar_estoque($idestoque_entrada);
		$dados['estoque_entrada_itens']=$this->modelestoque->listar_estoque_itens($idestoque_entrada); 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/estoque-itens');
		//if ($idproduto){
		//		$this->load->view('backend/estoque-item-consultado');
		//}
		$this->load->view('backend/template/html-footer'); 

	}

	public function estoque_consulta($idproduto=null, $datainicial=null, $datafinal=null)
	{
		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		if ($idproduto){
			$dados['produto_est_mov'] = 
					$this->modelprodutos->listar_produto($idproduto);
			$dados['estoque_mov'] 		=	
					$this->modelestoque->consulta_movimento_estoque($idproduto,$datainicial,$datafinal); 
			$dados['estoque_saldo_atual'] = 
					$this->modelestoque->consulta_estoque_saldo($idproduto); 
		} else {
			$dados['produto_est_mov'] =null; 
			$dados['estoque_mov']=null; 
			$dados['estoque_saldo_atual'] = null; 
		}

		$dados['produtos'] 	=  $this->modelprodutos->listar_produtos();
	
		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/estoque-consulta');
		$this->load->view('backend/template/html-footer'); 

	}

	public function buscar_produto($idsolicitante)
	{
		$idestoque_entrada  = $this->input->post('idestoque_entrada');
		$idcodbarras  = $this->input->post('idcodbarras');
		$idcodproduto = $this->input->post('idcodproduto');
		$iddesproduto = $this->input->post('iddesproduto');
		$quantidade   = $this->input->post('quantidade');

		if ($idsolicitante == "venda"){
			$this->session->set_userdata('quantidade',$quantidade);
			$this->session->set_userdata('solicitante',$idsolicitante);
 			$idcodproduto = $this->input->post('idproduto_res');
 		
		}

		if ($idsolicitante == "consulta-estoque"){
			$datainicial = $this->input->post('datainicial');
			$datafinal = $this->input->post('datafinal'); 
		} 


		if ($idcodproduto && $iddesproduto 
				||
				$idcodproduto && $idcodbarras 
				||
				$iddesproduto && $idcodbarras){

				$mensagem ="ATENÇÃO! Selecione Somente Uma Opção: Cod Barras, Código Produto ou Nome Produto.";

				$this->session->set_userdata('mensagemErro',$mensagem);

				if ($idsolicitante == "itens-nota"){
					$this->itens($idestoque_entrada);
				} elseif ($idsolicitante == "consulta-estoque"){
					$this->estoque_consulta(); 
				}	elseif ($idsolicitante == "venda"){
					redirect(base_url('venda')); 
				}

		}elseif (!$idcodproduto && !$iddesproduto && !$idcodbarras){
	
				$mensagem ="ATENÇÃO! Selecione ao menos Uma Opção: Cod Barras, Código Produto ou Nome Produto.";

				$this->session->set_userdata('mensagemErro',$mensagem);
				if ($idsolicitante == "itens-nota"){
					$this->itens($idestoque_entrada);
				} elseif ($idsolicitante == "consulta-estoque"){
					$this->estoque_consulta(); 
				} elseif ($idsolicitante == "venda"){
					redirect(base_url('venda')); 
				}

		}else{

			if ($idcodproduto){
				$idproduto = $idcodproduto;
			}elseif ($iddesproduto) {
				$idproduto = $iddesproduto;
			}else {
				$idproduto = $idcodbarras;
			}
			// vamos verficar se o item ja foi gravado 
			if ($this->modelestoque->verifica_item_existente($idproduto,$idestoque_entrada)){

					$mensagem ="ATENÇÃO! Produto já está cadastrado na Nota, verifique!";
					$this->session->set_userdata('mensagemErro',$mensagem);
					if ($idsolicitante == "itens-nota"){
						$this->itens($idestoque_entrada);  // se nao validar, retorna para a pagina
					} elseif ($idsolicitante == "consulta-estoque"){
						$this->estoque_consulta(); 
					} elseif ($idsolicitante == "venda"){
						redirect(base_url('venda')); 
					}

			}else{
				// vamos chamar o metodo itens com o idproduto definido - PJCS 
				if ($idsolicitante == "itens-nota"){
						$this->itens($idestoque_entrada, $idproduto);
				} elseif ($idsolicitante == "consulta-estoque"){
						$this->estoque_consulta($idproduto,$datainicial,$datafinal); 
				}	elseif ($idsolicitante == "venda"){
						redirect(base_url('venda/listar_produto/'.$idproduto)); 
				}
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

				$idestoque_entrada = $this->input->post('idestoque_entrada'); 
				$this->itens($idestoque_entrada);  // se nao validar, retorna para a pagina

		} else {

			$idproduto= $this->input->post('idproduto');
			$idestoque_entrada = $this->input->post('idestoque_entrada');
			$nrnota = $this->input->post('nrnota');
			$vlunitario = $this->input->post('vlunitario');
			$quantidade = $this->input->post('quantidade');
			$vltotal = $this->input->post('vltotal'); 
			
			if ($this->modelestoque->inserir_estoque_item($idproduto,$idestoque_entrada,$nrnota,$vlunitario,$quantidade,$vltotal)){

				$produto = $this->listar_produto($idproduto);

				foreach ($produto as $produto_add) {
					$desproduto = $produto_add->desproduto; 
				}

				$mensagem ="O Item- (".$desproduto.")- foi Adicionada Com Sucesso na Nota/Estoque!"; 

				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Item da Nota/Estoque !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/estoque/itens/'.md5($idestoque_entrada)));

		}
	}

	public function listar_produto($idproduto){

		$this->modelprodutos->listar_produto($idproduto);
		
	}

	public function cancelar_item($id, $idproduto, $idestoque_entrada){

		if ($this->modelestoque->cancelar_item($id, $idproduto, $idestoque_entrada)){
				$mensagem ="Item Cancelado com Sucesso!";
				$this->session->set_userdata('mensagem',$mensagem);

				$this->itens($idestoque_entrada);

		} else {
				$mensagem ="Erro ao Cancelar o Item, Verifique!";
				$this->session->set_userdata('mensagemErro',$mensagem);
		} 
	}


}