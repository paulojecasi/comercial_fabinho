<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		$this->load->model('cliente_model','modelcliente'); 

	}

	public function consulta_cliente()
	{
		$idcliente = $this->input->post('idclientej');
		$idcaixa = $this->input->post('idcaixa'); 

		if (!$idcliente){
			$mensagem = "Cliente Invalido! Selecione ao menos um cliente para buscar"; 
			$this->session->set_userdata('mensagemErro',$mensagem);

			redirect(base_url('venda/venda_pagamento/').$idcaixa.'/4'); 
		}

		$cliente_consultado = $this->modelcliente->consulta_cliente($idcliente);
		if ($cliente_consultado){
			foreach ($cliente_consultado as $clicons) {
				$this->session->set_userdata('idcliente',$clicons->idcliente);
				$this->session->set_userdata('nome',$clicons->nome);
				$this->session->set_userdata('apelido',$clicons->apelido);
				$this->session->set_userdata('endereco',$clicons->endereco);
				$this->session->set_userdata('cpf',$clicons->cpf);
			}
		}
		redirect(base_url('venda/venda_pagamento/').$idcaixa.'/4');

	
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