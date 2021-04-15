<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		//$this->session->set_userdata('tipo_acesso',"venda");
		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();
		
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio(); 
	
		$this->load->model('caixa_model','modelcaixas'); 

	}

	public function index()
	{

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		// dados a serem enviados para o cabeçalho
		$dados['subtitulo'] = "Abertura e Fechamento de Caixa"; 
		$dados['lista_caixas']  = $this->modelcaixas->getListar_caixas();  

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/caixa');
		$this->load->view('backend/template/html-footer'); 

	}

	public function abrir($idcaixa)
	{

		// dados a serem enviados para o cabeçalho
		$dados['titulo'] = "Abertura do Movimento Diário de Caixa"; 
		$dados['lista_caixas']  = $this->modelcaixas->getListar_caixas();  
		$dados['idcaixa'] = $idcaixa; 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/caixa_abertura');
		$this->load->view('backend/template/html-footer'); 

	}

	public function confirma_abertura($idcaixa)
	{

		$valor_troco_ini=0; 

		$idcaixa_md = md5($idcaixa); 
		$valor_troco_ini = $this->input->post('vltrocoini'); 

		// vamos iniciar a transação 
    $this->db->trans_begin();

		if (!$this->modelcaixas->abertura_fechamento_caixa($idcaixa_md, $valor_troco_ini,"abertura"))
		{
			$mensagem ="Erro ao abrir o Caixa, Verifique !"; 

			$this->db->trans_rollback(); 

			$this->session->set_userdata('mensagemErro',$mensagem); 

			redirect(base_url('admin/caixa/abrir/'.$idcaixa)); 
		}

		$idvenda = 0;
		$idcliente= 0;
		$idusuario 	= $this->session->userdata('userLogado')->id; 
		$tipomovimento_caixa = 10; // troco inicial 
		$valorvenda = $valor_troco_ini; 
		$valoracrescimo =0;
		$valordesconto =0;
		$valor_recebido=0;
		$valor_troco=0; 

		if (!$this->modelcaixas->grava_caixa_mov($idcaixa,$idvenda,$idcliente,$idusuario,$tipomovimento_caixa,$valorvenda,$valoracrescimo,$valordesconto,5,$valor_recebido,$valor_troco))
		{
			$mensagem ="Erro ao gravar o movimento do caixa (modelcaixa_movimento/grava_caixa_mov)"; 
			$this->db->trans_rollback(); 
			$this->session->set_userdata('mensagemErro',$mensagem); 

			redirect(base_url('admin/caixa/abrir/'.$idcaixa)); 
		}

		if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (caixa/confirma_abertura) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('venda'));
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem ="O Caixa foi aberto com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem); 
			redirect(base_url('admin/caixa'));	
	
		}

	}

	public function fechar($idcaixa)
	{
		$datainicio =date('Y-m-d');	
		$datafinal  =date('Y-m-d');

		$this->consulta_dados_caixa_admin($idcaixa, $datainicio, $datafinal);

		$dados['avista']				= null;
		$dados['cartaodebito'] 	= null;
		$dados['cartaocredito'] = null;
		$dados['crediario'] 		= null;
		$dados['crediarioreceb']= null;
		$dados['datainicio'] 		= null;
		$dados['datafinal']			= null; 
		$dados['vendaexterna']	= null; 
		$dados['valor_disp_cx']	= null; 
		$dados['trocoini']			= null; 
		$dados['retirada_dinheiro']	= null; 

		$dados['avista'] 				=$this->session->userdata('avista');
		$dados['cartaodebito'] 	=$this->session->userdata('cartaodebito');
		$dados['cartaocredito'] =$this->session->userdata('cartaocredito');
		$dados['crediarios']			=$this->session->userdata('crediario');
		$dados['crediarioreceb']=$this->session->userdata('crediarioreceb');
		$dados['datainicio'] 		=$this->session->userdata('datainicio');
		$dados['datafinal']			=$this->session->userdata('datafinal');
		$dados['vendaexterna']	=$this->session->userdata('vendaexterna');
		$dados['valor_total_cx'] =$this->session->userdata('valor_total_cx');
		$dados['trocoini']			=$this->session->userdata('trocoini');
		$dados['retirada_dinheiro']			=$this->session->userdata('retirada_dinheiro');

		// dados a serem enviados para o cabeçalho
		$dados['titulo'] = "Fechamento do Movimento Diário de Caixa"; 
		$dados['lista_caixas']  = $this->modelcaixas->getListar_caixas();  
		$dados['idcaixa'] = $idcaixa; 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/caixa_fechamento');
		$this->load->view('backend/template/html-footer');

		$this->modelcaixas->encerra_sessoes_caixa(); 

	}


	public function confirma_fechamento($idcaixa)
	{

		$idcaixa_md = md5($idcaixa); 
		$datainicio = $this->input->post('dt-inicio-fecha'); 
		$datafinal =  $this->input->post('dt-final-fecha'); 
		
		$dados['idcaixa'] = $idcaixa;
		$dados['idusuario'] 	= $this->session->userdata('userLogado')->id; 

		$dados['vltroco_inicial'] = $this->input->post('vl_troco_ini'); 
		$dados['vlavista'] = $this->input->post('vl-avista-fec'); 
		$dados['vlavista_con'] = $this->input->post('vl-avista-fec-c');
		$dados['vlavista_fs'] = $this->input->post('vl-avista-fec-fs');
		$dados['vlreceb_cred'] = $this->input->post('vl-rec-cred-fec');
		$dados['vlreceb_cred_con'] = $this->input->post('vl-rec-cred-fec-c');
		$dados['vlreceb_cred_fs'] = $this->input->post('vl-rec-cred-fec-fs');
		$dados['vlvendaexterna'] = $this->input->post('vl-ext-fec');
		$dados['vlvendaexterna_con'] = $this->input->post('vl-ext-fec-c');
		$dados['vlvendaexterna_fs'] = $this->input->post('vl-ext-fec-fs');
		$dados['vlcdebito'] = $this->input->post('vl-cdeb-fec');
		$dados['vlcdebito_con'] = $this->input->post('vl-cdeb-fec-c');
		$dados['vlcdebito_fs'] = $this->input->post('vl-cdeb-fec-fs');
		$dados['vlccredito'] = $this->input->post('vl-ccre-fec');
		$dados['vlccredito_con'] = $this->input->post('vl-ccre-fec-c');
		$dados['vlccredito_fs'] = $this->input->post('vl-ccre-fec-fs');
		$dados['vlcrediario'] = $this->input->post('vl-crediar-fec');
		$dados['vlcrediario_con'] = $this->input->post('vl-crediar-fec-c');
		$dados['vlcrediario_fs'] = $this->input->post('vl-crediar-fec-fs');
		$dados['vlretiradas'] = $this->input->post('vl-ret-fec');
		$dados['vlretiradas_con'] = $this->input->post('vl-ret-fec-c');
		$dados['vlretiradas_fs'] = $this->input->post('vl-ret-fec-fs');
		$dados['vltotal'] = $this->input->post('vl-total-fec');
		$dados['vltotal_con'] = $this->input->post('vl-total-fec-c');
		$dados['vltotal_fs'] = $this->input->post('vl-total-fec-fs');

		// vamos iniciar a transação 
    $this->db->trans_begin();

    // gravar fechamento na tabela CAIXA_FECHA
    if (!$this->modelcaixas->grava_fechamento($dados))
		{
			$mensagem ="Erro ao gravar fechamento do Caixa(modelcaixas/grava_fechamento)"; 

			$this->db->trans_rollback(); 

			$this->session->set_userdata('mensagemErro',$mensagem); 

			redirect(base_url('admin/caixa/fechar/'.$idcaixa)); 
		}

		// fechar movimento do caixa na tabela CAIXA_MOVIMENTO 
		if (!$this->modelcaixas->fecha_movimento_caixa($idcaixa_md, $datainicio, $datafinal))
		{
			$mensagem ="Erro ao gravar fechamento do Caixa(modelcaixas/fecha_movimento_caixa)"; 

			$this->db->trans_rollback(); 

			$this->session->set_userdata('mensagemErro',$mensagem); 

			redirect(base_url('admin/caixa/fechar/'.$idcaixa)); 
		}

		// fechar caixa na tabela CAIXA
		if (!$this->modelcaixas->abertura_fechamento_caixa($idcaixa_md, $vltotal_con,"fechamento"))
		{
			$mensagem ="Erro ao gravar fechamento do Caixa(modelcaixas/abertura_fechamento_caixa)";  

			$this->db->trans_rollback(); 

			$this->session->set_userdata('mensagemErro',$mensagem); 

			redirect(base_url('admin/caixa/fechar/'.$idcaixa)); 
		}

		if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (admin/caixa/confirma_fechamento) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('admin/caixa/fechar/'.$idcaixa)); 
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Fechamento do Caixa Realizada com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem); 
			$this->modelcaixas->encerra_sessoes_caixa(); 
			//$this->session->unset_userdata('idcaixa');
			redirect(base_url('admin/caixa')); 
	
		}

	}

	public function consulta_dados_caixa_admin($idcaixa, $datainicio, $datafinal)
	{ 

	 	$idcaixa_md5 = md5($idcaixa); 
	 	// vamos ver se nos ultimos 5 dias, se o caixa ficou aberto
	 	$datainicio = date('Y-m-d', strtotime($datainicio. ' - 5 days'));
 		
		$this->modelcaixas->encerra_sessoes_caixa(); 

	 	$dados = $this->modelcaixas->getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal);

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
	 	$trocoini=0; 
	 	$valor_disp_cx =0; 
	 	$retirada_dinheiro=0; 
	 	$vendaexterna=0; 
	 	$fl_fechado =0; 
	 	$datainicio =0; 

		foreach ($dados as $movimento_caixa_result) 
		{
			if ($datainicio ==0) // pegar a data do primeiro dia de movimento 
			{
				$datainicio = $movimento_caixa_result->data_movimento; 
			}
			$tipo_movimento= $movimento_caixa_result->tipo_movimento_caixa;
			$vl_movimento = $movimento_caixa_result->vl_movimento;
			$vl_juros 		= $movimento_caixa_result->vl_juros;
			$vl_desconto 	= $movimento_caixa_result->vl_desconto;
			$vl_real 			= $vl_movimento + $vl_juros - $vl_desconto; 
			$situacao			= $movimento_caixa_result->situacao;
			$idcaixa_mov 	= $movimento_caixa_result->idcaixa_mov;
			$idcliente		= $movimento_caixa_result->idcliente;
			$data_movimento=$movimento_caixa_result->data_movimento;
			$desmovimento = $movimento_caixa_result->tipo_movimento_caixa;
			$despagamento	= $movimento_caixa_result->tipo_pagamento_crediario; 
			$fl_fechado		= $movimento_caixa_result->fl_fechado; 

			if ($situacao ==0 && $fl_fechado==0 )  	// se nao for cancelado, se não for 
																							// movimento de caixa já fechado 
			{

				if ($tipo_movimento ==10)
				{
					$trocoini += $vl_movimento; 
				}
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
				elseif ($tipo_movimento ==8)
				{
					$vendaexterna += $vl_real; 
				}
				elseif ($tipo_movimento ==9)
				{
					$retirada_dinheiro += $vl_movimento; 
				}

				$valor_total_cx = $trocoini+$avista+$cartaodebito+$cartaocredito+$crediario+$crediarioreceb+$vendaexterna-$retirada_dinheiro; 
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
			&& 
			!$vendaexterna
			&& 
			!$trocoini
		)
		{
			$mensagem = "Nao ha movimento no periodo informado!"; 
			$this->session->set_userdata('datainicio',$datainicio);
			$this->session->set_userdata('datafinal',$datafinal);
			$this->session->set_userdata('mensagemErro',$mensagem); 
		}
		else
		{
			
			$this->session->set_userdata('idcaixa',$idcaixa);
			$this->session->set_userdata('avista',$avista);
			$this->session->set_userdata('cartaodebito',$cartaodebito);
			$this->session->set_userdata('cartaocredito',$cartaocredito);
			$this->session->set_userdata('crediario',$crediario);
			$this->session->set_userdata('crediarioreceb',$crediarioreceb);
			$this->session->set_userdata('vendaexterna',$vendaexterna);
			$this->session->set_userdata('datainicio',$datainicio);
			$this->session->set_userdata('datafinal',$datafinal);
			$this->session->set_userdata('valor_total_cx',$valor_total_cx);
			$this->session->set_userdata('trocoini',$trocoini);
			$this->session->set_userdata('retirada_dinheiro',$retirada_dinheiro);
		}
		 
		//redirect(base_url('admin/caixa/movimentos_caixa')); 

	}

}