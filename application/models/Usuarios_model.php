<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public $id;
	public $nome;
	public $email;
	public $img;
	public $historico;
	public $user;
	public $senha;

	public function __construct(){

		parent::__construct(); 

	}

	public function listar_autor($id){
		// selecionar campos/colunas
		$this->db->select('id, nome, historico, img');
		// informar tabela
		$this->db->from('usuario');
		$this->db->where('id ='.$id); 
		return $this->db->get()->result(); 

	}

	public function listar_usuarios(){

		//consulta no banco ondenando pelo titulo (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('nome','ASC'); 

		// vamos informar a tabela e trazer o resultado 
		return $this->db->get('usuario')->result(); 

	}

	public function adicionar($nome,$email,$historico,$user,$senha){

		$dados["nome"]= $nome; 
		$dados["email"]= $email;
		$dados["historico"]= $historico;
		$dados["user"]= $user;
		$dados["senha"]= md5($senha);
		return $this->db->insert('usuario',$dados); 

	}

	public function excluir($id){

		$this->db->where('md5(id)=', $id);
		return $this->db->delete('usuario');	

	}

	public function lista_usuario($id){
		$this->db->where('md5(id)=', $id);
		return $this->db->get('usuario')->result(); 
	}

	public function alterar($nome,$email,$historico,$user,$senha,$id){
		$dados['nome']  = $nome;
		$dados['email'] = $email;
		$dados['historico'] = $historico;
		$dados['user'] = $user;
		$dados['senha'] = md5($senha);

		$this->db->where('id=', $id);
		return $this->db->update('usuario',$dados);
	}

	public function alterar_img($id, $dir_imagem){
		$dados['img'] = $dir_imagem; // identifica que o usuario ja tem foto 

		$this->db->where('md5(id)=', $id);
		return $this->db->update('usuario',$dados);
	}



}