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

	public function adicionar_tempj($idcaixa,$idproduto,$codproduto,$desproduto,$vlpreco_custo, $vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal)
	{

		$dados["idcaixa"]	= $idcaixa;
		$dados["idproduto"]	= $idproduto;
		$dados["codproduto"]		= $codproduto;
		$dados["desproduto"]	= $desproduto;
		$dados["valor_custo"]	= $vlpreco_custo;
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
		//exit; 
	}

	public function excluir_produto_temp($id){

		if ($this->db->where('md5(id)=',$id)){
			return $this->db->delete('produto_caixa_temp');
		}
		
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

	public function cancelar_venda($idvenda)
	{

		$dados['situacaovenda'] = 2; // cancelada - Tabela SITUACAO_VENDA
		$this->db->where('md5(idvenda)=', $idvenda);
		$this->db->update('venda',$dados); 

		// vamos cancelar o Item da Venda. 
		$resultado = $this->cancelar_item_venda($idvenda); 
		return $resultado; 

	}

	private function cancelar_item_venda($idvenda_md5)
	{
		if ($itens_venda_cancel = $this->getConsulta_itens_da_venda($idvenda_md5))
		{
			foreach ($itens_venda_cancel as $item_venda_cancel) {
				$situacaovenda_item = $item_venda_cancel->situacaovenda_item;
				$idvendaitem 				= $item_venda_cancel->idvendaitem;
				$idproduto 					= $item_venda_cancel->idproduto; 
				$quantidade 				= $item_venda_cancel->quantidadeitens; 
				$idvenda 						= $item_venda_cancel->idvenda; 

				if ($situacaovenda_item != 2) // ver se o item não está cancelado
				{	
					// vamos cancelar o item
					$dados['situacaovenda_item'] =2;
					$this->db->where('idvendaitem=', $idvendaitem);
					$this->db->update('vendaitem', $dados);

					// vamos devolver o item para o estoque
					$tipomovimento = 2; // Entrada no estoque por cancelamento de venda 
					$this->load->model('estoque_model','modelestoque');
					$resultado_mov = $this->modelestoque->movimento_estoque($idvenda,$idproduto,0,$tipomovimento,$quantidade,$idvenda); 

				} 
			}

			return $resultado_mov; 

		} 
	}

	private function getConsulta_itens_da_venda($idvenda)
	{
		$this->db->where('md5(idvenda)=', $idvenda);
		return $this->db->get('vendaitem')->result(); 
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
				$dados['valor_custo']			= $produto_c_t->valor_custo;
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

	public function consulta_saldo_crediario($idcliente_md)
	{
		$this->db->where('md5(idcliente)=', $idcliente_md);
		return $this->db->get('venda_saldo_crediario')->result();
	}

	public function atualiza_saldo_crediario($idcliente, $idcliente_md, $valor , $tipo=null)
	{

		$resultado = $this->consulta_saldo_crediario($idcliente_md); 
		if ($resultado){

			foreach ($resultado as $result) {
				$vl_total_compras = $result->vl_total_compras;
				$vl_total_pagamento = $result->vl_total_pagamento;
			}

			if ($tipo == "pagamento")
			{
				$vl_total_pagamento += $valor;
			}
			elseif ($tipo == "cancelamento_venda")
				$vl_total_compras -= $valor; 
			else
			{
				$vl_total_compras += $valor;
			}
			
			$vl_saldo_devedor = $vl_total_compras - $vl_total_pagamento; 

			$this->db->where('idcliente=', $idcliente);
			$dados['vl_total_compras'] = $vl_total_compras;
			$dados['vl_total_pagamento'] = $vl_total_pagamento;
			$dados['vl_saldo_devedor'] = $vl_saldo_devedor;

			$resultado_saldo = $this->db->update('venda_saldo_crediario', $dados);

			if ($resultado_saldo) 
			{
				// carregar saldo numa session 
				$this->session->set_userdata('vl_saldo_devedor',$vl_saldo_devedor); 
			}
			return $resultado_saldo;  

		}
		else
		{

			$dados['idcliente']= $idcliente;
			$dados['vl_total_compras'] = $valor;
			$dados['vl_total_pagamento'] =0;
			$dados['vl_saldo_devedor'] = $valor;

			$this->db->insert('venda_saldo_crediario', $dados); 
		}

	}
	public function consulta_crediarios_cliente($idcliente)
	{

			$this->db->where('md5(idcliente)=',$idcliente);
			
			$this->db->order_by('idvenda','DESC');
			//$this->db->order_by('datavenda','DESC');
			return $this->db->get('venda')->result();
	 
	}

	public function consulta_venda($idvenda)
	{
		$this->db->where('md5(idvenda)=', $idvenda);
		return $this->db->get('venda')->result();

	}

	public function atualiza_venda_crediario($idvenda, $situacaovenda=null, $vlsaldo_crediario)
	{
		if ($situacaovenda)
		{
			$dados['situacaovenda'] 		= $situacaovenda;
		}

		$dados['vlsaldo_crediario']=	$vlsaldo_crediario; 

		$this->db->where('md5(idvenda)=', $idvenda); 
		return $this->db->update('venda',$dados);
	}


	public function tipo_pagamento()
	{
		
		$this->db->where('tipopagamento != 4');
		return $this->db->get('tipo_pagamento')->result(); 

	}

	function consultajquery_itens_venda($idvenda_it)
	{
		if (strlen($idvenda_it)>0) 
		{

			$this->db->where('md5(idvenda)=',$idvenda_it);
			$this->db->from('vendaitem');
			$this->db->join('produto','produto.idproduto = vendaitem.idproduto'); 
			$this->db->order_by('vendaitem.idvendaitem','ASC');
			return $this->db->get()->result();  
		} 
		else 
		{
			$this->db->where('idvenda_it=', 'NULL'); 
			return $this->db->get('vendaitem'); 
		}

	}

	function consultajquery_pagamento($idvenda)
	{
		if (strlen($idvenda)>0) 
		{

			$this->db->where('md5(idvenda)=',$idvenda);
			$this->db->where('tipo_movimento_caixa=',5); 
			$this->db->from('caixa_movimento');
			$this->db->join('tipo_pagamento','tipo_pagamento.id = caixa_movimento.tipo_pagamento_crediario'); 
			$this->db->order_by('caixa_movimento.data_movimento','ASC');
			return $this->db->get()->result();   
		} 
		else 
		{
			$this->db->where('idvenda=', 'NULL'); 
			return $this->db->get('caixa_movimento'); 
		}

	}



}