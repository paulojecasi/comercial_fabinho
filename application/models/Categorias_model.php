<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model {

	public $id;
	public $titulo; 

	public function __construct(){

		parent::__construct(); 

	}

	public function listar_categorias(){

		//consulta no banco ondenando pelo titulo (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('titulo','ASC'); 

		// vamos informar a tabela e trazer o resultado 
		return $this->db->get('categoria')->result(); 

	}

	public function adicionar($addcategoria_titulo, $destaquenosite){

		$dados = array (
			"titulo" 				=> $addcategoria_titulo, 
			"categoriadest" => $destaquenosite,
		); 

		return $this->db->insert('categoria',$dados); 
		
	}

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

}