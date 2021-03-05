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

		if (is_null($this->session->userdata('avista'))
			&& 
			is_null($this->session->userdata('cartaodebito'))
			&& 
			is_null($this->session->userdata('cartaocredito'))
			&& 
			is_null($this->session->userdata('crediario'))
			&& 
			is_null($this->session->userdata('crediarioreceb'))
		)
		{

			$mensagem = "Nao ha movimento no periodo informado!"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 

		}
		 
		redirect(base_url('caixa/movimentos_caixa')); 

	}




	function consultajquery_dados_caixa()
	{

	 	$output = '';
 	 
	 	$idcaixa = $this->input->post('idcaixa_mov');
	 	$datainicio = $this->input->post('datainicial_mov');
	 	$datafinal  = $this->input->post('datafinal_mov');  
	 	$idcaixa_md5 = md5($idcaixa); 

	 	$dados = $this->modelcaixa_movimento->getConsultajquery_movimento_caixa($idcaixa_md5, $datainicio, $datafinal);

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

		$avista 			= reais($avista); 
		$cartaodebito	= reais($cartaodebito);
		$cartaocredito= reais($cartaocredito);
		$crediario 		= reais($crediario);
		$crediarioreceb = reais($crediarioreceb);

		$output .= '

			<div class ="text-center"> 
				<h4> Referente a '.datebr($datainicio).'  a  '.datebr($datafinal).'</h4> 
			</div> 
			<div class="col-lg-12 sec-recebi">
          <div class="col-lg-7 titulo-pag">
              <h3> A Vista  </h3>
          </div>
          <div class="col-lg-4 valor-pag">
              <h3> '.$avista.'  </h3>
          </div>
          <div class="col-lg-1 form-check btn-ver-mov-caixa">
            <input class="form-check-input" type="checkbox" value="1" id="btn-lista-mov-cx1">
          </div> 
                           
      </div>


      <div class="col-lg-12 sec-recebi">
          <div class="col-lg-7 titulo-pag">
              <h3> Recebimentos Crediário </h3>
          </div>
          <div class="col-lg-4 valor-pag">
              <h3> '.$crediarioreceb.'  </h3>
          </div>
          <div class="col-lg-1 form-check btn-ver-mov-caixa">
            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="5" id="btn-lista-mov-cx5">
          </div> 
      </div>

      <div class="col-lg-12 sec-recebi">
          <div class="col-lg-7 titulo-pag">
              <h3> Vendas Externas </h3>
          </div>
          <div class="col-lg-4 valor-pag">
              <h3> 0,00  </h3>
          </div>
          <div class="col-lg-1 form-check btn-ver-mov-caixa">
            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="8" id="btn-lista-mov-cx8">
          </div> 
      </div>


      <div class="col-lg-12 sec-recebi">
          <div class="col-lg-7 titulo-pag">
              <h3> Cartão Débito </h3>
          </div>
          <div class="col-lg-4 valor-pag">
              <h3> '.$cartaodebito.'  </h3>
          </div>
          <div class="col-lg-1 form-check btn-ver-mov-caixa">
            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="2" id="btn-lista-mov-cx2">
          </div> 
      </div>

      <div class="col-lg-12 sec-recebi">
          <div class="col-lg-7 titulo-pag">
              <h3> Cartão Crédito </h3>
          </div>
          <div class="col-lg-4 valor-pag">
              <h3> '.$cartaocredito.' </h3>
          </div>
          <div class="col-lg-1 form-check btn-ver-mov-caixa">
            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="3" id="btn-lista-mov-cx3">
          </div> 
      </div>


      <div class="col-lg-12 sec-recebi">
          <div class="col-lg-7 titulo-pag">
              <h3> Crediário </h3>
          </div>
          <div class="col-lg-4 valor-pag">
              <h3> '.$crediario.' </h3>
          </div>
          <div class="col-lg-1 form-check btn-ver-mov-caixa">
            <input class="form-check-input ckeck-mov-caixa" type="checkbox" value="4" id="btn-lista-mov-cx4">
          </div> 
      </div>

 

		';

	 
 		echo $output;
 		exit; 

	}


}
