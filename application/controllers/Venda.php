<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda extends CI_Controller {

	public function __construct()
	{
 
		parent::__construct();  
	
		//$this->session->set_userdata('tipo_acesso',"venda");
		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();
		
		$this->load->model('usuarios_model','modelusuarios');
		$this->modelusuarios->retorna_inicio();

		$this->load->model('produto_model','modelprodutos'); 
		$this->load->model('picklist_model','model_tipo_pagamento');
		$this->load->model('venda_model','modelvendas');
		$this->load->model('estoque_model','modelestoque');
		$this->load->model('caixa_model','modelcaixa_movimento'); 
		
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 

		$this->idcaixa= $this->session->userdata('idcaixa'); 
	}
 
	public function index()
	{

		$this->modelcaixa_movimento->encerra_sessoes_caixa(); 

		$this->usuario_autorizado(); 

		$idcaixa= $this->session->userdata('idcaixa'); 

		$this->caixa_aberto_fechado($idcaixa); 
		
		$dados = $this->totalizador_venda_caixa($idcaixa);

		/*if ($dados['produtos_temp']){
			$this->load->library('table'); 
		} else {
			$dados['produtos_temp'] = null; 
		}
		*/
		$dados['tipo_pagamento'] = $this->tipo_pagamento; 
		//$dados['produtoitem'] = null; 
		//$dados['produtos']=$this->produtos;


		$operacao_caixa = $this->session->userdata('operacao');

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		if ($operacao_caixa == "CAIXA_ABERTO")
		{
			$this->load->view('frontend/venda');	
		}
		else
		{
			$this->load->view('frontend/cliente');
		}
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer'); 

	}

	public function usuario_autorizado()
	{
		// vamos se o usuario está autorizado a operar o caixa
		$idcaixa_aberto = $this->session->userdata('userLogado')->idcaixa_autorizado;
		if ($this->modelcaixa_movimento->getOperacaoCaixa($idcaixa_aberto,))
		{
			// abrir sessao para o caixa aberto
			$this->session->set_userdata("idcaixa",$idcaixa_aberto); 
			//$idcaixa = $this->session->userdata('idcaixa');
		}
		else
		{
			$mensagem = "Usuário não tem permissao para operar este Caixa!"; 
			$this->session->set_userdata('mensagemErro',$mensagem);
			$this->modelcaixa_movimento->encerra_sessoes_caixa(); 
			$this->session->set_userdata('tipo_acesso',"venda");
			redirect(base_url('admin/login')); 
		}
	}

	public function caixa_aberto_fechado($idcaixa)
	{
		$operacao = $this->modelcaixa_movimento->getOperacaoCaixa($idcaixa); 
		foreach ($operacao as $opcaixa) 
		{
			$tipo_ope = $opcaixa->situacaocaixa; 
		}

		if ($tipo_ope==0)
		{
			$this->session->unset_userdata('operacao');
		}
		else
		{
			$this->session->set_userdata('operacao','CAIXA_ABERTO');
		}
	}

	public function consulta_venda($idvenda, $tipo_acesso=null)
	{
		$this->load->library('table');
		//$idcaixa= $this->session->userdata('idcaixa'); 
		$dados['idcaixa']= $this->idcaixa; 
		$dados['tipo_acesso']= $tipo_acesso; 
		$dados['consulta_venda'] = $this->modelvendas->consulta_venda($idvenda);
		$dados['consulta_venda_itens'] = $this->modelvendas->consultajquery_itens_venda($idvenda);
		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		$this->load->view('frontend/venda_consulta');
		$this->load->view('frontend/template/footer'); 
		$this->load->view('frontend/template/html-footer');
		$this->load->view('frontend/template/mensagem-alert');
	}

	public function listar_produto($idproduto){

		if ($idproduto == "----%20Nenhum%20item%20informado%20----")
		{
			redirect(base_url('venda'));
		}

		$this->load->library('table'); 

		$produto_temp = $this->modelprodutos->listar_produto($idproduto); 
			
		// vamos verificar se o produto tem SALDO
		$saldo_atual = $this->modelestoque->consulta_estoque_saldo($idproduto); 

		if ($saldo_atual < 0.01)
		{
				// vamos pegar o nome do produto para mostrar na tela
				foreach ($produto_temp as $prod_saldo) {
					$prod_nome = $prod_saldo->desproduto;
					$prod_codigo = $prod_saldo->codproduto;  
				}

				$mensagem = 'Produto << '.$prod_codigo.' - '.$prod_nome.' >> não tem SALDO. Verifique o Estoque!'; 
				$this->session->set_userdata('mensagemErro',$mensagem);
				redirect(base_url('venda'));
		}

		if ($this->session->userdata('solicitante') == "venda"){
				// --- aqui, vamos adicionar temporariamente o item da vendas
				$this->inserir_temporario($produto_temp);
				$this->session->unset_userdata('solicitante'); 
		}  
	
		$idcaixa= $this->session->userdata('idcaixa'); 
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

			//$idcaixa= $this->session->userdata('idcaixa');  
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
			// calculando se vai ser valor normal ou atacado
			$vlpreco= $qtatacado>$quantidadeitens ? $vlpreco : $vlprecoatacado; 
			$valortotal = $vlpreco*$quantidadeitens;
			
			//echo $quantidadeitens."========.." .$qtatacado."===".$vlprecoatacado."----- ====>> ".$vlpreco;
			//exit; 
		} 

		if ($this->modelvendas->adicionar_temp($this->idcaixa,$idproduto,$codproduto,$desproduto,$vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal)){
			
		} else {

			$mensagem = "Houve um erro ao adicionar Produto !"; 
			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

	}

	public function excluir_produto_temp($id){
	 		
	 	$this->db->trans_begin();
	 	$this->modelvendas->excluir_produto_temp($id);

	 	if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Erro ao Excluir o Item "; 
				$this->session->set_userdata('mensagemErro',$mensagem);
		
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Item Excluido Com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem);
		} 

	 		redirect(base_url('venda')); 
	}

	public function produto_temp_altera($id){

		$idcaixa= $this->session->userdata('idcaixa'); 
		$idproduto_t = 0; 
		$qtd_itens_ja_add_venda =0; 

		$produto_temp_a = $this->modelvendas->listar_produto_temp($id);

		foreach ($produto_temp_a as $prod_tm) {
			$idproduto_t = $prod_tm->idproduto; 
		}

 		$quantidade_item_venda = $this->modelprodutos->consulta_produto_temp_aberto(md5($idcaixa), md5($idproduto_t));
		if ($quantidade_item_venda)
		{
			foreach ($quantidade_item_venda as $qtdaddcxv) 
			{
				$qtd_itens_ja_add_venda += $qtdaddcxv->quantidadeitens;
			}
		}

		$dados['produto_temp_altera'] = $produto_temp_a;
		$dados['saldo_atual_prod'] 		= $this->modelestoque->consulta_estoque_saldo(md5($idproduto_t)); 
		$dados['quantidade_da_venda'] = $qtd_itens_ja_add_venda;

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		$this->load->view('frontend/venda_produto_temp_altera');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');  
		$this->load->view('backend/mensagem');

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

			$this->session->set_userdata('mensagemAlert',$mensagem); 
			
		} else {

			$mensagem = "Houve erro ao aplicar as alterações no Item!"; 

			$this->session->set_userdata('mensagemErro',$mensagem); 

		}

		redirect(base_url('venda'));

	}

	private function totalizador_venda_caixa($idcaixa){
		$venda = $this->modelvendas->listar_produtos_temp($idcaixa);
		$valor_total =0; 
		$vl_tot_acre =0;
		$vl_tot_desc =0; 
		$numero_itens=0;

		$valor_total_ult =0; 
		$vl_tot_acre_ult =0;
		$vl_tot_desc_ult =0; 
		$numero_itens_ult=0;
		$vl_unitario_ult =0; 
		$descricao_ult = "";  
		$atual_item =0;
		//echo $ultimo_item; 

		foreach ($venda as $totaliza):
        $vl_tot_desc +=$totaliza->valordesconto;
        $vl_tot_acre +=$totaliza->valoracrescimo;        
        $valor_total += $totaliza->valortotal; 
        $numero_itens += $totaliza->quantidadeitens;
        
        // vamos selecionar o ultimo item adicionado 
        if ($atual_item == 0){
	        $vl_tot_desc_ult =$totaliza->valordesconto;   
	        $vl_tot_acre_ult =$totaliza->valoracrescimo;        
	        $valor_total_ult = $totaliza->valortotal; 
	        $numero_itens_ult= $totaliza->quantidadeitens;
	        $vl_unitario_ult 	 = ($totaliza->qtatacado > $totaliza->quantidadeitens)
	        					?  	$totaliza->vlpreco
	        					: 	$totaliza->vlprecoatacado;  
	        $descricao_ult = $totaliza->desproduto; 
	        $atual_item++; 
	      }


    endforeach;

		$dados['valortotal_sem_conversao'] 	= $valor_total;
    $dados['valortotal'] 	=  $valor_total; 
    $dados['vl_tot_desc'] =  $vl_tot_desc;
    $dados['vl_tot_acre'] =  $vl_tot_acre;
    $dados['numero_itens'] = $numero_itens;
    $dados['idcaixa']		= $idcaixa; 
    $dados['produtos_temp'] = $venda; 

    $dados['valortotal_sem_conversao_ult'] 	= $valor_total_ult;
    $dados['valortotal_ult'] 	=  $valor_total_ult; 
    $dados['vl_tot_desc_ult'] =  $vl_tot_desc_ult;
    $dados['vl_tot_acre_ult'] =  $vl_tot_acre_ult;
    $dados['numero_itens_ult'] = $numero_itens_ult;
		$dados['vl_unitario_ult'] 	= $vl_unitario_ult;
		$dados['descricao_ult'] 	= $descricao_ult;


    return $dados; 

	}

	public function venda_pagamento($idcaixa, $tipo_pagamento=null){

    $dados = $this->totalizador_venda_caixa($idcaixa); 

		$this->load->view('frontend/template/html-header', $dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('backend/mensagem');
		if ($tipo_pagamento == 1)
		{
			$this->load->view('frontend/venda_pagamento_money');
		}
		elseif ($tipo_pagamento == 2){
			$this->load->view('frontend/venda_pagamento_debito');
		}
		elseif ($tipo_pagamento == 3){
			$this->load->view('frontend/venda_pagamento_credito');
		}
		elseif ($tipo_pagamento == 4){
			$this->load->view('frontend/venda_pagamento_crediario');
		} 
		elseif ($tipo_pagamento == 8){
			$this->load->view('frontend/venda_pagamento_externa');
		}elseif ($tipo_pagamento == 11){
			$this->load->view('frontend/venda_pagamento_pix');
		}
		else 
		{
			$this->load->view('frontend/venda_pagamento');
		}
		
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	public function finalizar_venda($tipo_pagamento,$idcaixa){

		$nrnota =0 ; 
		$idestoque_entrada =0; 
		$idcliente	= $this->input->post('idcliente_crediario');
		$valor_recebido = $this->input->post('vl_recebido_caixa');
		$valor_troco		= $this->input->post('vl_troco');
		$idusuario 	= $this->session->userdata('userLogado')->id;
		$venda 			= $this->totalizador_venda_caixa($idcaixa); 


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
    if ($tipo_pagamento==4)
    {
    	$tipovenda					=	2;  // 1 Padrao, 2 Fiado (tabela TIPO_VENDA)
    	$vlsaldo_crediario 	= $valor_total; 
    	$situacaovenda 	= 0;  //0 Aberto, 1 Quitada, 2 cancelada (tabela SITUACAO_VENDA)
    }else
    {
    	$vlsaldo_crediario 	= 0;
    	$tipovenda					=	1;   
    	$situacaovenda 	= 1;  //0 Aberto, 1 Quitada, 2 cancelada (tabela SITUACAO_VENDA)
    }
		
    $idcaixa 				= $idcaixa; 
    $codigousuario 	= $idusuario;
    $valorvenda			=	$valor_total;
    $valoracrescimo = $vl_tot_acre;
    $valordesconto 	= $vl_tot_desc;
    $tipopagamento  = $tipo_pagamento; // tabela TIPO_PAGAMENTO

    // vamos iniciar a transação 
    $this->db->trans_begin();

	    if ($this->modelvendas->gravar_venda($idcaixa, $codigousuario, $situacaovenda, $tipovenda, $valorvenda, $valoracrescimo, $valordesconto, $idcliente, $tipopagamento,$vlsaldo_crediario))
	    {

	    	$idvenda = $this->db->insert_id();
				
			} else {

				$mensagem = "Houve um erro ao Gravar a Venda (gravar_venda)"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				$this->db->trans_rollback(); 
				redirect(base_url('venda')); 

			} 

			// vamos gravar os itens da venda (tabela VENDAITEM)

			$itensvenda = $this->modelvendas->gravar_venda_item($idcaixa, $idvenda);

			if (!$itensvenda) 
			{
				$mensagem = "Houve um erro ao Gravar a Venda (gravar_venda_item)"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				$this->db->trans_rollback(); 
				redirect(base_url('venda'));
			}


			// vamos dar baixa no estoque 

			$tipomovimento =3; //saida do estoque por venda

			foreach ($itensvenda as $item_venda) 
			{

				$idproduto 	= $item_venda->idproduto;
				$quantidade = $item_venda->quantidadeitens;
				$nrnota			= $item_venda->idvenda; 

				$baixa_estoque = $this->modelestoque->movimento_estoque($nrnota,$idproduto,$idestoque_entrada,$tipomovimento, $quantidade, $idvenda); 

				if (!$baixa_estoque =="ok")
				{
					$mensagem = "Houve um erro na baixa de Estoque (movimento_estoque)"; 
					$this->session->set_userdata('mensagemErro',$mensagem); 
					$this->db->trans_rollback(); 
					redirect(base_url('venda'));

				}

			}

			$this->finalizar_produto_caixa_temp($idcaixa); 
 
			// vamos gravar o movimento no caixa
			$tipomovimento_caixa = $tipopagamento ; 
	 
			if (!$this->modelcaixa_movimento->grava_caixa_mov($idcaixa,$idvenda,$idcliente,$idusuario,$tipomovimento_caixa,$valorvenda,$valoracrescimo,$valordesconto,5,$valor_recebido,$valor_troco))
			{
				$this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO ao gravar caixa_movimento (grava_caixa_mov) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('venda'));
			} 
			//--------------------------------------

			if ($tipo_pagamento==4){
				$idcliente_md = md5($idcliente); 
				$this->atualiza_saldo_crediario($idcliente, $idcliente_md, $valorvenda); 
			}

			
		if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (venda/finalizar_venda) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('venda'));
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Venda Realizada com Sucesso !"; 
			$this->session->set_userdata('mensagem',$mensagem); 
			redirect(base_url('venda'));
	
		}
	} 

	private function finalizar_produto_caixa_temp($idcaixa)
	{
		$this->modelvendas->finalizar_produto_caixa_temp($idcaixa); 

	}

	private function atualiza_saldo_crediario($idcliente, $idcliente_md, $valorvenda)
	{

		$this->modelvendas->atualiza_saldo_crediario($idcliente, $idcliente_md, $valorvenda);

	}


	public function inserir_temporarioj($produto_tempj, $quantidade)  
	{
		foreach ($produto_tempj as $produto_tj) {

			$idcaixa= $this->session->userdata('idcaixa');  
			$idproduto= $produto_tj->idproduto;
			$codproduto= $produto_tj->codproduto; 
			$desproduto= $produto_tj->desproduto;
			$vlpreco_custo= $produto_tj->vlnota; 
			$vlpreco= $produto_tj->vlpreco;
			$vlprecoatacado= $produto_tj->vlprecoatacado;
			$qtatacado=  $produto_tj->qtatacado;
			$vlpromocao= $produto_tj->vlpromocao;
			$vlpromocaoatacado= $produto_tj->vlprecoatacado;
			$quantidadeitens = $quantidade; //$this->session->userdata('quantidade'); 
			$valordesconto = 0; 
			$valoracrescimo =0; 
			// calculando se vai ser valor normal ou atacado
			$vlpreco= $qtatacado>$quantidadeitens ? $vlpreco : $vlprecoatacado; 
			$valortotal = $vlpreco*$quantidadeitens;
			
		} 

		return $this->modelvendas->adicionar_tempj($idcaixa,$idproduto,$codproduto,$desproduto,$vlpreco_custo,$vlpreco,$vlprecoatacado,$qtatacado,$vlpromocao,$vlpromocaoatacado,$quantidadeitens,$valordesconto,$valoracrescimo,$valortotal);
		
		//exit; 
	}


	function adicionar_produto_temp_jquery()
	{

		//$idcaixa= $this->session->userdata('idcaixa');
		$idcaixa= $this->session->userdata('idcaixa');

		if ($this->input->post('idproduto'))
		{
			$idprodutoj = $this->input->post('idproduto[0]');
			$quantidade_saindo = $this->input->post('quantidade');
			$qtd_itens_ja_add_no_caixa =0; 

			$quantidade_ja_add =  $this->modelprodutos->consulta_produto_temp_aberto(md5($idcaixa), md5($idprodutoj));
			

			if ($quantidade_ja_add)
			{
				foreach ($quantidade_ja_add as $qtdaddcx) 
				{
					$qtd_itens_ja_add_no_caixa += $qtdaddcx->quantidadeitens;
				}
			} 

			$quantidade_tot_sai = $quantidade_saindo + $qtd_itens_ja_add_no_caixa;

			$produto_tempj = $this->modelprodutos->listar_produto(md5($idprodutoj)); 
			$saldo_atual = $this->modelestoque->consulta_estoque_saldo(md5($idprodutoj)); 

			// vamos ver se tem saldo suficeite para a venda.
			$saldo_atual_qtd = $saldo_atual-$quantidade_tot_sai+1; //$qtd_itens_ja_add_no_caixa ;

			if ($saldo_atual_qtd < 0.01)
			{
					// vamos pegar o nome do produto para mostrar na tela
					foreach ($produto_tempj as $prod_saldo) {
						$prod_nome = $prod_saldo->desproduto;
						$prod_codigo = $prod_saldo->codproduto;  
					}

					$mens ='Produto '.$prod_codigo.' - '.strtoupper($prod_nome).' não tem SALDO. Verifique o Estoque!'; 
					$this->session->set_userdata('mensagemjq',$mens);
					$dados['mens'] = $mens ;
				 
				 echo json_encode($dados); 
				 
			}
			else
			{
				$retorno_temp = $this->inserir_temporarioj($produto_tempj, $quantidade_saindo); 
				echo json_encode(""); 
			}

 		}

 		exit; 
	}

	function venda_lista_produto_temp_jquery()
	{
	
		$idcaixa = $this->input->post('idcaixa');

		$produtos_temp = $this->modelvendas->listar_produtos_temp($idcaixa);
		if ($produtos_temp){
			$this->listagem_produto_temp_jquery($produtos_temp); 
		} 
		else
		{
			$output = '';
		}

 		exit; 
	}

	function totaliza_valores_venda_temp(){
		
		$idcaixa = $this->input->post('idcaixa');

		$tot_valores = $this->totalizador_venda_caixa($idcaixa); 

		echo json_encode( $tot_valores );

	}


	function listagem_produto_temp_jquery($produtos_temp)
	{
		/*
		echo '<script>
	    	alert("aloha"); 
	  </script>'; */

		$output ='';

		foreach ($produtos_temp as $produto_t):

      $id = $produto_t->id; 
      $idproduto = $produto_t->idproduto; 
      $codproduto = $produto_t->codproduto; 
      $desproduto = $produto_t->desproduto; 
      $vlpreco    = $produto_t->vlpreco;
      $vlpreco_atacado    = $produto_t->vlprecoatacado;
      $valordesconto    = $produto_t->valordesconto;
      $valoracrescimo    = $produto_t->valoracrescimo;
      $quantidadeitens = $produto_t->quantidadeitens;
      $quant_atacado = $produto_t->qtatacado; 
      $valortotal = $produto_t->valortotal;

      $vlpreco = $quant_atacado > $quantidadeitens ? $vlpreco : $vlpreco_atacado;  
      $vlpreco =reais($vlpreco);
      $valordesconto = reais($valordesconto);
      $valoracrescimo =reais($valoracrescimo);
      $valortotal =    reais($valortotal);

      $botaoalterar = anchor(base_url('venda/produto_temp_altera/'.md5($id)),
          '<h4 class="btn-alterar"><i class="fas fa-edit"> </i> </h4>');

      $botaoexcluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$id.'"> <h4 class="btn-excluir"><i class="fa fa-remove fa-fw"></i> </h4> </button>';

      echo $modal= ' 
      <div class="modal fade excluir-modal-'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">

                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <h4 class="modal-title text-center" id="myModalLabel2"> <i class="fa fa-remove fa-fw"></i> Exclusão de Item </h4>
                  </div>
                  <div class="modal-body">
                      <h4>Deseja Excluir o Item '.$desproduto.'?</h4>
                      <p>Após Excluido, o Item <b>'.$desproduto.'</b> não ficara mais disponível na Venda.</p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <a type="button" class="btn btn-danger" href="'.base_url('venda/excluir_produto_temp/'.md5($id)).'">Excluir</a>
                  </div>

              </div>
          </div>
      </div>';


      $output.='<tr>
						 			<td>						'.$codproduto.			'</td>  
						 			<td>					  '.$desproduto.			'</td>
						 			<td class="valor-unitario">					  '.$vlpreco.					'</td>
						 			<td class="valor-desconto">					  '.$valordesconto.		'</td>
						 			<td class="valor-juros">					  '.$valoracrescimo.	'</td>	 
						 			<td class="quantidadeitens">					  '.$quantidadeitens.	'</td>
						 			<td class="valor-total">					  '.$valortotal.			'</td>
						 			<td>					  '.$botaoalterar.		'</td>  
						 			<td>					  '.$botaoexcluir.		'</td>  
						 		</tr>' ;

  	endforeach; 

 		echo $output;
 		//exit; 
	}


	function consultajquery_itens_venda()
	{
	 	$output = '';
	 	$vendaitem = ''; 

 		if ($this->input->post('idvenda_it'))
 		{
	 		$vendaitem = $this->input->post('idvenda_it'); 
	 	}
	 	else
	 	{
	 		return; 
	 	}

	 	$dados_venda = $this->modelvendas->consulta_venda($vendaitem);
	 	$dados_venda_item = $this->modelvendas->consultajquery_itens_venda($vendaitem);

	 	$codigo_venda = 0;
	 	$valor_venda =0;
	 	if ($dados_venda){
	 		foreach ($dados_venda as $dvenda) {
	 			$codigo_venda = $dvenda->idvenda;
	 			$valor_venda	= reais($dvenda->valorvenda); 
	 		}

	 	}

 		$output .= '
 		<h4 class = "col-lg-7 text-center h4-itens-da-venda"> 
 			ITENS DA VENDA 
 		</h4> 
 		<h4 class = "col-lg-2 text-center h4-itens-da-venda"> 
 			Venda : <b> '.$codigo_venda.' </b>
 		</h4>
 		<h4 class = "col-lg-3 text-center h4-itens-da-venda"> 
 			Valor R$ : <b> '.$valor_venda.' </b>
 		</h4>
 		<table class="table tabela-itens-venda-consulta">
			<thead>
		    <tr>
		      <th scope="col">Código Produto</th> 
		      <th scope="col">Descrição</th> 
		      <th scope="col">Valor Unitário</th>
		      <th scope="col">Quantidade</th>
		      <th scope="col">Valor Total</th>
		    </tr>
		  </thead>


      <tbody>';

	 		if ($dados_venda_item){
	 			foreach ($dados_venda_item as $row) {
	 				$id 				= $row->idvendaitem; 
	 				$codigo 		= $row->codproduto;
	 				$descricao 	= $row->desproduto; 
	 				$vlunitario = $row->valorunitario;
	 				$qtitens		= $row->quantidadeitens;
	 				$vltotal		= $row->valortotal;

	 				$output .= '
	 					<tr>
				 			<td> 						'.$codigo.		'</td>  
				 			<td>					  '.$descricao.	'</td>
				 			<td>					  '.$vlunitario.'</td>
				 			<td>					  '.$qtitens.		'</td>
				 			<td>					  '.$vltotal.		'</td>'	 					 
				 			; 
	 			}

	 		}
	 		else {
		 			$output .= '
		 			<td>---- Nenhum item informado ---- </td>';
	 		}

	 		$output .= '
	 			</tr>
 			</tbody>
 		</table>'; 

 		echo $output;
 		exit; 

	}


	function consultajquery_pagamento()
	{
	 	$output = '';
	 	$idvenda = ''; 

 		if ($this->input->post('idpagamento'))
 		{
	 		$idvenda = $this->input->post('idpagamento'); 
	 	}
	
	 	$dados_venda = $this->modelvendas->consulta_venda($idvenda);
	 	$dados_pagmto = $this->modelvendas->consultajquery_pagamento($idvenda);

	 	$codigo_venda = 0;
	 	$valor_venda =0;
	 	if ($dados_venda){
	 		foreach ($dados_venda as $dvenda) {
	 			$codigo_venda = $dvenda->idvenda;
	 			$valor_venda	= reais($dvenda->valorvenda); 
	 		}

	 	}

		if ($dados_pagmto && $idvenda): 
	 		$output .= '
	 		<h4 class = "col-lg-7 text-center h4-pagamento-da-venda"> 
	 			PAGAMENTO(S) REALIZADO(S) NA VENDA-CREDIÁRIO  
	 		</h4> 
	 		<h4 class = "col-lg-2 text-center h4-pagamento-da-venda"> 
	 			Venda : <b> '.$codigo_venda.' </b>
	 		</h4>
	 		<h4 class = "col-lg-3 text-center h4-pagamento-da-venda"> 
	 			Valor R$ : <b> '.$valor_venda.' </b>
	 		</h4>
	 		<table class="table tabela-itens-venda-consulta">
				<thead>
			    <tr>
			    	<th scope="col">Código Recebimento</th>
			      <th scope="col">Código Caixa</th> 
			      <th scope="col">Data Pagamento</th> 
			      <th scope="col">Tipo Pagamento</th>
			      <th scope="col">Juros R$</th>
			      <th scope="col">Descontos R$</th>
			      <th scope="col">Valor Total</th>
			      <th scope="col">Situacao </th>
			    </tr>
			  </thead>

	      <tbody>';

		 		if ($dados_pagmto && $idvenda){
		 			foreach ($dados_pagmto as $pagto) {
		 				$idreceb			= $pagto->idcaixa_mov;
		 				$caixa 				= $pagto->idcaixa; 
		 				$data 				= datebr($pagto->data_movimento);
		 				$destipopag 	= $pagto->destipopagamento; 
		 				$vljuros		 	= reais($pagto->vl_juros);
		 				$vldesconto		= reais($pagto->vl_desconto);
		 				$vltotal			= reais($pagto->vl_movimento);
		 				$situacao     = $pagto->situacao;


		 				$output .= '
		 					<tr>
					 			<td>						'.$idreceb.		'</td>  
					 			<td>					  '.$caixa.	'</td>
					 			<td>					  '.$data.'</td>
					 			<td>					  '.$destipopag.'</td>
					 			<td>					  '.$vljuros.		'</td>	 
					 			<td>					  '.$vldesconto.		'</td>
					 			<td>					  '.$vltotal.		'</td>';

					 			if ($situacao ==2)
					 				{
					 					$output .= '<td id="recebimento-cancelado"> CANCELADA </td>';
					 				}
					 				else
					 				{
					 					$output .= '<td id="recebimento-normal"> Normal </td>';
					 				}
					 			
		 			}

		 		}
		 		else {
			 			$output .= '
			 			<td>---- Nenhum item informado ---- </td>';
		 		}

		 		$output .= '
		 			</tr>
	 			</tbody>
	 		</table>'; 
	 	endif;

 		echo $output;
 		exit; 

	}
	


}
