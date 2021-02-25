<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 
		if (!$this->session->userdata('logado')){
			$this->session->set_userdata('tipo_acesso',"venda");
			redirect(base_url('admin/login')); 
		}

		$this->load->model('cliente_model','modelcliente'); 
		$this->load->model('venda_model','modelvendas'); 

	}

	public function manutencao_clientes(){

		$idcaixa =1; 
		$dados['idcaixa'] = $idcaixa; 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/cliente');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	public function cadastro_cliente($localchamado=null){
		$idcaixa =1;
		$dados['localchamado'] = $localchamado; 
		$dados['idcaixa'] = $idcaixa;
		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/cliente_cadastro');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');
	}


	public function inserir($localchamado=null)
	{
		$idcaixa =1;
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'nome', 'Nome do Cliente','required|min_length[10]'); 
		$this->form_validation->set_rules(
		'cpf', 'C P F','min_length[11]|is_unique[cliente.cpf]'); 
		$this->form_validation->set_rules(
		'endereco', 'Endereço','min_length[8]'); 
		$this->form_validation->set_rules(
		'pontoreferencia', 'Ponto de Referencia','min_length[8]'); 


		if ($this->form_validation->run() == FALSE){

				$this->cadastro_cliente($localchamado);    

		} else {

			$nome 			= $this->input->post('nome');
			$apelido 		= $this->input->post('apelido');
			$cpf 				= $this->input->post('cpf');
			$endereco 	= $this->input->post('endereco');
			$pontoreferencia= $this->input->post('pontoreferencia');

			if ($this->modelcliente->adiciona_cliente($nome,$apelido,$cpf,$endereco,$pontoreferencia)){

				$idcliente = $this->db->insert_id(); // pega ultimo id inserido 
				$mensagem ="Cliente Adicionado com Sucesso !"; 
				$this->session->set_userdata('mensagem',$mensagem); 

				$this->carrega_sessions($idcliente, $nome, $apelido, $endereco, $pontoreferencia, $cpf); 

				if ($localchamado == "crediario"){

					redirect(base_url('venda/venda_pagamento/').$idcaixa.'/4');

				} else {
					
					$this->manutencao_clientes(); 

				}
				
			} else {

				$mensagem = "Houve um erro ao adicionar o Cliente !"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

		}
	}

	public function consulta_cliente($localchamado=null)
	{

		//encerrar seçoes
		$this->session->unset_userdata('idcliente');
    $this->session->unset_userdata('nome');
    $this->session->unset_userdata('apelido'); 
    $this->session->unset_userdata('cpf'); 
    $this->session->unset_userdata('endereco'); 
    $this->session->unset_userdata('pontoreferencia');
    $this->session->unset_userdata('vl_saldo_devedor');

		$idcliente_consultado = $this->input->post('idclientej');
		$idcliente = md5($idcliente_consultado); 
		$idcaixa = $this->input->post('idcaixa');  

		if (!$idcliente_consultado){
			$mensagem = "CLIENTE INVALIDO! Selecione um cliente para consultar."; 
			$this->session->set_userdata('mensagemErro',$mensagem);

			if ($localchamado == "cliente"){
				redirect(base_url('cliente/manutencao_clientes/').$idcaixa);
			}else{
				redirect(base_url('venda/venda_pagamento/').$idcaixa.'/4');
			} 
		}
		
		$cliente_consultado = $this->modelcliente->consulta_cliente($idcliente);

		if ($cliente_consultado)
		{
			foreach ($cliente_consultado as $clicons) {
				$idcliente_consultado 	= $clicons->idcliente;
				$nome 			= $clicons->nome;
				$apelido 		= $clicons->apelido;
				$endereco 	= $clicons->endereco;
				$pontoreferencia= $clicons->pontoreferencia;
				$cpf 				= $clicons->cpf;
				$this->carrega_sessions($idcliente_consultado, $nome, $apelido, $endereco, $pontoreferencia, $cpf);
			}
		}


		$this->consulta_saldo_crediario($idcliente); 

		if ($localchamado == "cliente"){
			redirect(base_url('cliente/manutencao_clientes/').$idcaixa);
		}else{
			redirect(base_url('venda/venda_pagamento/').$idcaixa.'/4');
		}
		
	}

	public function altera_cliente($idcliente){
		$idcaixa =1;
		$dados['idcaixa'] = $idcaixa;
		$dados['cliente_consultado'] = $this->modelcliente->consulta_cliente($idcliente);

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/cliente_altera');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');
	}

	public function confirma_alteracao($idcliente)
	{
		$idcaixa =1;
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'nome', 'Nome do Cliente','required|min_length[10]'); 
		$this->form_validation->set_rules(
		'cpf', 'C P F','min_length[11]'); 
		$this->form_validation->set_rules(
		'endereco', 'Endereço','min_length[8]'); 
		$this->form_validation->set_rules(
		'pontoreferencia', 'Ponto de Referencia','min_length[8]'); 

		$this->consulta_saldo_crediario($idcliente); 

		if ($this->form_validation->run() == FALSE){

				$this->altera_cliente($idcliente);    

		} else {

			$nome 			= $this->input->post('nome');
			$apelido 		= $this->input->post('apelido');
			$cpf 				= $this->input->post('cpf');
			$endereco 	= $this->input->post('endereco');
			$pontoreferencia= $this->input->post('pontoreferencia');

			if ($this->modelcliente->confirma_alteracao($idcliente,$nome,$apelido,$cpf,$endereco,$pontoreferencia)){


				$mensagem ="Dados do Cliente Alterado com Sucesso !"; 
				$this->session->set_userdata('mensagem',$mensagem); 

				$this->carrega_sessions(null,$nome, $apelido, $endereco, $pontoreferencia, $cpf);
		
				redirect(base_url('cliente/manutencao_clientes/').$idcaixa);
				
			} else {

				$mensagem = "Houve um erro ao Alterar Dados do Cliente !"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

		}
	}

	public function consulta_crediario($idcliente, $localchamado)
	{

		$this->load->library('table'); 

		$idcaixa =1; 
		$dados['idcaixa'] 	= $idcaixa;
		$dados['idcliente'] = $idcliente;
		$dados['localchamado'] = $localchamado; 

		$dados['vendas_cli']= $this->modelvendas->consulta_crediarios_cliente($idcliente,1); 
		$dados['vendas_itens_cli']= $this->modelvendas->consulta_crediarios_cliente($idcliente,2);

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/cliente_consulta_crediario');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	private function consulta_saldo_crediario($idcliente)
	{

		$saldo_dev = $this->modelcliente->consulta_saldo_crediario($idcliente);
		
		foreach ($saldo_dev as $saldo_cred) 
		{
			$this->session->set_userdata('vl_saldo_devedor',$saldo_cred->vl_saldo_devedor); 

		}

	}

	public function pagamento_crediario($idvenda){

		$idcaixa =1; 
		$dados['idcaixa'] = $idcaixa; 
		$dados['venda_cliente'] = $this->modelvendas->consulta_venda($idvenda);

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/cliente_pagamento_crediario');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	public function pagamento_crediario_confirma($idvenda)
	{
		$vl_amortizacao = $this->input->post('vl_real_amortizacao'); 

		$this->modelvendas->baixa_pagamento_crediario($idvenda,$vl_amortizacao);

		$this->pagamento_crediario($idvenda); 
		//$this->consulta_crediario($idcliente,"cliente");
	}

	private function carrega_sessions($idcliente=null, $nome, $apelido, $endereco, $pontoreferencia, $cpf)
	{

		if ($idcliente)
		{
			$this->session->set_userdata('idcliente',$idcliente);
		}
		$this->session->set_userdata('nome',$nome);
		$this->session->set_userdata('apelido',$apelido);
		$this->session->set_userdata('endereco',$endereco);
		$this->session->set_userdata('pontoreferencia',$pontoreferencia);
		$this->session->set_userdata('cpf',$cpf);

	}


	function consultajquery_cliente()
		{
	 	$output = '';
	 	$nomecliente = ''; 

 		if ($this->input->post('nomecliente'))
 		{
	 		$nomecliente = $this->input->post('nomecliente'); 
	 	}

	 	//echo $nomecliente;
		//exit;

	 	$dados_cli = $this->modelcliente->consultajquery_cliente($nomecliente);

 		$output .= '
 		<div class= "form-group picklist-prod">

 			<div class picklist-tit> 
	 			<label class= "idcliente">
	 					Codigo  
	 			</label>
	 			<label class= "nome">
	 					Nome 
	 			</label>
	 			<label class="apelido">
	 					 Apelido 
	 			</label> 
	 		</div> 
      <select multiple class="form-control" id="idclientej" name="idclientej">
	 		';
	 		if ($dados_cli->num_rows() > 0){
	 			foreach ($dados_cli->result() as $row) {
	 				$codigo = str_pad($row->idcliente,30);
	 				$id = $row->idcliente; 

	 				$output .= '
			 			<option value="'.$id.'" selected>'.$codigo. 
			 								$row->nome.  
			 								$row->apelido. 
			 			'</option>'; 
	 			}

	 		}
	 		else {
	 			$output .= '
	 			<option>---- Nenhum item informado ---- </option>';
	 		}

	 		$output .= '
 			</select>
 		</div>'; 

 		echo $output;
 		exit; 

	}

}