<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		if (!$this->session->userdata('logado')){
			$this->session->set_userdata('tipo_acesso',"venda");
			redirect(base_url('admin/login')); 
		}

		$this->load->model('produto_model','modelprodutos'); 
		$this->load->model('picklist_model','model_tipo_pagamento');
		$this->load->model('venda_model','modelvendas');
		$this->load->model('estoque_model','modelestoque');
		$this->load->model('caixa_model','modelcaixa_movimento'); 
		
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 
		//$this->caixa_movimento = $this->modelcaixa_movimento->movimentos_caixa(); 

	}

	public function movimentos_caixa()
	{

		if (!is_null($this->session->userdata('avista'))
			|| 
			 !is_null($this->session->userdata('cartaodebito'))
			|| 
			 !is_null($this->session->userdata('cartaocredito'))
			|| 
			 !is_null($this->session->userdata('crediario'))
			|| 
			 !is_null($this->session->userdata('crediarioreceb'))
		)
		{
			$dados['avista'] 				=$this->session->userdata('avista');
			$dados['cartaodebito'] 	=$this->session->userdata('cartaodebito');
			$dados['cartaocredito'] =$this->session->userdata('cartaocredito');
			$dados['crediario']			=$this->session->userdata('crediario');
			$dados['crediarioreceb']=$this->session->userdata('crediarioreceb');
			$dados['datainicio'] 		=$this->session->userdata('datainicio');
			$dados['datafinal']			=$this->session->userdata('datafinal');

			// encerrar sessoes 
			$this->session->unset_userdata('idcaixa');
			$this->session->unset_userdata('avista');
			$this->session->unset_userdata('cartaodebito');
			$this->session->unset_userdata('cartaocredito');
			$this->session->unset_userdata('crediario');
			$this->session->unset_userdata('crediarioreceb');
			$this->session->unset_userdata('datainicio');
			$this->session->unset_userdata('datafinal');
		}
		else
		{
			$dados['avista']				= null;
			$dados['cartaodebito'] 	= null;
			$dados['cartaocredito'] = null;
			$dados['crediario'] 		= null;
			$dados['crediarioreceb']= null;
			$dados['datainicio'] 		= null;
			$dados['datafinal']			= null; 
		}

		$idcaixa=1; 
		$dados['idcaixa']= $idcaixa; 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/caixa_movimentos');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer'); 

	}

	public function cancelamento_mov_caixa()
	{
		$idcaixa=1; 
		$datainicio = date('Y-m-d');
		$datafinal = date('Y-m-d'); 
		$this->load->library('table');

		$dados['movimento_caixa_do_dia']=$this->modelcaixa_movimento->getConsulta_movimento_caixa(md5($idcaixa), $datainicio, $datafinal);

		$dados['idcaixa']= $idcaixa; 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/caixa_movimentos_cancelamento');
		$this->load->view('frontend/template/html-footer');

	}

	public function confirma_cancelamento_mov($idcaixa_mov, $idvenda, $tipo_movimento)
	{
		// vamos iniciar a transação 
    $this->db->trans_begin();
    $resultado_cancel = $this->modelvendas->cancelar_venda($idvenda);
	
			if (!$resultado_cancel=="ok")
			{ 
				$mensagem = "Houve um erro ao Cancelar a Venda/Movimento (modelvendas/cancelar_venda)"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				$this->db->trans_rollback(); 
				redirect(base_url('caixa/cancelamento_mov_caixa')); 

			}

			if (!$this->modelcaixa_movimento->cancela_movimento_caixa($idcaixa_mov, $tipo_movimento))
			{
				$mensagem = "Houve um erro ao Cancelar a Venda/Movimento (modelcaixa_movimento/cancela_movimento_caixa)"; 
				$this->session->set_userdata('mensagemErro',$mensagem);
				$this->db->trans_rollback(); 
				redirect(base_url('caixa/cancelamento_mov_caixa')); 
			}

		if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (caixa/confirma_cancelamento_mov) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('caixa/cancelamento_mov_caixa'));
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Cancelamento Realizada com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem); 
			redirect(base_url('caixa/cancelamento_mov_caixa'));
	
		}

	}

	function consulta_dados_caixa()
	{
 	 
	 	$idcaixa = $this->input->post('idcaixa_mov');
	 	$datainicio = $this->input->post('datainicial_mov');
	 	$datafinal  = $this->input->post('datafinal_mov');  
	 	$idcaixa_md5 = md5($idcaixa); 

	 	$dados = $this->modelcaixa_movimento->getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal);

	 	$vl_movimento=0;
	 	$vl_juros =0;
	 	$vl_desconto =0; 
	 	$tipo_movimento; 

	 	$idcaixa_mov = 0;
	 	$idcliente =0; 
	 	$data_movimento =0; 
	 	$desmovimento = "";
	 	$despagamento = "";

	 	$avista = 0;
	 	$cartaodebito =0;
	 	$cartaocredito =0;
	 	$crediario =0;
	 	$crediarioreceb =0; 

		foreach ($dados as $movimento_caixa_result) 
		{
			$tipo_movimento= $movimento_caixa_result->tipo_movimento_caixa;
			$vl_movimento = $movimento_caixa_result->vl_movimento;
			$vl_juros 		= $movimento_caixa_result->vl_juros;
			$vl_desconto 	= $movimento_caixa_result->vl_desconto;
			$vl_real 			= $vl_movimento + $vl_juros - $vl_desconto; 

			$idcaixa_mov 	= $movimento_caixa_result->idcaixa_mov;
			$idcliente		= $movimento_caixa_result->idcliente;
			$data_movimento=$movimento_caixa_result->data_movimento;
			$desmovimento = $movimento_caixa_result->tipo_movimento_caixa;
			$despagamento	= $movimento_caixa_result->tipo_pagamento_crediario; 

			if ($tipo_movimento ==1)
			{
				$avista += $vl_real; 
			}
			elseif ($tipo_movimento ==2)
			{
				$cartaodebito += $vl_real;
			}
			elseif ($tipo_movimento ==3)
			{
				$cartaocredito += $vl_real;
			}
			elseif ($tipo_movimento ==4)
			{
				$crediario += $vl_real;
			}
			elseif ($tipo_movimento ==5)
			{
				$crediarioreceb += $vl_real; 
			}
	
		}

		if (!$avista
			&& 
			!$cartaodebito
			&& 
			!$cartaocredito
			&& 
			!$crediario
			&& 
			!$crediarioreceb
		)
		{
			$mensagem = "Nao ha movimento no periodo informado!"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 
		}
		else
		{
			$avista 			= reais($avista); 
			$cartaodebito	= reais($cartaodebito);
			$cartaocredito= reais($cartaocredito);
			$crediario 		= reais($crediario);
			$crediarioreceb = reais($crediarioreceb);

			$this->session->set_userdata('idcaixa',$idcaixa);
			$this->session->set_userdata('avista',$avista);
			$this->session->set_userdata('cartaodebito',$cartaodebito);
			$this->session->set_userdata('cartaocredito',$cartaocredito);
			$this->session->set_userdata('crediario',$crediario);
			$this->session->set_userdata('crediarioreceb',$crediarioreceb);
			$this->session->set_userdata('datainicio',$datainicio);
			$this->session->set_userdata('datafinal',$datafinal);
		}
		 
		redirect(base_url('caixa/movimentos_caixa')); 

	}




	function consultajquery_dados_caixa()
	{

	 	$output = '';
 	 
	 	$idcaixa = $this->input->post('idcaixa_mov');
	 	$datainicio = $this->input->post('datainicial_mov');
	 	$datafinal  = $this->input->post('datafinal_mov');  
	 	$mov_avista  = $this->input->post('mov_avista');
	 	$mov_debito  = $this->input->post('mov_debito');
	 	$mov_credito  = $this->input->post('mov_credito');
	 	$mov_crediario  = $this->input->post('mov_crediario');
	 	$mov_crediariorec  = $this->input->post('mov_crediariorec');
	 	$mov_externa  = $this->input->post('mov_externa');
	 	$porJQuery = $this->input->post('porJQuery'); 
	 	$idcaixa_md5 = md5($idcaixa);

	 	$dados = $this->modelcaixa_movimento->getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal, $mov_avista, $mov_debito, $mov_credito, $mov_crediario, $mov_crediariorec, $mov_externa, $porJQuery);

 
	 	$vl_movimento=0;
	 	$vl_juros =0;
	 	$vl_desconto =0; 
	 	$tipo_movimento; 

	 	$idcaixa_mov = 0;
	 	$idcliente =0; 
	 	$data_movimento =0; 
	 	$desmovimento = "";
	 	$despagamento = "";

	 	$avista = 0;
	 	$cartaodebito =0;
	 	$cartaocredito =0;
	 	$crediario =0;
	 	$crediarioreceb =0; 
	 	$vl_real =0; 
	 	$total_real=0; 


	

		foreach ($dados as $movimento_caixa_result) 
		{
			$tipo_movimento= $movimento_caixa_result->tipo_movimento_caixa;
			$vl_movimento = $movimento_caixa_result->vl_movimento;
			$vl_juros 		= $movimento_caixa_result->vl_juros;
			$vl_desconto 	= $movimento_caixa_result->vl_desconto;
			$vl_real 			= $vl_movimento + $vl_juros - $vl_desconto; 

			$idcaixa_mov 	= $movimento_caixa_result->idcaixa_mov;
			$idcliente		= $movimento_caixa_result->idcliente;
			$data_movimento= datebr($movimento_caixa_result->data_movimento);
			$desmovimento = $movimento_caixa_result->desmovimento;
			$despagamento	= $movimento_caixa_result->destipopagamento; 
			$codigousuario = $movimento_caixa_result->codigousuario; 

			$total_real += $vl_real; 

			$vl_juros = reais($vl_juros); 
			$vl_desconto = reais($vl_desconto);
			$vl_real = reais($vl_real); 


			/*
			if ($tipo_movimento ==1)
			{
				$avista += $vl_real; 
			}
			elseif ($tipo_movimento ==2)
			{
				$cartaodebito += $vl_real;
			}
			elseif ($tipo_movimento ==3)
			{
				$cartaocredito += $vl_real;
			}
			elseif ($tipo_movimento ==4)
			{
				$crediario += $vl_real;
			}
			elseif ($tipo_movimento ==5)
			{
				$crediarioreceb += $vl_real; 
			}
			*/

			$output .= '
				<tr>
		 			<td>	'.$idcaixa_mov.			'</td>  
		 			<td>	'.$data_movimento.	'</td>
		 			<td>	'.$codigousuario.		'</td>
		 			<td>	'.$desmovimento.		'</td>
		 			<td>	'.$despagamento.		'</td>
		 			<td>	'.$vl_juros.				'</td>
		 			<td>	'.$vl_desconto.			'</td>
		 			<td>	'.$vl_real.					'</td>
		 		</tr>	'			 
			; 
		}

		if ($total_real > 0)
		{
			$total_real = reais($total_real); 

			$output .= '
				<tr>
	        <th scope="col"> TOTAL R$ </th>
	        <td> '.$total_real.'</td> 
	      </tr> 
				r>'; 
		}

	
 		echo $output;
 		exit; 

	}


}
