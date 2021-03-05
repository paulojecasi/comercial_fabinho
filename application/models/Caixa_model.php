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

		return $this->db->insert('caixa_movimento', $dados); 
	}

	public function getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal)
	{

		$this->db->where('md5(idcaixa)=',$idcaixa_md5);
		$this->db->where('DATE(data_movimento) >=', date('Y-m-d',strtotime($datainicio)));
		$this->db->where('DATE(data_movimento) <=', date('Y-m-d',strtotime($datafinal)));
		return $this->db->get('caixa_movimento')->result(); 

	}



}