<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto_model extends CI_Model
{

	public $id;
	public $desproduto; 

	public function __construct(){

		parent::__construct(); 

	}

	public function listar_produtos($pular=null, $produtos_por_pagina=null)
	{

		//echo "pular =".$pular;
		//echo "qt = ".$produtos_por_pagina;
		//exit;  

		if ($pular && $produtos_por_pagina)
		{
			$this->db->limit($produtos_por_pagina, $pular);
		} 
		else 
		{
			$this->db->limit(5); 
		}

			$this->db->order_by('desproduto ASC'); 
			return $this->db->get('produto')->result(); 

	}

	public function listar_produto($id)
	{

		$this->db->where('md5(idproduto)=', $id); 
		$return = $this->db->get('produto')->result(); 

		// vou precisar de algumas consultas que não aceitaram o MD5 entao... PJCS
		if ($return){
			return $return;
		}else {
			$this->db->where('idproduto=', $id); 
			return $this->db->get('produto')->result(); 
		}
	}

	public function listagem_produto_escolha(){

		if ($this->session->userdata('tipolista')=="destsim"){
			$this->db->where('produtodestaque=',1); 
		} elseif ($this->session->userdata('tipolista')=="destnao"){
			$this->db->where('produtodestaque=',2); 
		} elseif ($this->session->userdata('tipolista')=="sitesim"){
			$this->db->where('produtosite=',1); 
		} elseif ($this->session->userdata('tipolista')=="sitenao"){
			$this->db->where('produtosite=',2); 
		} elseif ($this->session->userdata('tipolista')=="ativos"){
			$this->db->where('produtoativo=',1);
		} elseif ($this->session->userdata('tipolista')=="inativos"){
			$this->db->where('produtoativo=',2);
		}

	}

	public function adicionar($idcategoria,$idmarca,$desproduto,$codbarras,$codproduto,$corproduto, $vlpreco, $vlpromocao, $vlprecoatacado, $vlpromocaoatacado, $vllargura,$vlaltura,$vlcomprimento,$vlpeso,$produtoativo,$produtodestaque,$produtosite,$qtatacado)
	{

		// vamos gerar o codigo do produto
		$codproduto = $this->codifica_produto_automatico($idcategoria); 
		
		$dados["idcategoria"]	= $idcategoria;
		$dados["desproduto"]	= $desproduto;
		$dados["codbarras"]		= $codbarras;
		$dados["codproduto"]	= $codproduto;
		$dados["corproduto"]	= $corproduto;
		$dados["vlpreco"]			= $vlpreco;
		$dados["vlprecoatacado"]			= $vlprecoatacado;
		$dados["vllargura"]		= $vllargura;
		$dados["vlaltura"]		= $vlaltura;
		$dados["vlcomprimento"]= $vlcomprimento;
		$dados["vlpeso"]			= $vlpeso;
		$dados["vlpromocao"]	= $vlpromocao;
		$dados["vlpromocaoatacado"]	= $vlpromocaoatacado;
		$dados["produtoativo"]= $produtoativo;
		$dados["produtodestaque"]= $produtodestaque;
		$dados["produtosite"]= $produtosite;
		$dados["qtatacado"]= $qtatacado;

		return $this->db->insert('produto',$dados); 

	}

	public function codifica_produto_automatico($idcategoria){

		// vamos ver se ja existe a codificação da categoria do produto = PJCS 
		$this->db->where('idcategoria=',$idcategoria);
		$codifica = $this->db->get('codificaproduto')->result();

		// se existir, vamos acrescentar + 1

		if ($codifica){

			foreach ($codifica as $value) {
				$num  = ++$value->numero; 
			}
			$codpro = $idcategoria.$num;
			$codpro = str_replace(' ', '', $codpro);
			$dados['numero'] = $num; 
			$dados['codproduto'] = $codpro ;
			if ($this->db->update('codificaproduto', $dados)){
				return $codpro;
			} 

		} else{	// se nao existir, vamos add 
		
			$num =1; 
			$codpro = $idcategoria.$num; 
			$codpro = str_replace(' ', '', $codpro);
			$dados['idcategoria']=$idcategoria; 
			$dados['numero'] = $num; 
			$dados['codproduto'] =$codpro; 
			if ($this->db->insert('codificaproduto',$dados)){
				return $codpro;  
			} 

		}

	}

	public function alterar($idproduto,$idcategoria,$idmarca,$desproduto,$codbarras,$codproduto,$corproduto, $vlpreco,$vlprecoatacado,$vllargura,$vlaltura,$vlcomprimento,$vlpeso,$vlpromocao,$vlpromocaoatacado,$produtoativo,$produtodestaque,$produtosite,$qtatacado)
	{
		$dados["idcategoria"]	= $idcategoria;
		$dados["desproduto"]	= $desproduto;
		$dados["codbarras"]		= $codbarras;
		$dados["codproduto"]	= $codproduto;
		$dados["corproduto"]	= $corproduto;
		$dados["vlpreco"]			= $vlpreco;
		$dados["vlprecoatacado"]			= $vlprecoatacado;
		$dados["vllargura"]		= $vllargura;
		$dados["vlaltura"]		= $vlaltura;
		$dados["vlcomprimento"]= $vlcomprimento;
		$dados["vlpeso"]			= $vlpeso;
		$dados["vlpromocao"]	= $vlpromocao;
		$dados["vlpromocaoatacado"]	= $vlpromocaoatacado;
		$dados["produtoativo"]= $produtoativo;
		$dados["produtodestaque"]= $produtodestaque;
		$dados["produtosite"]= $produtosite;
		$dados["qtatacado"]= $qtatacado;

		$this->db->where('idproduto=', $idproduto); 
		return $this->db->update('produto',$dados); 
	}

	public function excluir($id){

		$this->db->where('md5(idproduto)=', $id);
		return $this->db->delete('produto'); 

	}

	public function alterar_img($idproduto, $dir_imagem){
		$dados['img'] = $dir_imagem; // identifica que o usuario ja tem foto 

		$this->db->where('md5(idproduto)=', $idproduto);
		return $this->db->update('produto',$dados);
	}

	public function contar(){
		// vamos ver o tipo de listagem escolhido para contagem 
		$this->listagem_produto_escolha();
		$this->db->from('produto'); 
		return $this->db->count_all_results(); 
	}


	/* ================== FRONTEND ===============*/

	// seleciona somente produtos aptos para o site
	public function valida_produtos(){
		$this->db->where('produtoativo=',1);
		$this->db->where('desproduto!=',"");
		$this->db->where('vlpreco > ',0); 
	}

	public function lista_produtos_site($categoria=null){

		if ($categoria) {
				$this->db->where('md5(idcategoria)=',$categoria);
		}

		$this->valida_produtos(); 
		return $this->db->get('produto')->result(); 

	}

	// lista os produtos em destaques no site 
	public function produtos_destaques(){

		$this->valida_produtos(); 
		$this->db->where('produtodestaque=',1);

		return  $this->db->get('produto')->result();

	}

	// pra listar as categorias que ficarao em destaques no site
	public function produtos_da_categoria(){	
		
		$this->valida_produtos(); 
		$this->db->where('categoriadest=',1); 
		$this->db->from('produto');
		$this->db->join('categoria','categoria.id = produto.idcategoria');
		return  $this->db->get()->result();

	}


	public function buscaprodutos($nomeproduto){

		$this->db->select("*"); 
		$this->db->from('produto'); 
		if ($nomeproduto != ''){
			$this->valida_produtos();
			$this->db->like('desproduto', $nomeproduto); 
			$this->db->or_where('codproduto', $nomeproduto);
			$this->db->or_where('codbarras', $nomeproduto);

		}

		$this->db->order_by('desproduto','DESC');
		return $this->db->get(); 
	}

	function consultajquery_produto($desproduto)
	{
		if (strlen($desproduto)>0) 
		{
			// prioridade para cod barras 
			$this->db->where('codbarras=', $desproduto);
			$results = $this->db->get('produto')->result();
			
			if ($results)
			{
				return $results; 
			} 
			else
			{
				$this->db->like('desproduto', $desproduto);
				$this->db->or_where('codbarras', $desproduto);
				$this->db->or_where('codproduto', $desproduto);
				$this->db->order_by('desproduto','DESC');
				return $this->db->get('produto')->result(); 
			}

		} 
		else 
		{
			$this->db->where('desproduto=', 'NULL'); 
			return $this->db->get('produto')->result(); 
		}

	}

	function getConsultajquery_produto_admin($idproduto)
	{
		if (strlen($idproduto)>0) 
		{
			$this->db->where('idproduto=',$idproduto);
			return $this->db->get('produto')->result(); 
		} else {
			$this->db->where('desproduto=', 'NULL'); 
			return $this->db->get('produto')->result(); 
		}

	}

	function getConsultajquery_produtos_admin($desproduto, $tiporel)
	{

		if ($tiporel == "destsim")
		{
			$this->db->where("produtodestaque=",1); 
		}
		elseif ($tiporel == "destnao") 
		{
			$this->db->where("produtodestaque=",2);
		}

		elseif ($tiporel == "sitesim")
		{
			$this->db->where("produtosite=",1); 
		}
		elseif ($tiporel == "sitenao") 
		{
			$this->db->where("produtosite=",2);
		}

		elseif ($tiporel == "ativos")
		{
			$this->db->where("produtoativo=",1); 
		}
		elseif ($tiporel == "inativos") 
		{
			$this->db->where("produtoativo=",2);
		}

		if ($desproduto) 
		{
			$this->db->like('desproduto', $desproduto); 
			$this->db->or_like('codbarras', $desproduto);
			$this->db->or_where('codproduto=', $desproduto);
			$this->db->order_by('desproduto','DESC');
			return $this->db->get('produto')->result(); 
		} else { 
			$this->db->where('idproduto > 0'); 
			$this->db->order_by('desproduto ASC');
			return $this->db->get('produto')->result(); 
		}
	}

	public function consulta_produto_temp_aberto($idcaixa, $idproduto)
	{
		$this->db->where('md5(idcaixa)=', $idcaixa);
		$this->db->where('md5(idproduto)=', $idproduto);
		$this->db->where('situacao=',0);
		return $this->db->get('produto_caixa_temp')->result(); 
	}
}