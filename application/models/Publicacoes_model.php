<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicacoes_model extends CI_Model {

	public $id;
	public $categoria; 
	public $titulo;
	public $subtitulo;
	public $conteudo;
	public $data; 
	public $img;
	public $user; 


	public function __construct(){

		parent::__construct(); 

	}

	public function destaques_home(){

		/* ------ QUANDO FOR UMA TABELA - SEM RELACIONAMENTO 
		// aqui vamos informar quantas informações(linhas) da tabela será listados
		$this->db->limit(4); 

		//consulta no banco ondenando pelo data (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('data','DESC');  

		// vamos informar a tabela "get('postagens') e trazer o resultado 
		return $this->db->get('postagens')->result();
		*/


		// ----- QUANDO FOR MAIS DE UMA TABELA - COM RELACIONAMENTO  (JOIN)

		// vamos dar um "select" em algumas colunas da tabelas "usuario" e "postagens"
		$this->db->select('usuario.id as idautor,	usuario.nome, postagens.id as idpostagem, 
			postagens.titulo, postagens.subtitulo,postagens.user, postagens.data,
			postagens.img');
		/* aqui vamos dizer que os dados serão puxados da tabela "postagem", relacionando 
				com a tabela "usuario" (JOIN) */ 
		$this->db->from('postagens'); 
		$this->db->join('usuario', 'usuario.id = postagens.user'); 
		// aqui vamos informar quantas informações(linhas) da tabela será listados
		$this->db->limit(5);
		//consulta no banco ondenando pelo data (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('postagens.data','DESC');
		/* a tabela foi informada no "$this->db->from('postagens')" entao nao precisará ser
				informada novamente abaixo no "get" */
		return $this->db->get()->result();

	}

	public function categoria_pub($id){
		// vamos dar um "select" em algumas colunas da tabelas "usuario" e "postagens"
		$this->db->select('usuario.id as idautor,	usuario.nome, postagens.id as idpostagem, 
			postagens.titulo, postagens.subtitulo,postagens.user, postagens.data,
			postagens.img, postagens.categoria');
		/* aqui vamos dizer que os dados serão puxados da tabela "postagem", relacionando 
				com a tabela "usuario" (JOIN) */ 
		$this->db->from('postagens'); 
		$this->db->join('usuario', 'usuario.id = postagens.user'); 
		$this->db->where('postagens.categoria ='.$id); 

		//consulta no banco ondenando pelo data (ASC= Crescente, DESC= Decrescente)
		$this->db->order_by('postagens.data','DESC');
		/* a tabela foi informada no "$this->db->from('postagens')" entao nao precisará ser
				informada novamente abaixo no "get" */
		return $this->db->get()->result();

	}

}