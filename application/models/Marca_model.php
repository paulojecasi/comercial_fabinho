<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca_model extends CI_Model {

	public $id;
	public $titulo; 

	public function __construct(){

		parent::__construct(); 

	}

	public function listar_marcas(){

		//consulta no banco ondenando pelo titulo (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('desmarca','ASC'); 

		// vamos informar a tabela e trazer o resultado 
		return $this->db->get('marca')->result(); 

	}

	public function adicionar($desmarca){

		$dados = array (
			"desmarca" 			=> $desmarca 
		); 

		return $this->db->insert('marca',$dados); 
		
	}

	public function excluir($id){

		$this->db->where('md5(idmarca)=', $id);
		return $this->db->delete('marca');  

	}

	public function listar_marca($id){

		$this->db->from('marca');
		$this->db->where('md5(idmarca)=', $id);
		return $this->db->get()->result(); 
		
	}

	public function alterar($desmarca, $id){
	
		$dados = array (
			"desmarca" 			=> $desmarca, 
		
		); 
		$this->db->where('idmarca=', $id); 
		return $this->db->update('marca', $dados); 
		

	}


/*
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