<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model
{


	public function __construct(){

		parent::__construct(); 

	}

	function getConsultaClientes()
	{
		$this->db->from('cliente');
		return $this->db->get()->result(); 
	}


	function consultajquery_cliente($nomecliente)
	{

		if (strlen($nomecliente)>0) 
		{
			$this->db->like('nome', $nomecliente); 
			$this->db->or_like('apelido', $nomecliente);
			$this->db->or_where('idcliente', $nomecliente);
			$this->db->or_where('cpf', $nomecliente);
			$this->db->order_by('nome','DESC');
			return $this->db->get('cliente'); 
		} 
		else 
		{
			$this->db->where('nome=', 'NULL'); 
			return $this->db->get('cliente'); 
		}

	}

	public function consulta_cliente($idcliente)
	{
		$this->db->where('md5(idcliente)=', $idcliente); 
		return $this->db->get('cliente')->result(); 
	}

	public function adiciona_cliente($nome,$apelido,$cpf,$endereco,$pontoreferencia)
	{
		$dados['nome'] 			= $nome;
		$dados['apelido'] 	= $apelido;
		$dados['cpf'] 			= $cpf;
		$dados['endereco'] 	= $endereco;
		$dados['pontoreferencia']=$pontoreferencia;

		return $this->db->insert('cliente', $dados); 
	}

	public function confirma_alteracao($idcliente, $nome,$apelido,$cpf,$endereco,$pontoreferencia)
	{
		$dados['nome'] 			= $nome;
		$dados['apelido'] 	= $apelido;
		$dados['cpf'] 			= $cpf;
		$dados['endereco'] 	= $endereco;
		$dados['pontoreferencia']=$pontoreferencia;

		$this->db->where('md5(idcliente)=',$idcliente); 
		return $this->db->update('cliente', $dados); 
	}

	public function lista_clientes_divida_aberto()
	{
		$this->db->where("vl_saldo_devedor > 0");
		$this->db->from("venda_saldo_crediario");
		$this->db->join("cliente","cliente.idcliente = venda_saldo_crediario.idcliente");
		$this->db->order_by("cliente.nome"); 
		return $this->db->get()->result(); 
	}

	public function lista_cliente_divida_aberto($idcliente)
	{
		$this->db->where("md5(venda_saldo_crediario.idcliente)", $idcliente);
		$this->db->from("venda_saldo_crediario");
		$this->db->join("cliente","cliente.idcliente = venda_saldo_crediario.idcliente");
		return $this->db->get()->result(); 
	}

	public function getCliente_faixa_atraso_rel($datainicio, $datafinal)
	{

		$this->db->where('venda_saldo_crediario.vl_saldo_devedor > 0');
		$this->db->where('DATE(venda.datavenda) >=', date('Y-m-d',strtotime($datainicio)));
		$this->db->where('DATE(venda.datavenda) <=', date('Y-m-d',strtotime($datafinal)));
		$this->db->where('venda.vlsaldo_crediario > 0');
		
		$this->db->from("cliente");

		$this->db->join("venda_saldo_crediario","venda_saldo_crediario.idcliente = cliente.idcliente");
		$this->db->join("venda","venda.idcliente = cliente.idcliente");

		$this->db->order_by("venda.datavenda"); 
		$this->db->order_by("venda.idcliente"); 
		return $this->db->get()->result(); 

	}




}