<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {

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
		$this->load->model('estoque_model','modelestoque');
		$this->load->model('caixa_model','modelcaixa_movimento'); 
		
		$this->produtos = $this->modelprodutos->listar_produtos(); 
		$this->tipo_pagamento = $this->model_tipo_pagamento->lista_tipos_pagamentos(); 
		//$this->caixa_movimento = $this->modelcaixa_movimento->movimentos_caixa(); 


	}

	public function movimentos_caixa()
	{

		$dados['avista']				= null;
		$dados['cartaodebito'] 	= null;
		$dados['cartaocredito'] = null;
		$dados['crediario'] 		= null;
		$dados['crediarioreceb']= null;
		$dados['datainicio'] 		= null;
		$dados['datafinal']			= null; 
		$dados['vendaexterna']	= null; 
		$dados['valor_disp_cx']	= null; 
		$dados['trocoini']			= null; 
		$dados['retirada_dinheiro']	= null; 

		$dados['avista'] 				=$this->session->userdata('avista');
		$dados['cartaodebito'] 	=$this->session->userdata('cartaodebito');
		$dados['cartaocredito'] =$this->session->userdata('cartaocredito');
		$dados['crediario']			=$this->session->userdata('crediario');
		$dados['crediarioreceb']=$this->session->userdata('crediarioreceb');
		$dados['datainicio'] 		=$this->session->userdata('datainicio');
		$dados['datafinal']			=$this->session->userdata('datafinal');
		$dados['vendaexterna']	=$this->session->userdata('vendaexterna');
		$dados['valor_disp_cx'] =$this->session->userdata('valor_disp_cx');
		$dados['trocoini']			=$this->session->userdata('trocoini');
		$dados['retirada_dinheiro']			=$this->session->userdata('retirada_dinheiro');

		$idcaixa=1; 
		$dados['idcaixa']= $idcaixa; 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		//$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/caixa_movimentos');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer'); 

	}

	public function movimento_cancel_mov_caixa()
	{
		$this->modelcaixa_movimento->encerra_sessoes_caixa();  
		$idcaixa=1; 
		$datainicio = date('Y-m-d');
		$datafinal = date('Y-m-d'); 
		$this->load->library('table');

		$dados['movimento_caixa_do_dia']=$this->modelcaixa_movimento->getConsulta_movimento_caixa(md5($idcaixa), $datainicio, $datafinal);

		$dados['idcaixa']= $idcaixa; 

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/caixa_movimentos_cancelamento');
		$this->load->view('frontend/template/html-footer');

	}

	public function confirma_cancelamento_mov($idcaixa_mov, $idvenda=null, $tipo_movimento, $valor=null, $idcliente=null, $idretirada=null)
	{
		$idcliente_md = md5($idcliente); 
		// vamos iniciar a transação 
    $this->db->trans_begin();

    // CANCELAR MOVIMENTO DO CAIXA ---------------
		if (!$this->modelcaixa_movimento->cancela_movimento_caixa($idcaixa_mov, $tipo_movimento))
		{
			$mensagem = "Houve um erro ao Cancelar a Venda/Movimento (modelcaixa_movimento/cancela_movimento_caixa)"; 
			$this->session->set_userdata('mensagemErro',$mensagem);
			$this->db->trans_rollback(); 
			redirect(base_url('caixa/movimento_cancel_mov_caixa')); 
		}

		// CANCELAR RETIRADA, CASO SEJA ----------------
		if ($idretirada && $tipo_movimento ==9)
		{
			if (!$this->modelcaixa_movimento->cancela_caixa_retirada($idretirada))
			{
				$mensagem = "Houve um erro ao cancelar RETIRADA (modelcaixa_movimento/cancela_caixa_retirada)"; 
				$this->session->set_userdata('mensagemErro',$mensagem);
				$this->db->trans_rollback(); 
				redirect(base_url('caixa/movimento_cancel_mov_caixa')); 

			}
		}

    // CANCELAMENTO DE VENDAS, CASO TENHA --------------
    if ($idvenda && $tipo_movimento !=9)
    {

    	$resultado_cancel = $this->modelvendas->cancelar_venda($idvenda);
	
			if (!$resultado_cancel=="ok")
			{ 
				$mensagem = "Houve um erro ao Cancelar a Venda/Movimento (modelvendas/cancelar_venda)"; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				$this->db->trans_rollback(); 
				redirect(base_url('caixa/movimento_cancel_mov_caixa')); 

			}
		}

		// ATUALIZAR SALDO DO CLIENTE, CASO TENHA  ---------------
		if ($idcliente && $tipo_movimento !=9)
		{
			if (!$this->modelvendas->atualiza_saldo_crediario($idcliente, $idcliente_md, $valor ,"cancelamento_venda"))
			{

				$mensagem = "Houve um erro ao Atualizar o Saldo do Cliente (modelvendas/atualiza_saldo_crediario)"; 
				$this->session->set_userdata('mensagemErro',$mensagem);
				$this->db->trans_rollback(); 
				redirect(base_url('caixa/movimento_cancel_mov_caixa')); 

			}
		}

		if  ($this->db->trans_status()===FALSE ) 
		{ 
			  $this->db->trans_rollback(); 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (caixa/confirma_cancelamento_mov) "; 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('caixa/movimento_cancel_mov_caixa'));
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Cancelamento Realizada com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem); 
			redirect(base_url('caixa/movimento_cancel_mov_caixa'));
	
		}

	}

	public function retirada_caixa($datainicio, $datafinal)
	{
		$idcaixa=1; 

		$dados['idcaixa']= $idcaixa; 
		$dados['datainicio']= $datainicio;
		$dados['datafinal']= $datafinal;
		$dados['tipo_retirada']=$this->model_tipo_pagamento->getLista_tipo_retirada();
		//$dados['valor_disp_cx'] = $valor_disp_cx;  

		$this->load->view('frontend/template/html-header',$dados);
		$this->load->view('frontend/template/header');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('frontend/caixa_retirada');
		$this->load->view('frontend/template/footer');
		$this->load->view('frontend/template/html-footer');

	}

	public function confirma_retirada($idcaixa)
	{
		$valor_retirada = $this->input->post('vl_retirada_caixa');
		$codigousuario 	= $this->session->userdata('userLogado')->id;
		$tipo_retirada 	= $this->input->post('id_retirada_mov');

		// vamos iniciar a transação 
    $this->db->trans_begin(); 

    // VAMOS GRAVAR A RETIRADA 
    $res_retirada = $this->modelcaixa_movimento->grava_caixa_retirada($idcaixa,$valor_retirada,$tipo_retirada,$codigousuario);
    if ($res_retirada)
    {
    	$idretirada = $this->db->insert_id();
    }
    else
		{
			$idretirada = $this->db->insert_id();

			$mensagem = "Erro ao Gravar Retirada! (modelcaixa_movimento/grava_caixa_retirada)"; 
		
			$this->db->trans_rollback(); 
			$this->session->set_userdata('mensagemErro',$mensagem); 
			redirect(base_url('caixa/consulta_dados_caixa/ret'));
		}

		// VAMOS GRAVAR O MOVIMENTO DA RETIRADA 
		if (!$this->modelcaixa_movimento->grava_caixa_mov($idcaixa, 0, 0, $codigousuario, 9, $valor_retirada, 0, 0, 5, 0, 0, $idretirada))
		{
			$mensagem = "Erro no Processo, Retirada não Realizada!(modelcaixa_movimento/grava_caixa_mov)"; 
				echo $mensagem;
			exit; 
			$this->db->trans_rollback(); 
			$this->session->set_userdata('mensagemErro',$mensagem); 
			redirect(base_url('caixa/consulta_dados_caixa/ret'));
		}

		if ($this->db->trans_status()===FALSE) 
		{ 
			  $mensagem = "Houve um ERRO de TRANSAÇÃO! (caixa/confirma_retirada) "; 
			  $this->db->trans_rollback(); 
				$this->session->set_userdata('mensagemErro',$mensagem); 
				redirect(base_url('caixa/consulta_dados_caixa/ret'));
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$mensagem = "Retirada de valores Realizada com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem); 
			redirect(base_url('caixa/consulta_dados_caixa/ret'));
	
		}

	}

	function consulta_dados_caixa($local_chamado=null)
	{

		$idcaixa =1; 
	 	$datainicio = $this->input->post('datainicial_mov');
	 	$datafinal  = $this->input->post('datafinal_mov');  
	 	$idcaixa_md5 = md5($idcaixa); 

	 	if ($local_chamado == "ret")
	 	{
		 	$datainicio = $this->session->userdata('datainicio');
		 	$datafinal  = $this->session->userdata('datafinal');
		 	$idcaixa_md5 = md5($idcaixa); 
			
		}

		$this->modelcaixa_movimento->encerra_sessoes_caixa(); 

	 	$dados = $this->modelcaixa_movimento->getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal);

	 	$vl_movimento=0;
	 	$vl_juros =0;
	 	$vl_desconto =0; 
	 	$tipo_movimento; 

	 	$idcaixa_mov = 0;
	 	$idcliente =0; 
	 	$data_movimento =0; 
	 	$desmovimento = "";
	 	$despagamento = "";

	 	$avista = 0;
	 	$cartaodebito =0;
	 	$cartaocredito =0;
	 	$crediario =0;
	 	$crediarioreceb =0; 
	 	$trocoini=0; 
	 	$valor_disp_cx =0; 
	 	$retirada_dinheiro=0; 
	 	$vendaexterna=0; 

		foreach ($dados as $movimento_caixa_result) 
		{
			$tipo_movimento= $movimento_caixa_result->tipo_movimento_caixa;
			$vl_movimento = $movimento_caixa_result->vl_movimento;
			$vl_juros 		= $movimento_caixa_result->vl_juros;
			$vl_desconto 	= $movimento_caixa_result->vl_desconto;
			$vl_real 			= $vl_movimento + $vl_juros - $vl_desconto; 
			$situacao			= $movimento_caixa_result->	situacao;
			$idcaixa_mov 	= $movimento_caixa_result->idcaixa_mov;
			$idcliente		= $movimento_caixa_result->idcliente;
			$data_movimento=$movimento_caixa_result->data_movimento;
			$desmovimento = $movimento_caixa_result->tipo_movimento_caixa;
			$despagamento	= $movimento_caixa_result->tipo_pagamento_crediario; 

			if ($situacao ==0 )  // se nao for cancelado 
			{

				if ($tipo_movimento ==10)
				{
					$trocoini += $vl_movimento; 
				}

				if ($tipo_movimento ==1)
				{
					$avista += $vl_real; 
				}
				elseif ($tipo_movimento ==2)
				{
					$cartaodebito += $vl_real;
				}
				elseif ($tipo_movimento ==3)
				{
					$cartaocredito += $vl_real;
				}
				elseif ($tipo_movimento ==4)
				{
					$crediario += $vl_real;
				}
				elseif ($tipo_movimento ==5)
				{
					$crediarioreceb += $vl_real; 
				}
				elseif ($tipo_movimento ==8)
				{
					$vendaexterna += $vl_real; 
				}
				elseif ($tipo_movimento ==9)
				{
					$retirada_dinheiro += $vl_movimento; 
				}

				$valor_disp_cx = $trocoini+$avista+$crediarioreceb+$vendaexterna-$retirada_dinheiro; 
			}
	
		}

		if (!$avista
			&& 
			!$cartaodebito
			&& 
			!$cartaocredito
			&& 
			!$crediario
			&& 
			!$crediarioreceb
			&& 
			!$vendaexterna
			&& 
			!$trocoini
		)
		{
			$mensagem = "Nao ha movimento no periodo informado!"; 
			$this->session->set_userdata('datainicio',$datainicio);
			$this->session->set_userdata('datafinal',$datafinal);
			$this->session->set_userdata('mensagemErro',$mensagem); 
		}
		else
		{

			$this->session->set_userdata('idcaixa',$idcaixa);
			$this->session->set_userdata('avista',$avista);
			$this->session->set_userdata('cartaodebito',$cartaodebito);
			$this->session->set_userdata('cartaocredito',$cartaocredito);
			$this->session->set_userdata('crediario',$crediario);
			$this->session->set_userdata('crediarioreceb',$crediarioreceb);
			$this->session->set_userdata('vendaexterna',$vendaexterna);
			$this->session->set_userdata('datainicio',$datainicio);
			$this->session->set_userdata('datafinal',$datafinal);
			$this->session->set_userdata('valor_disp_cx',$valor_disp_cx);
			$this->session->set_userdata('trocoini',$trocoini);
			$this->session->set_userdata('retirada_dinheiro',$retirada_dinheiro);
		}
		 
		redirect(base_url('caixa/movimentos_caixa')); 

	}


	function consultajquery_dados_caixa()
	{

	 	$output = '';
 	 
	 	$idcaixa = $this->input->post('idcaixa_mov');
	 	$datainicio = $this->input->post('datainicial_mov');
	 	$datafinal  = $this->input->post('datafinal_mov');  
	 	$mov_avista  = $this->input->post('mov_avista');
	 	$mov_debito  = $this->input->post('mov_debito');
	 	$mov_credito  = $this->input->post('mov_credito');
	 	$mov_crediario  = $this->input->post('mov_crediario');
	 	$mov_crediariorec  = $this->input->post('mov_crediariorec');
	 	$mov_externa  = $this->input->post('mov_externa');
	 	$porJQuery = $this->input->post('porJQuery'); 
	 	$idcaixa_md5 = md5($idcaixa);
	 	$mov_troco_ini  = $this->input->post('mov_troco_ini');
	 	$mov_retirada  = $this->input->post('mov_retirada');

	 	$dados = $this->modelcaixa_movimento->getConsulta_movimento_caixa($idcaixa_md5, $datainicio, $datafinal, $mov_avista, $mov_debito, $mov_credito, $mov_crediario, $mov_crediariorec, $mov_externa, $porJQuery, $mov_troco_ini, $mov_retirada);

 
	 	$vl_movimento=0;
	 	$vl_juros =0;
	 	$vl_desconto =0; 
	 	$tipo_movimento; 

	 	$idcaixa_mov = 0;
	 	$idcliente =0; 
	 	$data_movimento =0; 
	 	$desmovimento = "";
	 	$despagamento = "";

	 	$avista = 0;
	 	$cartaodebito =0;
	 	$cartaocredito =0;
	 	$crediario =0;
	 	$crediarioreceb =0; 
	 	$vl_real =0; 
	 	$total_real=0; 
	 	$total_can=0;

		foreach ($dados as $movimento_caixa_result) 
		{
			$tipo_movimento= $movimento_caixa_result->tipo_movimento_caixa;
			$vl_movimento = $movimento_caixa_result->vl_movimento;
			$vl_juros 		= $movimento_caixa_result->vl_juros;
			$vl_desconto 	= $movimento_caixa_result->vl_desconto;
			$vl_real 			= $vl_movimento + $vl_juros - $vl_desconto; 
			$situacao			= $movimento_caixa_result->situacao;
			$idcaixa_mov 	= $movimento_caixa_result->idcaixa_mov;
			$idcliente		= $movimento_caixa_result->idcliente;
			$data_movimento= datebr($movimento_caixa_result->data_movimento);
			$desmovimento = $movimento_caixa_result->desmovimento;
			$despagamento	= $movimento_caixa_result->destipopagamento; 
			$codigousuario = $movimento_caixa_result->codigousuario; 
			$idvenda = $movimento_caixa_result->idvenda; 

			if ($situacao == 0)
			{
				$total_real += $vl_real; 
			}

			if ($situacao == 1)
			{
				$total_can += $vl_real; 
			}

			if ($tipo_movimento ==5 
				|| 
				$tipo_movimento==9
				|| 
				$tipo_movimento==10
			)
			{

          $botaovenda ="";
      } 
      else
      {
          $botaovenda = '<a href="'.base_url('venda/consulta_venda/').md5($idvenda).'/movcaixa'.'" > <h4 class="btn-alterar"><i class="fas fa-shopping-cart"> </i> </h4> </a>';
      }

			$vl_juros = reais($vl_juros); 
			$vl_desconto = reais($vl_desconto);
			$vl_real = reais($vl_real); 


			if ($situacao == 1)
			{

				$output .= '
					<tr class="venda-mov-cancelado">
			 			<td>	'.$idcaixa_mov.			'</td>  
			 			<td>	'.$data_movimento.	'</td>
			 			<td>	'.$codigousuario.		'</td>
			 			<td>	'.$desmovimento.		'-CANC</td>
			 			<td>	'.$despagamento.		'</td>
			 			<td>	'.$vl_juros.				'</td>
			 			<td>	'.$vl_desconto.			'</td>
			 			<td>	'.$vl_real.					'</td>
			 			<td>	'.$botaovenda.			'</td>
			 		</tr>	'			 
				; 
			}
			else
			{

				$output .= '
					<tr>
			 			<td>	'.$idcaixa_mov.			'</td>  
			 			<td>	'.$data_movimento.	'</td>
			 			<td>	'.$codigousuario.		'</td>
			 			<td>	'.$desmovimento.		'</td>
			 			<td>	'.$despagamento.		'</td>
			 			<td>	'.$vl_juros.				'</td>
			 			<td>	'.$vl_desconto.			'</td>
			 			<td>	'.$vl_real.					'</td>
			 			<td>	'.$botaovenda.			'</td>
			 		</tr>	'			 
				; 

			}
		}

		if ($total_real > 0)
		{
			$total_real = reais($total_real); 

			$output .= '
				<tr>
	        <th scope="col"> TOT </th>
	        <td> '.$total_real.'</td> 
	      </tr> 
				r>'; 
		}


		if ($total_can > 0)
		{
			$total_can = reais($total_can); 

			$output .= '
				<tr class="venda-mov-cancelado">
	        <th scope="col"> CAN </th>
	        <td> '.$total_can.'</td> 
	      </tr> 
				r>'; 
		}

 		echo $output;
 		exit; 

	}


}
