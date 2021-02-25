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


	public function gravar_venda($idcaixa, $codigousuario, $situacaovenda, $tipovenda, $valorvenda, $valoracrescimo, $valordesconto, $idcliente, $tipopagamento, $vlsaldo_crediario)
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
		$dados["vlsaldo_crediario"]= $vlsaldo_crediario; 

		return $this->db->insert('venda',$dados); 
	}


	public function gravar_venda_item($idcaixa, $idvenda)
	{
		// vamos pegar os items da tab PRODUTO_CAIXA_TEMP e gravar na tab VENDA_ITEM
		$this->db->where('idcaixa=',$idcaixa);
		$this->db->where('situacao=',0); 
		$resultado_temp = $this->db->get('produto_caixa_temp')->result(); 

		if ($resultado_temp)
		{
			foreach ($resultado_temp as $produto_c_t) {
				$dados['idvenda']					= $idvenda; 
				$dados['idproduto'] 			= $produto_c_t->idproduto;
				$dados['codproduto']			= $produto_c_t->codproduto;
				$dados['valorunitario']	= $produto_c_t->vlpreco;
				$dados['quantidadeitens']= $produto_c_t->quantidadeitens;
				$dados['valortotal']			= $produto_c_t->valortotal;
				$dados['valordesconto']	=	$produto_c_t->valordesconto;
				$dados['valoracrescimo']	= $produto_c_t->valoracrescimo;	

				 // vamos gravar o item 
				 $this->db->insert('vendaitem',$dados);
			}

			// vamos selecionar os itens gravados para retornat
			$this->db->where('idvenda=',$idvenda);
			return $this->db->get('vendaitem')->result(); 

		}

	}

	public function finalizar_produto_caixa_temp($idcaixa)
	{

		$dados['situacao'] =1;

		$this->db->where('idcaixa=',$idcaixa); 
		$this->db->where('situacao=',0); 
		return $this->db->update('produto_caixa_temp', $dados); 

	}

	public function atualiza_saldo_crediario($idcliente, $valor , $tipo=null)
	{

		$this->db->where('idcliente=', $idcliente);
		$resultado = $this->db->get('venda_saldo_crediario')->result();
		if ($resultado){

			foreach ($resultado as $result) {
				$vl_total_compras = $result->vl_total_compras;
				$vl_total_pagamento = $result->vl_total_pagamento;
			}

			if ($tipo == "pagamento")
			{
				$vl_total_pagamento += $valor;
			}
			else
			{
				$vl_total_compras += $valor;
			}
			
			$vl_saldo_devedor = $vl_total_compras - $vl_total_pagamento; 

			$this->db->where('idcliente=', $idcliente);
			$dados['vl_total_compras'] = $vl_total_compras;
			$dados['vl_total_pagamento'] = $vl_total_compras;
			$dados['vl_saldo_devedor'] = $vl_saldo_devedor;

			$this->db->update('venda_saldo_crediario', $dados); 

		}else{
			$dados['idcliente']= $idcliente;
			$dados['vl_total_compras'] = $valor;
			$dados['vl_total_pagamento'] =0;
			$dados['vl_saldo_devedor'] = $valor;

			$this->db->insert('venda_saldo_crediario', $dados); 
		}

	}
	public function consulta_crediarios_cliente($idcliente, $consulta)
	{

		if ($consulta ==1)
		{
			$this->db->where('md5(idcliente)=',$idcliente);
			$this->db->order_by('idvenda','DESC');
			return $this->db->get('venda')->result();
		}
		else
		{
			$this->db->where('md5(idcliente)=',$idcliente);
			$this->db->from('venda');
			$this->db->join('vendaitem','vendaitem.idvenda = venda.idvenda');
			$this->db->join('produto','produto.idproduto = vendaitem.idproduto'); 
			$this->db->order_by('venda.idvenda','DESC');
			return $this->db->get()->result(); 
		 
		}
	 
	}

	public function consulta_venda($idvenda)
	{
		$this->db->where('md5(idvenda)=', $idvenda);
		return $this->db->get('venda')->result();

	}

	private function atualiza_venda_crediario($idvenda, $situacaovenda, $vlsaldo_crediario)
	{
		$dados['situacaovenda'] 		= $situacaovenda;
		$dados['vlsaldo_crediario']=	$vlsaldo_crediario; 

		$this->db->where('md5(idvenda)=', $idvenda); 
		$this->db->update('venda',$dados);
	}

	public function baixa_pagamento_crediario($idvenda,$vl_recebido_caixa)
	{

		// vamos iniciar a transação 
    $this->db->trans_begin();

			$resultado = $this->consulta_venda($idvenda); 

			foreach ($resultado as $venda) {
				$valorvenda = $venda->valorvenda;
				$vlsaldo_crediario_atual = $venda->vlsaldo_crediario;
				$idcliente = $venda->idcliente; 
				$situacaovenda = $venda->situacaovenda; 
			}

			// vamos amortizar o saldo 
			$vlsaldo_crediario =  $vlsaldo_crediario_atual-$vl_recebido_caixa;

			if ($vlsaldo_crediario <=0)
			{
				$situacaovenda =1;  // se zerar o saldo, vamos quitar a venda 
			}

			$this->atualiza_venda_crediario($idvenda,$situacaovenda,$vlsaldo_crediario);
			$this->atualiza_saldo_crediario($idcliente,$vl_recebido_caixa,"pagamento");

		if  ($this->db->trans_status()===FALSE ) 
		{ 
		  $this->db->trans_rollback(); 
		  $mensagem = "Houve um ERRO de TRANSAÇÃO! (venda_model/baixa_pagamento_crediario)"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Pagamento Realizado com Sucesso !"; 
			$this->session->set_userdata('mensagem',$mensagem); 
	
		}

	}



}