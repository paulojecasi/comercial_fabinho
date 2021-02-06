<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque_model extends CI_Model {

	public function __construct(){

		parent::__construct(); 

	}

	public function listar_entradas(){

		//consulta no banco ondenando pelo titulo (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('dataentrada','DESC'); 

		// vamos informar a tabela e trazer o resultado 
		return $this->db->get('estoque_entrada')->result(); 

	}

	public function listar_estoque($idestoque){

		$this->db->from('estoque_entrada');
		$this->db->where('md5(id)=', $idestoque);
		return $this->db->get()->result(); 
		
	}

	public function valida_produtos(){
		$this->db->where('produtoativo=',1);
		$this->db->where('desproduto!=',"");
		$this->db->where('vlpreco > ',0); 
	}

	public function listar_estoque_itens($idestoque){
		
		$this->valida_produtos(); 
		$this->db->from('estoque_entrada_item');
		$this->db->join('produto','produto.idproduto=estoque_entrada_item.idproduto');
		$this->db->where('md5(idestoque_entrada)=', $idestoque);
		return $this->db->get()->result(); 
		
	}

	public function verifica_item_existente($idproduto, $idestoque_entrada){

		$this->db->where('md5(idestoque_entrada)=', $idestoque_entrada);
		$this->db->where('md5(idproduto)=', $idproduto);
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

	public function inserir_estoque_item($idproduto, $idestoque_entrada,$vlunitario,$quantidade,$vltotal){

		$dados = array (
			"idestoque_entrada" => $idestoque_entrada,
			"idproduto" 				=> $idproduto, 
			"quantidade"				=> $quantidade,
			"vlunitario"				=> $vlunitario,
			"vltotal"			=> $vltotal
		); 

		$this->movimento_estoque($idproduto,$idestoque_entrada,1,$quantidade);

		return $this->db->insert('estoque_entrada_item',$dados); 
		
	}

	public function movimento_estoque($idproduto,$idestoque_entrada,$tipomovimento,$quantidade){

		if ($tipomovimento ==1){ // 1 =  entrada no estoque 
				$dados = array (
					"idproduto" 				=> $idproduto, 
					"idestoque_entrada" => $idestoque_entrada,
					"tipomovimento"			=> $tipomovimento,
					"quantidade"				=> $quantidade
				); 
				$this->db->insert('estoque_movimento',$dados); 
				$this->atualiza_estoque_saldo($idproduto,$quantidade); 
		} 
	}

	public function atualiza_estoque_saldo($idproduto, $quantidade){
		$this->db->select('qtsaldo'); 
		$this->db->where('idproduto=', $idproduto);
		$resultado = $this->db->get('estoque_saldo')->result();

		if ($resultado){
			// se existir, vamos atualizar o saldo - update
			foreach ($resultado as $key) {
				$saldo_atualizado = $key->qtsaldo; 
			}

			$saldo_atualizado = $saldo_atualizado + $quantidade; 

			$dados = array (
				"qtsaldo"	=> $saldo_atualizado
			); 
			$this->db->where('idproduto=',$idproduto); 
			$this->db->update('estoque_saldo',$dados); 

		}else{
			// se nao existir, vamos criar - insert 
			$dados = array (
				"idproduto" 				=> $idproduto, 
				"qtsaldo"				=> $quantidade
			); 

			$this->db->insert('estoque_saldo',$dados); 

		}

	}



/*
	public function excluir($id){

		$this->db->where('md5(id)=', $id);
		return $this->db->delete('categoria');  

	}

	public function listar_categoria($id){

		$this->db->from('categoria');
		$this->db->where('md5(id)=', $id);
		return $this->db->get()->result(); 
		
	}
	

	public function alterar($alterar_categoria, $destaquenosite, $id){
	
		$dados = array (
			"titulo" 				=> $alterar_categoria, 
			"categoriadest" => $destaquenosite,
		); 
		$this->db->where('id=', $id); 
		return $this->db->update('categoria', $dados); 
		

	}

	public function carrega_categorias_html(){

		$this->db->order_by('titulo','ASC'); 
		$categorias = $this->db->get('categoria')->result();  


		$html_cat = []; 
		$base_url = base_url('home/lista_produtos/'); 
		foreach ($categorias as $row){
			array_push($html_cat,'<a class="dropdown-item" href="'.$base_url.md5($row->id).'"> '.$row->titulo.' </a>');
		}

		file_put_contents("application"	. DIRECTORY_SEPARATOR . 
											"views" 			. DIRECTORY_SEPARATOR . 	
											"frontend" 		. DIRECTORY_SEPARATOR .
											"template" 		. DIRECTORY_SEPARATOR .
											"categorias-menu.php",$html_cat); 

	}
	*/ 

}