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

}