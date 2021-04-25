<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 
 
		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();

		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio();

		$this->load->model('cliente_model','modelcliente'); 
		$this->load->model('venda_model','modelvendas'); 
		$this->load->model('caixa_model','modelcaixa_movimento');
	}

	public function manutencao_clientes($tipo_acesso=null){

		if ($tipo_acesso == "cliente_aberto")
		{
			$this->encerra_sessions(); 
		}

		$this->modelcaixa_movimento->encerra_sessoes_caixa(); 

		$idcaixa= $this->session->userdata('idcaixa'); 
		$dados['idcaixa'] = $idcaixa; 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/cliente');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	public function cadastro_cliente($localchamado=null){
		$idcaixa= $this->session->userdata('idcaixa');
		$dados['localchamado'] = $localchamado; 
		$dados['idcaixa'] = $idcaixa;
		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/cliente_cadastro');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');
	}


	public function inserir($localchamado=null)
	{
		$idcaixa= $this->session->userdata('idcaixa');
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
				$this->session->set_userdata('mensagemAlert',$mensagem); 

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
		$idcaixa= $this->session->userdata('idcaixa');
		$dados['idcaixa'] = $idcaixa;
		$dados['cliente_consultado'] = $this->modelcliente->consulta_cliente($idcliente);

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/cliente_altera');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');
	}

	public function confirma_alteracao($idcliente)
	{
		$idcaixa= $this->session->userdata('idcaixa');
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
				$this->session->set_userdata('mensagemAlert',$mensagem); 

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

		$dados['nome_cli'] 		= null; 
		$dados['codigo_cli'] 	= null;
		$dados['saldo_cli'] 	= null;

		if ($localchamado == "cliente_cred_aberto"){
			  $localchamado = "cliente"; 
			$resultado_con = $this->modelcliente->lista_cliente_divida_aberto($idcliente);
			foreach ($resultado_con as $cliente_divida) {
				$dados['nome_cli'] 		= $cliente_divida->nome; 
				$dados['codigo_cli'] 	= $cliente_divida->idcliente;
				$dados['saldo_cli'] 	= $cliente_divida->vl_saldo_devedor;
			}
		}

		$this->load->library('table'); 

		$idcaixa= $this->session->userdata('idcaixa'); 
		$dados['idcaixa'] 	= $idcaixa;
		$dados['idcliente'] = $idcliente;
		$dados['localchamado'] = $localchamado; 

		$dados['vendas_cli']= 
			$this->modelvendas->consulta_crediarios_cliente($idcliente);

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/cliente_consulta_crediario');
		//$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	private function consulta_saldo_crediario($idcliente)
	{

		$saldo_dev = $this->modelvendas->consulta_saldo_crediario($idcliente);
		
		foreach ($saldo_dev as $saldo_cred) 
		{
			$this->session->set_userdata('vl_saldo_devedor',$saldo_cred->vl_saldo_devedor); 
		}

	}

	public function pagamento_crediario($idvenda)
	{

		$idcaixa= $this->session->userdata('idcaixa'); 
		$dados['idcaixa'] = $idcaixa; 
		$dados['venda_cliente'] = $this->modelvendas->consulta_venda($idvenda);
		$dados['tipo_pagamento'] = $this->modelvendas->tipo_pagamento(); 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/cliente_pagamento_crediario');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	public function pagamento_crediario_confirma($idvenda_md, $idcliente_md)
	{

		$idcaixa= $this->session->userdata('idcaixa');
		$idusuario 	= $this->session->userdata('userLogado')->id;
		$vl_amortizacao = $this->input->post('vl_real_amortizacao');
		$tipo_pagamento = $this->input->post('idpagamento');

		$vl_recebido   	= $this->input->post('vl_recebido_caixa_cred'); 
		$vl_troco 			=	$this->input->post('vl_troco_cred'); 
		$vl_movimento 	= $vl_recebido - $vl_troco; 
		$vl_juros				= $this->input->post('vl_juros_caixa_cred');
		$vl_desconto		= $this->input->post('vl_desconto_caixa_cred');
		// vamos iniciar a transação 

		if ($vl_recebido <=0)
		{
			$mensagem = "Informe o Valor Recebido!"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 
			redirect(base_url('cliente/pagamento_crediario/').$idvenda_md);
		}
		
    $this->db->trans_begin();

			$resultado = $this->modelvendas->consulta_venda($idvenda_md); 
			foreach ($resultado as $venda) {
				$valorvenda = $venda->valorvenda;
				$vlsaldo_crediario_atual = $venda->vlsaldo_crediario;
				$idcliente = $venda->idcliente; 
				$situacaovenda = $venda->situacaovenda; 
				$idvenda = $venda->idvenda;
			}

			// vamos amortizar o saldo 
			$vlsaldo_crediario =  $vlsaldo_crediario_atual-$vl_amortizacao;

			if ($vlsaldo_crediario <=0)
			{
				$situacaovenda =1;  // se zerar o saldo, vamos quitar a venda 
			}

			$this->modelvendas->atualiza_venda_crediario($idvenda_md,$situacaovenda,$vlsaldo_crediario);

			$this->modelvendas->atualiza_saldo_crediario($idcliente,$idcliente_md,$vl_amortizacao,"pagamento");

			$tipomovimento_caixa = 5; // recebimento crediario  
			$this->modelcaixa_movimento->grava_caixa_mov($idcaixa,$idvenda,$idcliente,$idusuario,$tipomovimento_caixa,$vl_movimento,$vl_juros,$vl_desconto,$tipo_pagamento,$vl_recebido,$vl_troco); 

			// consulta e atualiza saldo devedor do cliente 
			$this->consulta_saldo_crediario($idcliente_md);

		if  ($this->db->trans_status()===FALSE ) 
		{ 
		  $this->db->trans_rollback(); 
		  $mensagem = "Houve um ERRO de TRANSAÇÃO! (venda_model/baixa_pagamento_crediario)"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Pagamento Realizado com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem); 
	
		}
			 
		redirect(base_url('cliente/consulta_crediario/').$idcliente_md.'/cliente');
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


	private function encerra_sessions()
	{

		$this->session->unset_userdata('idcliente');
		$this->session->unset_userdata('nome');
		$this->session->unset_userdata('apelido');
		$this->session->unset_userdata('endereco');
		$this->session->unset_userdata('pontoreferencia');
		$this->session->unset_userdata('cpf');

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
      <option id="option-primeira-linha" disabled> CÓDIGO   &nbsp &nbsp   NOME </option>
	 		';
	 		if ($dados_cli->num_rows() > 0){
	 			foreach ($dados_cli->result() as $row) {
	 				$codigo = str_pad($row->idcliente,30);
	 				$id = $row->idcliente; 

	 				$output .= '
			 			<option value="'.$id.'" selected>'
			 								.$codigo.' &nbsp &nbsp'. 
			 								$row->nome.  
			 							
			 			'</option>'; 
	 			}

	 		}

 		echo $output;
 		exit; 

	}

	public function consultajquery_clientes()
	{

		$id_solicitacao = $this->input->post('id_solicitacao');
		 	   
		if ($id_solicitacao != 1){
			exit;
		}
		
		//$this->session->set_userdata('consulta_cli',"S");

		/*
		echo "oooooooooooooooooooooooooooooooooooooooo"; 
		echo 
		'<script>
	    	alert("'.$id_solicitacao.'"); 
	  </script>'; 
	  */

		$resultado = $this->modelcliente->lista_clientes_divida_aberto();
		$total_saldo_aberto =0;

		if ($resultado)
		{
			$output ='';
			foreach ($resultado as $clientes_list):

	      $codigo 	= $clientes_list->idcliente; 
	      $nome 		= $clientes_list->nome;
	      $apelido 	= $clientes_list->apelido;
	      $endereco = $clientes_list->endereco;
	      $pontoreferencia = $clientes_list->pontoreferencia;
	      $cpf			= $clientes_list->cpf;
	      $saldo_devedor = $clientes_list->vl_saldo_devedor;

	      $total_saldo_aberto += $saldo_devedor; 

				//$this->carrega_sessions($codigo, $nome, $apelido, $endereco, $pontoreferencia, $cpf);
       	//$this->session->set_userdata('vl_saldo_devedor',$saldo_devedor);
     
       	$saldo_devedor = reais($saldo_devedor);  
       	//$total_saldo_aberto = reais($total_saldo_aberto);
	     
	      $botaoconsultar=anchor(base_url('cliente/consulta_crediario/'.md5($codigo).'/cliente_cred_aberto'),
	          '<h4 class="btn-alterar"><i class="fa fa-eye fa-fw"></i> </i> </h4>');

	      $output.='<tr>
							 			<td>						'.$codigo.			'</td>  
							 			<td>					  '.$nome.				'</td>
							 			<td>					  '.$apelido.			'</td>
							 			<td>					  '.$cpf.					'</td>
							 			<td class="valor-saldo-dev"> '.$saldo_devedor.					'</td>
							 			<td>					  '.$botaoconsultar.		'</td>  
							 		</tr>' ;

	  	endforeach; 
	  	$output.= '<th scope="row"> TOT- R$ <b id="tot-sld-ab"> '.reais($total_saldo_aberto).'</b> </th>';

	  
	 		echo $output;

		}

	}


}