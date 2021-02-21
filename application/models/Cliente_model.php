<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model
{


	public function __construct(){

		parent::__construct(); 

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
		$this->db->where('idcliente=', $idcliente); 
		return $this->db->get('cliente')->result(); 
	}


}