<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa_model extends CI_Model
{


	public function __construct(){

		parent::__construct(); 

	}

	
	public function grava_caixa_mov($idcaixa, $idvenda, $idcliente, $codigousuario, 
		$tipo_movimento_caixa, $vl_movimento, $vl_juros, $vl_desconto, $tipo_pagamento=null, $valor_recebido=null, $valor_troco=null)
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

		return $this->db->insert('caixa_movimento', $dados); 
	}

	public function getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal, $mov_avista=null, $mov_debito=null, $mov_credito=null, $mov_crediario=null, $mov_crediariorec=null, $mov_externa=null, $porJQuery=null)
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

		if (!$mov_avista && !$mov_debito && !$mov_credito && !$mov_crediario &&
				!$mov_crediariorec && !$mov_externa && $porJQuery=="S")
		{
			$datainicio =0;
			$datafinal=0;
		}

		$this->db->where('md5(idcaixa)=',$idcaixa_md5);
		$this->db->where('DATE(data_movimento) >=', date('Y-m-d',strtotime($datainicio)));
		$this->db->where('DATE(data_movimento) <=', date('Y-m-d',strtotime($datafinal)));
		 

		$this->db->from('caixa_movimento');
		$this->db->join('tipo_movimento_caixa',
										'tipo_movimento_caixa.id=caixa_movimento.tipo_movimento_caixa');
		$this->db->join('tipo_pagamento',
										'tipo_pagamento.id = caixa_movimento.tipo_pagamento_crediario'); 

		$this->db->order_by('data_movimento','ASC'); 
	
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


}