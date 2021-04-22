<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque_model extends CI_Model {

	public function __construct(){

		parent::__construct(); 

	}
 
	public function listar_entradas(){

/*
		$this->db->from('estoque_entrada');

		$this->db->join('estoque_entrada_item',
										'estoque_entrada_item.idestoque_entrada = estoque_entrada.id','rigth');

		$this->db->order_by('dataentrada','DESC'); 

		return $this->db->get()->result();  */

		$this->db->order_by('dataentrada','DESC'); 

		return $this->db->get('estoque_entrada')->result();


	}

	public function listar_estoque($idestoque_entrada){

		$this->db->from('estoque_entrada');
		$this->db->where('md5(id)=', $idestoque_entrada);
		return $this->db->get()->result(); 
		
	}

	public function valida_produtos(){
		$this->db->where('produtoativo=',1);
		$this->db->where('desproduto!=',"");
		$this->db->where('vlpreco > ',0); 
	}

	public function listar_estoque_itens($idestoque_entrada){
		
		$this->valida_produtos(); 
		$this->db->from('estoque_entrada_item');
		$this->db->join('produto',
										'produto.idproduto=estoque_entrada_item.idproduto');
		$this->db->where('md5(idestoque_entrada)=', $idestoque_entrada);
		return $this->db->get()->result(); 
		
	}

	public function verifica_item_existente($idproduto, $idestoque_entrada){

		$this->db->where('md5(idestoque_entrada)=', $idestoque_entrada);
		$this->db->where('md5(idproduto)=', $idproduto);
		$this->db->where('tiposituacao!=',2);
		return $this->db->get('estoque_entrada_item')->result(); 
	}

	public function adicionar($nrnota, $serie, $emitente, $valornota){

		$dados = array (
			"nrnota" 				=> $nrnota, 
			"serie" 				=> $serie,
			"emitente"			=> $emitente,
			"valornota"			=> $valornota 
		); 

		return $this->db->insert('estoque_entrada',$dados); 
		
	}

	public function inserir_estoque_item($idproduto, $idestoque_entrada,$nrnota,$vlunitario,$quantidade,$vltotal,$vlAtualItem=null,$vlAtualItemAtacado=null){

		$this->atualiza_valor_nota_produto($idproduto,$vlunitario,$vlAtualItem,$vlAtualItemAtacado); 

		$dados = array (
			"idestoque_entrada" => $idestoque_entrada,
			"nrnota_entrada" 		=> $nrnota,
			"idproduto" 				=> $idproduto, 
			"quantidade"				=> $quantidade,
			"vlunitario"				=> $vlunitario,
			"vltotal"						=> $vltotal
		); 

		$this->atualiza_saldo_produto($idproduto, $quantidade); 

		$this->movimento_estoque($nrnota,$idproduto,$idestoque_entrada,1,$quantidade);

		return $this->db->insert('estoque_entrada_item',$dados); 
		
	}

	public function consulta_estoque_saldo($idproduto){
		// vamos consultar o saldo atual  
		$this->db->select('qtsaldo'); 
		$this->db->where('md5(idproduto)=', $idproduto);
		$resultado = $this->db->get('estoque_saldo')->result();
		if ($resultado){
			foreach ($resultado as $key) {
				$saldo_atual = $key->qtsaldo; 
			}

			return $saldo_atual;  
		} 
	}

	public function movimento_estoque($nrnota=null, $idproduto,$idestoque_entrada=null,$tipomovimento,$quantidade,$idvenda=null){

		// vamos consultar o saldo atual do produto
		$saldo_atual = $this->consulta_estoque_saldo(md5($idproduto)); 
		
		if ($nrnota)
		{
			$dados['nrnota']						= $nrnota; 
			$dados['idproduto'] 				= $idproduto; 
			$dados['idestoque_entrada'] = $idestoque_entrada;
			$dados['tipomovimento']			= $tipomovimento;
			$dados['quantidade']				= $quantidade; 
		} 
		else 
		{
			$dados['nrnota']						= $nrnota; 
			$dados['idproduto'] 				= $idproduto; 
			$dados['idestoque_entrada'] = $idestoque_entrada;
			$dados['tipomovimento']			= $tipomovimento;
			$dados['quantidade']				= $quantidade;
			$dados['idvenda']						= $idvenda; 

		}

		if ($tipomovimento ==1 ||$tipomovimento ==2)	{
			// ENTTRADAS
				$dados['saldo']							= $quantidade + $saldo_atual;
		}else{
			// SAIDAS 
				$dados['saldo']							= $saldo_atual - $quantidade;
		}

		if ($this->db->insert('estoque_movimento',$dados))
		{
			if ($this->atualiza_estoque_saldo($idproduto, $quantidade, $tipomovimento))
			{
		
				return "OK"; 

			}
		}
	}


	private function atualiza_saldo_produto($idproduto, $qtsaldo)
	{
		$this->db->where('idproduto=', $idproduto);
		$dados['qtsaldo'] = $qtsaldo;
		$this->db->update('produto',$dados); 
	}

	private function atualiza_valor_nota_produto($idproduto, $vlunitario, $vlAtualItem=null,$vlAtualItemAtacado=null)
	{
		$this->db->where('idproduto=', $idproduto);
		$dados['vlnota'] = $vlunitario;

		if ($vlAtualItem > 0)
		{
			$dados['vlpreco'] = $vlAtualItem;
		}

		if ($vlAtualItemAtacado > 0)
		{
			$dados['vlprecoatacado'] = $vlAtualItemAtacado;
		}

		$this->db->update('produto',$dados); 
	}

	public function atualiza_estoque_saldo($idproduto, $quantidade, $tipomovimento){

		$saldo_atualizado = $this->consulta_estoque_saldo(md5($idproduto)); 

		if ($saldo_atualizado){
			// se existir, vamos atualizar o saldo - update
			if ($tipomovimento == 1 || $tipomovimento == 2 ){

				$saldo_atualizado = $saldo_atualizado + $quantidade; 

			}	else {

				$saldo_atualizado = $saldo_atualizado - $quantidade;

			}

			$dados = array (
				"qtsaldo"	=> $saldo_atualizado
			); 

			$this->atualiza_saldo_produto($idproduto, $saldo_atualizado); 

			$this->db->where('idproduto=',$idproduto); 
			return $this->db->update('estoque_saldo',$dados); 

		}else{
			// se nao existir, vamos criar - insert 
			$dados = array (
				"idproduto" 		=> $idproduto, 
				"qtsaldo"				=> $quantidade
			); 

			$this->db->insert('estoque_saldo',$dados); 

		}

	}

	public function consulta_movimento_estoque($idproduto,$datainicial,$datafinal){

		//$this->db->where('datamovimento>=',$datainicial);
		//$this->db->where('datamovimento<=',$datafinal); 

		$this->db->from('estoque_movimento');
		$this->db->join('tipo_movimento',
										'tipo_movimento.id = estoque_movimento.tipomovimento'); 
		$this->db->where('DATE(datamovimento) >=', date('Y-m-d',strtotime($datainicial)));
		$this->db->where('DATE(datamovimento) <=', date('Y-m-d',strtotime($datafinal)));
		$this->db->where('md5(idproduto)=', $idproduto);	
		$this->db->order_by('estoque_movimento.datamovimento'); 	
		return $this->db->get()->result();
	}

	public function cancelar_item($id, $idproduto, $idestoque_entrada){
		
		//echo "===============".$id; 
		//exit; 
		// atualizando movimento de saida do estoque e saldo 
		$this->db->where('md5(idproduto)=',$idproduto);
		$this->db->where('md5(idestoque_entrada)=',$idestoque_entrada);
		$estoque_movimento_saida = $this->db->get('estoque_movimento')->result();
 
		if ($estoque_movimento_saida){
			foreach ($estoque_movimento_saida as $estoque_movimento) {
				$nrnota = $estoque_movimento->nrnota;
				$idproduto = $estoque_movimento->idproduto;
				$idestoque_entrada = $estoque_movimento->idestoque_entrada;
				$tipomovimento = $estoque_movimento->tipomovimento;
				$quantidade = $estoque_movimento->quantidade; 
			}

			$this->movimento_estoque($nrnota,$idproduto,$idestoque_entrada,4,$quantidade); 

			//-------  cancelar item de entrada na nota 
			$dados['tiposituacao'] = 2; 
			$this->db->where('md5(id)=',$id);
			return $this->db->update('estoque_entrada_item',$dados); 

		} 
	}

	public function getNumero_nota_auto(){

		$this->db->from("controle_entrada_sem_nota"); 
		return $this->db->get()->result(); 


	}


	public function setNumero_nota_auto($nr_nota)
	{

		$dados['codigo_nota_automatica']= $nr_nota;
		$this->db->where('id=1');
		return $this->db->update("controle_entrada_sem_nota",$dados);

	}


	public function getQuantidade_item_temp($idcaixa, $idproduto)
	{
		$this->db->where('idcaixa=',$idcaixa); 
		$this->db->where('idproduto=',$idproduto); 
		$this->db->where('situacao=',0); 
		return $this->db->get('produto_caixa_temp')->result(); 
	}


	public function fechar_cancelar_nota($solicitacao, $idestoque_entrada)
	{

		$dados['situacao']=$solicitacao;

		$this->db->where('md5(id)=', $idestoque_entrada);
		$this->db->update('estoque_entrada',$dados);

		return $this->fechar_cancelar_nota_item($solicitacao, $idestoque_entrada); 		
	}

	private function fechar_cancelar_nota_item($solicitacao, $idestoque_entrada)
	{
		$dados['tiposituacao']=$solicitacao;

		$this->db->where('md5(idestoque_entrada)=', $idestoque_entrada);
		$this->db->where('tiposituacao=0'); 
		return $this->db->update('estoque_entrada_item',$dados);

	}

}