<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Picklist_model extends CI_Model {

	public function __construct(){

		parent::__construct(); 

	}

	public function lista_opcoes(){
		
		$this->db->order_by('desopcao','DESC');
		return $this->db->get('opcoes')->result(); 

	}

	public function lista_cores(){

		$this->db->order_by('descor','ASC');
		return $this->db->get('cores')->result();
		
	}

	public function lista_tipos_pagamentos(){

		$this->db->order_by('tipopagamento','ASC');
		return $this->db->get('pagamento')->result();
		
	}

	public function situacao_nota(){
		$this->db->order_by('tiposituacao','ASC');
		return $this->db->get('situacao_nota')->result(); 
	}

	public function lista_tipo_acesso(){
		$this->db->order_by('tipo_acesso','ASC');
		return $this->db->get('tipoacesso')->result(); 
	}

	public function getLista_tipo_retirada()
	{
		$this->db->from('tipo_retirada');
		$this->db->order_by('desretirada');
		return $this->db->get()->result(); 
	}
}