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
		$dados["situacao"]	= 0;

		return $this->db->insert('produto_caixa_temp',$dados); 
	}

	public function excluir_produto_temp($id){
		$this->db->where('md5(id)=',$id);
		return $this->db->delete('produto_caixa_temp');
	}

	public function listar_produto_temp($id)
	{

		$this->db->where('md5(id)=',$id); 
		return $this->db->get('produto_caixa_temp')->result(); 

	}

	public function listar_produtos_temp($idcaixa)
	{

		$this->db->where('idcaixa=',$idcaixa); 
		$this->db->where('situacao=',0); 
		$this->db->order_by('id','DESC'); 
		return $this->db->get('produto_caixa_temp')->result(); 

	}

	/*
	public function venda_pagamento($id_caixa)
	{
		$this->db->where('md5(idcaixa)=',$id_caixa); 
		$this->db->where('situacao=',0); 
		return $this->db->get('produto_caixa_temp')->result();
	}
	*/

	public function alterar_produto_temp_tem($quantidadeitens,$valordesconto,$valoracrescimo,$valortotal,$id)
	{
		$dados['quantidadeitens'] = $quantidadeitens;
		$dados['valordesconto'] 	= $valordesconto;
		$dados['valoracrescimo'] 	= $valoracrescimo;
		$dados['valortotal'] 			= $valortotal;

		$this->db->where('id=',$id);
		return $this->db->update('produto_caixa_temp',$dados); 
	}


	public function gravar_venda($idcaixa, $codigousuario, $situacaovenda, $tipovenda, $valorvenda, $valoracrescimo, $valordesconto, $idcliente, $tipopagamento)
	{

		$dados["idcaixa"]	= $idcaixa;
		$dados["codigousuario"]	= $codigousuario;
		$dados["situacaovenda"]		= $situacaovenda;
		$dados["tipovenda"]	= $tipovenda;
		$dados["valorvenda"]	= $valorvenda;
		$dados["valoracrescimo"]	= $valoracrescimo;
		$dados["valordesconto"]			= $valordesconto;
		$dados["idcliente"]		= $idcliente;
		$dados["tipopagamento"]		= $tipopagamento;

		return $this->db->insert('venda',$dados); 
	}

	public function finalizar_produto_caixa_temp($idcaixa){

		$dados['situacao'] =1;

		$this->db->where('idcaixa=',$idcaixa); 
		$this->db->where('situacao=',0); 
		return $this->db->update('produto_caixa_temp', $dados); 

	}

	public function atualiza_saldo_crediario($idcliente, $valorvenda){

		$this->db->where('idcliente=', $idcliente);
		$resultado = $this->db->get('venda_saldo_crediario')->result();
		if ($resultado){

			foreach ($resultado as $result) {
				$vl_total_compras = $result->vl_total_compras;
				$vl_total_pagamento = $result->vl_total_pagamento;
			}

			$vl_total_compras += $valorvenda;
			$vl_saldo_devedor = $vl_total_compras - $vl_total_pagamento; 

			$this->db->where('idcliente=', $idcliente);
			$dados['vl_total_compras'] = $vl_total_compras;
			$dados['vl_saldo_devedor'] = $vl_saldo_devedor;

			$this->db->update('venda_saldo_crediario', $dados); 

		}else{
			$dados['idcliente']= $idcliente;
			$dados['vl_total_compras'] = $valorvenda;
			$dados['vl_total_pagamento'] =0;
			$dados['vl_saldo_devedor'] = $valorvenda;

			$this->db->insert('venda_saldo_crediario', $dados); 
		}

	}



}