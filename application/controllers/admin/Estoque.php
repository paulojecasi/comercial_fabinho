<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque extends CI_Controller { 

	public function __construct() 
	{ 
 
		parent::__construct(); 

		//vamos verificar se o usuario esta logado para acessar a pagina

		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();
		
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio();
		
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
			'subtitulo'  	=> 'Estoque ', 
			'situacao_nota'=> $this->situacao_nota,
			'numero_nota_auto' => $this->modelestoque->getNumero_nota_auto() 
		);

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/estoque');
		$this->load->view('backend/template/footer');
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
				$this->index(); 
		}
		else
		{
			// vamos iniciar a transação 
	  	$this->db->trans_begin();

			$nrnota  		= $this->input->post('nrnota');
			$serie   		= $this->input->post('serie');
			$emitente 	= $this->input->post('emitente');
			$valornota  = $this->input->post('valornota');

			if ($emitente == "SISTEMA")
			{
				$resultado_snota = $this->modelestoque->setNumero_nota_auto($nrnota); 

				if (!$resultado_snota)
				{
					$mensagem = "Houve um erro ao Atualizar Numero da Nota Automática(setNumero_nota_auto"; 
					$this->session->set_userdata('mensagemErro',$mensagem); 
					$this->db->trans_rollback(); 
					redirect(base_url('admin/estoque'));
				}
			}

			$retorno = $this->modelestoque->adicionar($nrnota,$serie,$emitente,$valornota); 
			$idestoque_entrada = $this->db->insert_id();

			if (!$retorno){
				$mensagem = "Houve um erro ao adicionar Nota !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

				$this->db->trans_rollback(); 

				redirect(base_url('admin/estoque'));
			}


			if  ($this->db->trans_status()===FALSE ) 
			{ 
				  $this->db->trans_rollback(); 
				  $mensagem = "Houve um ERRO de TRANSAÇÃO! (venda/finalizar_venda) "; 
					$this->session->set_userdata('mensagemErro',$mensagem); 
					redirect(base_url('venda'));
			} 
			else 
			{ 
				$this->db->trans_commit(); 

				$mensagem ="Nota -(".$nrnota.")- foi Adicionada com Sucesso! Agora Adicione os ITENS";
				$this->session->set_userdata('mensagemAlert',$mensagem); 

				redirect(base_url('admin/estoque/itens/'.md5($idestoque_entrada)));
		
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
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/estoque-itens');
		$this->load->view('backend/template/footer'); 
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
					$this->modelestoque->consulta_movimento_estoque(md5($idproduto),$datainicial,$datafinal); 
			$dados['estoque_saldo_atual'] = 
					$this->modelestoque->consulta_estoque_saldo(md5($idproduto)); 
		} else {
			$dados['produto_est_mov'] =null; 
			$dados['estoque_mov']=null; 
			$dados['estoque_saldo_atual'] = null; 
		}

		$dados['produtos'] 	=  $this->modelprodutos->listar_produtos();
	
		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/estoque-consulta');
		$this->load->view('backend/template/html-footer'); 

	}

	public function buscar_produto($idsolicitante)
	{
		$idcaixa = $this->session->userdata('idcaixa'); 
		$idestoque_entrada  = $this->input->post('idestoque_entrada');
		$idproduto  = $this->input->post('idproduto_res');
		$quantidade   = $this->input->post('quantidade');
		$idproduto_md = md5($idproduto); 

		if ($idsolicitante == "venda"){
			$this->session->set_userdata('quantidade',$quantidade);
			$this->session->set_userdata('solicitante',$idsolicitante);
 			$idcodproduto = $this->input->post('idproduto_res'); 


 			// vamos verificar a quantidade da venda e o saldo de estoque 
 			$quantidade_itens_selecionados=$this->modelestoque->getQuantidade_item_temp($idcaixa,$idproduto);

 			if ($quantidade_itens_selecionados)
 			{
	 			foreach ($quantidade_itens_selecionados as $qtd_select) 
	 			{
	 				 $quantidade += $qtd_select->quantidadeitens; 
	 			}
 			}

 			$resultado_saldo = $this->modelestoque->consulta_estoque_saldo($idproduto_md); 
 			if ($resultado_saldo)
 			{
				if ($resultado_saldo < $quantidade)
				{
					$mensagem ="ATENÇÃO! Produto sem Saldo Suficiente. Saldo: ".$resultado_saldo;

					$this->session->set_userdata('mensagemErro',$mensagem);

					redirect(base_url('venda')); 

				} 			
 			}
 		
		}

		if ($idsolicitante == "consulta-estoque"){
			$datainicial = $this->input->post('datainicial');
			$datafinal = $this->input->post('datafinal'); 
		} 

		if (!$idproduto){
	
				$mensagem ="ATENÇÃO! Selecione um Produto para Consulta";

				$this->session->set_userdata('mensagemErro',$mensagem);
				if ($idsolicitante == "itens-nota"){
					//$this->itens($idestoque_entrada);
					redirect(base_url('admin/estoque/itens/'.$idestoque_entrada));
				} elseif ($idsolicitante == "consulta-estoque"){
					//$this->estoque_consulta(); 
					redirect(base_url('admin/estoque/estoque_consulta'));
				} elseif ($idsolicitante == "venda"){
					redirect(base_url('venda')); 
				}

		}else{

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
						redirect(base_url('venda/listar_produto/'.md5($idproduto))); 
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
			$mensagem = "Preencha os campos obrigatórios: VALOR UNITARIO e QUANTIDADE"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 
			$idestoque_entrada = $this->input->post('idestoque_entrada'); 
			$this->itens(md5($idestoque_entrada));  // se nao validar, retorna para a pagina

		} else {

			$idproduto= $this->input->post('idproduto_est');
			$idestoque_entrada = $this->input->post('idestoque_entrada');
			$nrnota = $this->input->post('nrnota');
			$vlunitario = $this->input->post('vlunitario');
			$quantidade = $this->input->post('quantidade');
			$vltotal = $this->input->post('vltotal'); 

			$vlAtualItem = $this->input->post('vl_venda_atual_est');
			$vlAtualItemAtacado = $this->input->post('vl_atacado_atual_est');


			// vamos verficar se o item ja foi gravado 
			if ($this->modelestoque->verifica_item_existente(md5($idproduto),md5($idestoque_entrada)))
			{
					$mensagem ="ATENÇÃO! Produto já está cadastrado na Nota, verifique!";
					$this->session->set_userdata('mensagemErro',$mensagem);
					redirect(base_url('admin/estoque/itens/'.md5($idestoque_entrada)));
			}
			
			if ($this->modelestoque->inserir_estoque_item($idproduto,$idestoque_entrada,$nrnota,$vlunitario,$quantidade,$vltotal,$vlAtualItem,$vlAtualItemAtacado)){

				$produto_lis = $this->listar_produto(md5($idproduto));
	
				foreach ($produto_lis as $produto_addss) 
				{
					$desproduto = $produto_addss->desproduto; 
				}

				$mensagem ="O Item- (".$desproduto.")- foi Adicionada Com Sucesso na Nota/Estoque!"; 

				$this->session->set_userdata('mensagemAlert',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Item da Nota/Estoque !"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/estoque/itens/'.md5($idestoque_entrada)));

		}
	}

	public function listar_produto($idproduto){

		return $this->modelprodutos->listar_produto($idproduto);
		
	}

	public function cancelar_item($id, $idproduto, $idestoque_entrada){

		if ($this->modelestoque->cancelar_item($id, $idproduto, $idestoque_entrada)){
				$mensagem ="Item Cancelado com Sucesso!";
				$this->session->set_userdata('mensagemAlert',$mensagem);

				//$this->itens($idestoque_entrada);
				redirect(base_url('admin/estoque/itens/'.$idestoque_entrada));

		} else {
				$mensagem ="Erro ao Cancelar o Item, Verifique!";
				$this->session->set_userdata('mensagemErro',$mensagem);
		} 
	}

	public function fechar_cancelar_nota($solicitacao,$idestoque_entrada_md)
	{
    $this->db->trans_begin();
		
		$this->modelestoque->fechar_cancelar_nota($solicitacao, $idestoque_entrada_md);		
		
		if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (admin/estoque/fechar_cancelar_nota) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('admin/estoque/itens/'.$idestoque_entrada_md));
		} 
		else 
		{ 

			$this->db->trans_commit(); 
			if ($solicitacao ==1)
			{
				$mensagem = "Nota Finalizada com Sucesso !"; 
			}
			else
			{
				$mensagem = "Nota Cancelada com Sucesso !"; 
			}

			$this->session->set_userdata('mensagemAlert',$mensagem); 
			redirect(base_url('admin/estoque/itens/'.$idestoque_entrada_md));
		}

	}


}