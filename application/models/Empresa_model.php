<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

	public function __construct(){

		parent::__construct(); 

	}

	public function autentica($usuario, $senha){
		$this->db->where('login=',$usuario);
		$this->db->where('senha=',md5($senha));
		return $this->db->get('empresa')->result();
	}

	
	public function retorna_inicio_geral(){
		if (!$this->session->userdata('empresa_logada')){
				redirect(base_url('admin/loginempresa'));
		}
	}




}