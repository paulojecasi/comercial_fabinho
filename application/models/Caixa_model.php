<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa_model extends CI_Model
{


	public function __construct(){

		parent::__construct(); 

	}

	public function getOperacaoCaixa($idcaixa_usuario)
	{
		$this->db->where('idcaixa=',$idcaixa_usuario);
		return $this->db->get('caixa')->result(); 
	}

	public function grava_caixa_mov($idcaixa, $idvenda, $idcliente, $codigousuario, 
		$tipo_movimento_caixa, $vl_movimento, $vl_juros, $vl_desconto, $tipo_pagamento=null, $valor_recebido=null, $valor_troco=null, $idretirada=null)
	{

		$dados['idcaixa'] 						= $idcaixa;
		$dados['idvenda'] 						= $idvenda;
		$dados['idcliente']						= $idcliente; 
		$dados['codigousuario'] 			= $codigousuario;
		$dados['tipo_movimento_caixa']= $tipo_movimento_caixa;
		$dados['tipo_pagamento_crediario'] = $tipo_pagamento;
		$dados['vl_movimento'] 				= $vl_movimento;
		$dados['vl_juros'] 						= $vl_juros;
		$dados['vl_desconto'] 				= $vl_desconto;
		$dados['VALOR_RECEBIDO'] = $valor_recebido;
		$dados['VALOR_TROCO'] = $valor_troco;
		$dados['situacao'] =0;  
		$dados['idretirada'] = $idretirada;  
		$dados['fl_fechado'] =0; 

		return $this->db->insert('caixa_movimento', $dados); 
	}

	public function grava_caixa_retirada($idcaixa,$valor_retirada, $tipo_retirada, $codigousuario,$desretirada)
	{

		$dados['idcaixa'] = $idcaixa; 
		$dados['valor']=$valor_retirada;
		$dados['tiporetirada'] = $tipo_retirada;
		$dados['situacao'] =0;
		$dados['idusuario'] = $codigousuario; 
		$dados['desretirada']= $desretirada; 

		return $this->db->insert('retiradas',$dados);
	}

	public function cancela_caixa_retirada($idretirada)
	{

		$dados['situacao'] =1; 
		$this->db->where('md5(id)=',$idretirada); 
		return $this->db->update('retiradas',$dados);
	}

	public function getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal, $mov_avista=null, $mov_debito=null, $mov_credito=null, $mov_crediario=null, $mov_crediariorec=null, $mov_externa=null, $porJQuery=null, $mov_retirada=null, $mov_troco_ini=null, $mov_pix=null)
	{
		if ($mov_avista){
			$this->db->where('tipo_movimento_caixa=',$mov_avista); 
		}
		if ($mov_debito){
			$this->db->or_where('tipo_movimento_caixa=',$mov_debito); 
		}
		if ($mov_credito){
			$this->db->or_where('tipo_movimento_caixa=',$mov_credito); 
		}
		if ($mov_crediario){
			$this->db->or_where('tipo_movimento_caixa=',$mov_crediario); 
		}
		if ($mov_crediariorec){
			$this->db->or_where('tipo_movimento_caixa=',$mov_crediariorec); 
		}
		if ($mov_externa){
			$this->db->or_where('tipo_movimento_caixa=',$mov_externa); 
		}
		if ($mov_troco_ini){
			$this->db->or_where('tipo_movimento_caixa=',$mov_troco_ini); 
		}
		if ($mov_retirada){
			$this->db->or_where('tipo_movimento_caixa=',$mov_retirada); 
		}
		if ($mov_pix){
			$this->db->or_where('tipo_movimento_caixa=',$mov_pix); 
		}

		if (!$mov_avista && !$mov_debito && !$mov_credito && !$mov_crediario &&
				!$mov_crediariorec && !$mov_externa && $porJQuery=="S" && !$mov_troco_ini && !$mov_retirada && !$mov_pix)
		{
			$datainicio =0;
			$datafinal=0;
		}

		$this->db->where('md5(caixa_movimento.idcaixa)=',$idcaixa_md5);
		$this->db->where('DATE(data_movimento) >=', date('Y-m-d',strtotime($datainicio)));
		$this->db->where('DATE(data_movimento) <=', date('Y-m-d',strtotime($datafinal)));
		 
		$this->db->from('caixa_movimento');
		$this->db->join('tipo_movimento_caixa',
										'tipo_movimento_caixa.id=caixa_movimento.tipo_movimento_caixa');
		$this->db->join('tipo_pagamento',
										'tipo_pagamento.id = caixa_movimento.tipo_pagamento_crediario'); 
		$this->db->join('venda',
										'venda.idvenda = caixa_movimento.idvenda','left'); 

		$this->db->order_by('data_movimento','ASC'); 
	
		return $this->db->get()->result(); 

	}


	public function getConsulta_movimento_caixa_produto($idcaixa_md, $datainicio, $datafinal)
	{

		
		$this->db->where('md5(caixa_movimento.idcaixa)=',$idcaixa_md);
		$this->db->where('DATE(data_movimento) >=', date('Y-m-d',strtotime($datainicio)));
		$this->db->where('DATE(data_movimento) <=', date('Y-m-d',strtotime($datafinal)));
		$this->db->where('situacao=0'); 
		
		$tipo_mov_caixa_where = array(1,2,3,4,8,11);  // somente vendas 

		$this->db->where_in('tipo_movimento_caixa',$tipo_mov_caixa_where);

		$this->db->from('caixa_movimento');

		$this->db->join('venda',
										'venda.idvenda = caixa_movimento.idvenda'); 

		$this->db->join('vendaitem',
										'vendaitem.idvenda = venda.idvenda'); 

		$this->db->join('produto',
										'produto.idproduto = vendaitem.idproduto'); 

		$this->db->order_by('produto.idproduto','ASC');
		return $this->db->get()->result(); 

	}

	public function cancela_movimento_caixa($idcaixa_mov, $tipo_movimento)
	{
		 

		if ($tipo_movimento == 5) // cancelar movimento de recebimento
		{
			$dados['situacao']= 2;
		}
		else
		{
			$dados['situacao']=1;
		}

		$this->db->where('md5(idcaixa_mov)=', $idcaixa_mov);
		return $this->db->update('caixa_movimento',$dados);
		
	} 

	public function encerra_sessoes_caixa()
	{

		$this->session->unset_userdata('avista');
		$this->session->unset_userdata('cartaodebito');
		$this->session->unset_userdata('cartaocredito');
		$this->session->unset_userdata('crediario');
		$this->session->unset_userdata('crediarioreceb');
		$this->session->unset_userdata('vendaexterna');
		$this->session->unset_userdata('datainicio');
		$this->session->unset_userdata('datafinal');
		$this->session->unset_userdata('valor_disp_cx');
		$this->session->unset_userdata('trocoini');
		$this->session->unset_userdata('retirada_dinheiro');
		$this->session->unset_userdata('pix_transferencia'); 
		$this->session->unset_userdata('valor_total_mov');

	}

	public function getListar_caixas()
	{
		$this->db->from('caixa');
		$this->db->order_by('idcaixa');
		return $this->db->get()->result();
	}

	public function abertura_fechamento_caixa($idcaixa_md, $valor,$tipomovimento)
	{
 
 		if ($tipomovimento == "abertura")
 		{	 			
	 		$dados['dataabertura'] =date('Y-m-d H:i:s'); 
			$dados['situacaocaixa'] = 1; // situacao 0=Fechada, 1=Aberto
			$dados['valorinicial'] = $valor; 
			$this->db->where('md5(idcaixa)=', $idcaixa_md);
			return $this->db->update('caixa',$dados); 
		}
		else
		{
			$dados['datafechamento'] =date('Y-m-d H:i:s'); 
			$dados['situacaocaixa'] = 0; // situacao 0=Fechada, 1=Aberto
			$dados['valorfechamento'] = $valor; 
			$this->db->where('md5(idcaixa)=', $idcaixa_md);
			return $this->db->update('caixa',$dados); 
		}

	}

	public function grava_fechamento($dados)
	{
		return $this->db->insert('caixa_fecha',$dados);

	}

	public function fecha_movimento_caixa($idcaixa_md, $datainicio, $datafinal)
	{
		
		$dados['fl_fechado']=1;   // 0= movimento aberto, 1= movimento fechado
		$this->db->where('md5(idcaixa)=', $idcaixa_md); 
		$this->db->where('fl_fechado=',0); 
		$this->db->where('DATE(data_movimento) >=', date('Y-m-d',strtotime($datainicio)));
		$this->db->where('DATE(data_movimento) <=', date('Y-m-d',strtotime($datafinal)));
		return $this->db->update('caixa_movimento', $dados); 
	}
}