<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		if (!$this->session->userdata('logado')){
			$this->session->set_userdata('tipo_acesso',"venda");
			redirect(base_url('admin/login')); 
		}

		$this->load->model('produto_model','modelprodutos'); 
		$this->load->model('picklist_model','model_tipo_pagamento');
		$this->load->model('venda_model','modelvendas');
		
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 

	}

	public function index()
	{

		$idcaixa=1; 
		//$produtos_temp = $this->modelvendas->listar_produtos_temp($idcaixa);
		$dados = $this->totalizador_venda_caixa($idcaixa);

		if ($dados['produtos_temp']){
			$this->load->library('table'); 
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

	
		if ($idproduto == "----%20Nenhum%20item%20informado%20----"){
			$this->index(); 
		}

		$this->load->library('table'); 

		$produto_temp = $this->modelprodutos->listar_produto($idproduto); 

		if ($this->session->userdata('solicitante') == "venda"){
				// --- aqui, vamos adicionar temporariamente o item da vendas
				$this->inserir_temporario($produto_temp);
				$this->session->unset_userdata('solicitante'); 
		}  
	
		$idcaixa=1; 
		//$dados['produtos_temp'] = $this->modelvendas->listar_produtos_temp($idcaixa);
		$dados = $this->totalizador_venda_caixa($idcaixa);

		$dados['tipo_pagamento'] = $this->tipo_pagamento;
		$dados['produtos']=$this->produtos;
		$dados['produtoitem'] = $produto_temp; 
		$dados['quantidade_item'] = $this->session->userdata('quantidade');
	
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

		if ($this->modelvendas->adicionar_temp($idcaixa,$idproduto,$codproduto,$desproduto,$vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal)){
			
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
		$this->load->view('frontend/venda_produto_temp_altera');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');  

	}


	public function salvar_alteracoes_produto_temp()
	{
		$quantidadeitens= $this->input->post('quantidadeitens_alt');
		$valordesconto  = $this->input->post('valordesconto_alt');
		$valoracrescimo = $this->input->post('valoracrescimo_alt');
		$valortotal 		= $this->input->post('valortotal_alt');
		$id 						= $this->input->post('id_produto_temp'); 

		if ($this->modelvendas->alterar_produto_temp_tem($quantidadeitens,$valordesconto,$valoracrescimo,$valortotal,$id))
		{
			$mensagem ="Alterações aplicadas no Item com Sucesso  !"; 

			$this->session->set_userdata('mensagem',$mensagem); 
			
		} else {

			$mensagem = "Houve erro ao aplicar as alterações no Item!"; 

			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

		redirect(base_url('venda'));

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
			 			<option value="'.$id.'" selected>'.$codigo. 
			 								$row->desproduto.  
			 								$row->codbarras. 
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


	private function totalizador_venda_caixa($idcaixa){
		$venda = $this->modelvendas->listar_produtos_temp($idcaixa);
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

		$dados['valortotal_sem_conversao'] 	= $valor_total;
    $dados['valortotal'] 	=  $valor_total; 
    $dados['vl_tot_desc'] =  $vl_tot_desc;
    $dados['vl_tot_acre'] =  $vl_tot_acre;
    $dados['numero_itens'] = $numero_itens;
    $dados['idcaixa']		= $idcaixa; 
    $dados['produtos_temp'] = $venda; 

    return $dados; 

	}

	public function venda_pagamento($idcaixa, $tipo_pagamento=null){


    $dados = $this->totalizador_venda_caixa($idcaixa); 

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		if ($tipo_pagamento == 1){
			$this->load->view('frontend/venda_pagamento_money');
		}elseif ($tipo_pagamento == 4){
			$this->load->view('frontend/venda_pagamento_crediario');
		} else {

			$this->load->view('frontend/venda_pagamento');
		}
		
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}


	public function finalizar_venda($tipo_pagamento,$idcaixa){
 
		$idusuario 	= $this->session->userdata('userLogado')->id;
		
		$venda 			= $this->totalizador_venda_caixa($idcaixa); 

		$idcliente	= $this->input->post('idcliente_crediario');


		if ($tipo_pagamento==4 && !$idcliente){

			$mensagem = "Para concluir a venda CREDIÁRIO, é preciso informar o Cliente ! "; 
			$this->session->set_userdata('mensagemErro',$mensagem);

			redirect(base_url('venda/venda_pagamento/').$idcaixa.'/4'); 
	
		}
	

		$valor_total = $venda['valortotal']; 
		$vl_tot_acre = $venda['vl_tot_acre'];
		$vl_tot_desc = $venda['vl_tot_desc'];
		$numero_itens= $venda['numero_itens'];

    // vamos gravar a venda (tabela VENDA)

    $idcaixa 				= $idcaixa; 
    $codigousuario 	= $idusuario;
    $situacaovenda 	= 1;  // 1 fechada, 2 cancelada (tabela SITUACAO_VENDA)
    $tipovenda			=	1;  // 1 Padrao, 2 Fiado (tabela TIPO_VENDA)
    $valorvenda			=	$valor_total;
    $valoracrescimo = $vl_tot_acre;
    $valordesconto 	= $vl_tot_desc;
    $tipopagamento  = $tipo_pagamento; // tabela TIPO_PAGAMENTO

    if ($this->modelvendas->gravar_venda($idcaixa, $codigousuario, $situacaovenda, $tipovenda, $valorvenda, $valoracrescimo, $valordesconto, $idcliente, $tipopagamento )){
			
		} else {

			$mensagem = "Houve um erro ao Gravar a Venda (Tabela VENDA)"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 
			$this->index();  

		}

		$this->finalizar_produto_caixa_temp($idcaixa); 

		if ($tipo_pagamento==4){
			$this->atualiza_saldo_crediario($idcliente, $valorvenda); 
		}

		$mensagem = "Venda Realizada com Sucesso !"; 
		$this->session->set_userdata('mensagem',$mensagem); 
		redirect(base_url('venda'));

	} 

	private function finalizar_produto_caixa_temp($idcaixa)
	{
		$this->modelvendas->finalizar_produto_caixa_temp($idcaixa); 

	}

	private function atualiza_saldo_crediario($idcliente, $valorvenda)
	{
		$this->modelvendas->atualiza_saldo_crediario($idcliente, $valorvenda);

	}

	


}
