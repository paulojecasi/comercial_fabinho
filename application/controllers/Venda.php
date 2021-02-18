<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		// como vai aparecer em todas a paginas, chamamos o model aqui no construtor - PJCS 
		// vamos chamar o model "Categorias_model" para listagem dos models cadastrados
				// como fosse:
				// modelcategorias = new Categorias_model(); 
		//$this->load->model('categorias_model','modelcategorias');

		$this->load->model('produto_model','modelprodutos'); 
		$this->load->model('picklist_model','model_tipo_pagamento');
		$this->load->model('venda_model','modelvendas');
		
				// vamos cria uma var "$categorias" e carrega-la com o resultado 
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 

	}

	public function index()
	{

		$idcaixa=1; 
		$produtos_temp = $this->modelvendas->listar_produtos_temp($idcaixa);
		if ($produtos_temp){
			$this->load->library('table'); 
			$dados['produtos_temp'] = $produtos_temp;
		} else {
			$dados['produtos_temp'] = null; 
		}
		$dados['tipo_pagamento'] = $this->tipo_pagamento; 
		$dados['produtoitem'] = null; 
		$dados['produtos']=$this->produtos;

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/venda');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer'); 

	}

	public function listar_produto($idproduto){

		$this->load->library('table'); 

		$dados['tipo_pagamento'] = $this->tipo_pagamento;
		$dados['produtos']=$this->produtos;
		$produto_temp =  
					$dados['produtoitem'] = $this->modelprodutos->listar_produto($idproduto); 
		$dados['quantidade_item'] = $this->session->userdata('quantidade');

		if ($this->session->userdata('solicitante') == "venda"){
				// --- aqui, vamos adicionar temporariamente o item da vendas
				$this->inserir_temporario($produto_temp);
				$this->session->unset_userdata('solicitante'); 
		}  
	
		
		$idcaixa=1; 
		$dados['produtos_temp'] = $this->modelvendas->listar_produtos_temp($idcaixa);
	
		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		$this->load->view('frontend/venda');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');  

	}


	public function inserir_temporario($produto_temp) 
	{
		foreach ($produto_temp as $produto_t) {

			$idcaixa= 1;   
			$idproduto= $produto_t->idproduto;
			$codproduto= $produto_t->codproduto; 
			$desproduto= $produto_t->desproduto;
			$vlpreco= $produto_t->vlpreco;
			$vlprecoatacado= $produto_t->vlprecoatacado;
			$qtatacado=  $produto_t->qtatacado;
			$vlpromocao= $produto_t->vlpromocao;
			$vlpromocaoatacado= $produto_t->vlprecoatacado;
			$quantidadeitens = $this->session->userdata('quantidade'); 
			$valordesconto = 0; 
			$valoracrescimo =0; 
			$valortotal = $vlpreco * $quantidadeitens;
			
		} 

		if ($this->modelvendas->adicionar_temp($idcaixa,	$idproduto,$codproduto,$desproduto,$vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal)){
			
		} else {

			$mensagem = "Houve um erro ao adicionar Produto !"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

	}

	 public function excluir_produto_temp($id){
	 		
	 		if ($this->modelvendas->excluir_produto_temp($id)){
	 				$mensagem = "Item Excluido Com Sucesso !"; 
					$this->session->set_userdata('mensagem',$mensagem);
	 		} else {
	 				$mensagem = "Erro ao Excluir o Item "; 
					$this->session->set_userdata('mensagemErro',$mensagem);
	 		} 

	 		$this->index(); 
	 }

	 public function produto_temp_altera($id){

		$dados['produto_temp_altera'] = $this->modelvendas->listar_produto_temp($id);
	
		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		$this->load->view('backend/mensagem');
		$this->load->view('frontend/produto_temp_altera');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');  

	}


	 function consultajquery()
		{
	 	$output = '';
	 	$desproduto = ''; 

 		if ($this->input->post('nomeproduto'))
 		{
	 		$desproduto = $this->input->post('nomeproduto'); 
	 	}

	 	$dados = $this->modelprodutos->consultajquery($desproduto);

 		$output .= '
 		<div class= "form-group picklist-prod">

 			<div class picklist-tit> 
	 			<label class= "codigo">
	 					Codigo  
	 			</label>
	 			<label class= "descricao">
	 					Codido de Barras 
	 			</label>
	 			<label class="barras">
	 					 Descricao 
	 			</label>
	 		</div> 
      <select multiple class="form-control" id="idproduto_res" name="idproduto_res">
	 		';
	 		if ($dados->num_rows() > 0){
	 			foreach ($dados->result() as $row) {
	 				$codigo = str_pad($row->codproduto,30);
	 				$id = $row->idproduto; 

	 				$output .= '
			 			<option value="'.$id.'">'.$codigo. 
			 								$row->desproduto.  
			 								$row->codbarras."---". 
			 								$id. 
			 			'</option>'; 
	 			}

	 		}
	 		else {
	 			$output .= '
	 			<option>---- Nenhum item informado ---- </option>';
	 		}

	 		$output .= '
 			</select>
 		</div>'; 

 		echo $output;
 		exit; 

	}

	public function venda_pagamento($id_caixa, $tipo_pagamento=null){

		

		$venda = $this->modelvendas->venda_pagamento($id_caixa); 
		$valor_total =0; 
		$vl_tot_acre =0;
		$vl_tot_desc =0; 
		$numero_itens=0;

		foreach ($venda as $totaliza):
        $vl_tot_desc +=$totaliza->valordesconto;
        
        $vl_tot_acre +=$totaliza->valoracrescimo;
        
        $valor_total += $totaliza->valortotal; 

        $numero_itens += $totaliza->quantidadeitens;
    endforeach; 

    $valor_total = ($valor_total + $vl_tot_acre - $vl_tot_desc);
    $dados['valortotal'] 	= reais($valor_total); 
    $dados['valortotal_sem_conversao'] 	= $valor_total;
    $dados['vl_tot_desc'] = reais($vl_tot_desc);
    $dados['vl_tot_acre'] = reais($vl_tot_acre);
    $dados['id_caixa']		= $id_caixa; 



		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		$this->load->view('backend/mensagem');
		if ($tipo_pagamento == "money"){
			$this->load->view('frontend/venda_pagamento_money');
		} else {

			$this->load->view('frontend/venda_pagamento');
		}
		
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}


}
