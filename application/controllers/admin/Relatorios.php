<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		//$this->session->set_userdata('tipo_acesso',"venda");
		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();
		
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio(); 
	
		$this->load->model('caixa_model','modelcaixas'); 
		$this->load->model('venda_model','modelvendas');
		$this->load->model('cliente_model','modelclientes');

	}

	public function index()
	{

		//$dados['idcaixa'] 	= $this->session->userdata('idcaixa');
		$dados['lista_caixas']  = $this->modelcaixas->getListar_caixas(); 
	
		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/relatorio/relatorio-opc');
		$this->load->view('backend/template/footer');
		$this->load->view('backend/template/html-footer'); 

	}

	public function rel_opc()
	{
		$opc_rel = $this->input->post('opc-rel-caixa'); 

		if ($opc_rel==1)
		{
			$this->rel_caixa_fecha(); 
		}
		elseif ($opc_rel==2)
		{
			$this->movimentos_produtos_rel(); 
		} 
		elseif ($opc_rel==3 || $opc_rel==4 || $opc_rel==5)
		{
			$this->movimentos_produtos_crediario_rel($opc_rel); 
		} 
		elseif ($opc_rel==6)
		{
			$this->movimentos_vendas_cred_rel(); 
		} 
		elseif ($opc_rel==7)
		{
			$this->cliente_faixa_atraso_cred_rel(); 
		} 

	}

	public function rel_caixa_fecha()
	{
		$idcaixa = $this->input->post('idcaixa_rel');
		$idcaixa = intval($idcaixa);  
		$datainicio = $this->input->post('datainicial_rel'); 
		$datafinal =  $this->input->post('datafinal_rel'); 

		$resultts = $this->modelcaixas->relatorio_caixa_fechamento(md5($idcaixa),$datainicio,$datafinal);

		$dados['titulo'] = "Relatorio detalhado do fechamento do caixa :  ".$idcaixa; 
		$dados['datainicio'] = $datainicio;
		$dados['datafinal'] = $datafinal;

		$dados['relatorio_fechamento_cx'] = $resultts; 
			 
		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/relatorio/caixa-fechamento-rel');
		$this->load->view('backend/template/footer');
		$this->load->view('backend/template/html-footer');

	}

	public function movimentos_produtos_rel()
	{
		//$this->modelcaixa_movimento->encerra_sessoes_caixa();  

		$idcaixa = $this->input->post('idcaixa_rel');
		$idcaixa_md = intval($idcaixa); 
		$idcaixa_md = md5($idcaixa_md); 

		$datainicio = $this->input->post('datainicial_rel'); 
		$datafinal =  $this->input->post('datafinal_rel');

		if (!$datainicio) 
		{
			$datainicio = date('Y-m-d');
			$datafinal = date('Y-m-d');
		} 

		$this->load->library('table'); 


		$dados['movimento_produto_caixa']=$this->modelcaixas->getConsulta_movimento_caixa_produto($idcaixa_md, $datainicio, $datafinal);

		$dados['titulo'] = "Movimentos dos produtos vendidos, do caixa : ".$idcaixa; 
		$dados['datainicio'] 	= $datainicio;
		$dados['datafinal']		= $datafinal;

		$this->load->view('backend/template/html-header', $dados); 
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		//$this->load->view('frontend/caixa_movimentos_produtos');
		$this->load->view('backend/relatorio/produto-movimento-rel');
		$this->load->view('backend/template/footer');
		$this->load->view('backend/template/html-footer');

	}

	public function movimentos_produtos_crediario_rel($tp_rel)
	{
		//$this->modelcaixa_movimento->encerra_sessoes_caixa();  

		$idcaixa = $this->input->post('idcaixa_rel');
		$idcaixa_md = intval($idcaixa); 
		$idcaixa_md = md5($idcaixa_md); 

		$datainicio = $this->input->post('datainicial_rel'); 
		$datafinal =  $this->input->post('datafinal_rel');

		if (!$datainicio) 
		{
			$datainicio = date('Y-m-d');
			$datafinal = date('Y-m-d');
		} 

		$this->load->library('table'); 

	
		$dados['movimento_produto_caixa']=$this->modelcaixas->getConsulta_movimento_caixa_produto_crediario($idcaixa_md, $datainicio, $datafinal, $tp_rel);

		if ($tp_rel==3)
		{
			$dados['titulo'] = "[TODOS] - Movimentos dos produtos vendidos a crediário, do caixa : ".$idcaixa; 
		}
		elseif ($tp_rel==4)
		{
			$dados['titulo'] = "[QUITADOS] - Movimentos dos produtos vendidos a crediário, do caixa : ".$idcaixa; 
		}
		elseif ($tp_rel==5)
		{
			$dados['titulo'] = "[NÃO PAGOS] - Movimentos dos produtos vendidos a crediário, do caixa : ".$idcaixa; 
		}

		$dados['datainicio'] 	= $datainicio;
		$dados['datafinal']		= $datafinal;

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		//$this->load->view('frontend/caixa_movimentos_produtos');
		$this->load->view('backend/relatorio/produto-movimento-crediario-rel');
		$this->load->view('backend/template/footer');
		$this->load->view('backend/template/html-footer');

	}

	public function movimentos_vendas_cred_rel()
	{
		//$this->modelcaixa_movimento->encerra_sessoes_caixa();  

		$idcaixa = $this->input->post('idcaixa_rel');
		$idcaixa_md = intval($idcaixa); 
		$idcaixa_md = md5($idcaixa_md); 

		$datainicio = $this->input->post('datainicial_rel'); 
		$datafinal =  $this->input->post('datafinal_rel');

		if (!$datainicio) 
		{
			$datainicio = date('Y-m-d');
			$datafinal = date('Y-m-d');
		} 

		$this->load->library('table'); 

		$dados['vendas_crediario_saldo']=$this->modelvendas->getConsulta_vendas_crediario_rel($idcaixa_md, $datainicio, $datafinal);
		$dados['clientes']=$this->modelclientes->getConsultaClientes();

		$dados['titulo'] = "Vendas Crediário vendidos e recebidos, do caixa : ".$idcaixa; 
		$dados['datainicio'] 	= $datainicio;
		$dados['datafinal']		= $datafinal;

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/relatorio/venda-crediario-saldo-rel');
		$this->load->view('backend/template/footer');
		$this->load->view('backend/template/html-footer');

	}

	public function cliente_faixa_atraso_cred_rel()
	{
		//$this->modelcaixa_movimento->encerra_sessoes_caixa();  

		$idcaixa = $this->input->post('idcaixa_rel');
		$idcaixa_md = intval($idcaixa); 
		$idcaixa_md = md5($idcaixa_md); 

		$datainicio = $this->input->post('datainicial_rel'); 
		$datafinal =  $this->input->post('datafinal_rel');

		if (!$datainicio) 
		{
			$datainicio = date('Y-m-d');
			$datafinal = date('Y-m-d');
		} 

		$this->load->library('table'); 

		$dados['cliente_faixa_atraso']=$this->modelclientes->getCliente_faixa_atraso_rel($datainicio, $datafinal);
		//$dados['clientes']=$this->modelclientes->getConsultaClientes();

		$dados['titulo'] = "Clientes por faixa de dias de atraso : "; 
		$dados['datainicio'] 	= $datainicio;
		$dados['datafinal']		= $datafinal;

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/relatorio/cliente-faixa-atraso-rel');
		$this->load->view('backend/template/footer');
		$this->load->view('backend/template/html-footer');

	}

}