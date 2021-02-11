<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda_model extends CI_Model
{

	public $id;
	public $desproduto; 

	public function __construct(){

		parent::__construct(); 

	}

	
	public function adicionar_temp($idcaixa,$idproduto,$codproduto,$desproduto,$vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal)
	{

		$dados["idcaixa"]	= $idcaixa;
		$dados["idproduto"]	= $idproduto;
		$dados["codproduto"]		= $codproduto;
		$dados["desproduto"]	= $desproduto;
		$dados["vlpreco"]	= $vlpreco;
		$dados["vlprecoatacado"]			= $vlprecoatacado;
		$dados["qtatacado"]			= $qtatacado;
		$dados["vlpromocao"]		= $vlpromocao;
		$dados["vlpromocaoatacado"]		= $vlpromocaoatacado;
		$dados["quantidadeitens"]= $quantidadeitens;
		$dados["valordesconto"]			= $valordesconto;
		$dados["valoracrescimo"]	= $valoracrescimo;
		$dados["valortotal"]	= $valortotal;

		return $this->db->insert('produto_caixa_temp',$dados); 
	}

	public function excluir_produto_temp($id){
		$this->db->where('md5(id)=',$id);
		return $this->db->delete('produto_caixa_temp');
	}

	public function listar_produtos_temp($idcaixa)
	{

		$this->db->where('idcaixa=',$idcaixa); 
		$this->db->order_by('id','DESC'); 
		return $this->db->get('produto_caixa_temp')->result(); 

	}

}