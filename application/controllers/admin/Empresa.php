<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		$this->load->model('empresa_model','modelempresa');

	}

	public function page_login_empresa()
	{

		$dados['titulo'] 	= 'Acesso ao Sistema';
		$dados['subtitulo'] = ' Geral'; 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/mensagem');
		$this->load->view('backend/login_empresa');
		$this->load->view('backend/template/html-footer');

	}

	public function login_empresa(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-user-empresa',        // id do input (template)
		'Usuário Empresa',		     // nome da label (template)
		'required|min_length[3]'); 	//requerido|minimo 3 caract|
		$this->form_validation->set_rules(
		'txt-senha-empresa','Senha Empresa','required|min_length[3]'); 	 
				
		if ($this->form_validation->run() == FALSE){
				$this->page_login_empresa();   // se nao validar, retorna para a pagina
		} else {
				// carregar as var com os campos do formulario
				$usuario = $this->input->post('txt-user-empresa');
				$senha   = $this->input->post('txt-senha-empresa'); 

				$empresaLogada= $this->modelempresa->autentica($usuario, $senha); 

				if (count($empresaLogada) == 1){
						$dadosSessao['acessoGeral'] = $userLogado[0];
						$dadosSessao['empresa_logada'] = TRUE; 
						$this->session->set_userdata($dadosSessao); 

						redirect(base_url('home'));
				
				} else {
					 
						$mensagem ="Usuario ou senha invalidos"; 
						$this->session->set_userdata('mensagemErro',$mensagem); 
						//redirect(base_url('admin/login')); 
						$this->logout_empresa(); 

				}
		}
	}

	public function logout_empresa(){

		$dadosSessao['acessoGeral'] = NULL; 
		$dadosSessao['empresa_logada'] = FALSE; 
		$this->session->set_userdata($dadosSessao); 
		$this->session->unset_userdata($dadosSessao,'userLogado'); 
		$this->session->unset_userdata($dadosSessao,'logado');
		$this->session->unset_userdata('itensPorPagina');
		$this->session->unset_userdata('qtdItensInfo');
		$this->session->unset_userdata('tipolista');
		$this->session->unset_userdata('tipo_acesso');
		$this->session->unset_userdata('ultimoAviso'); 
		$this->session->unset_userdata('idcaixa');
		$this->session->unset_userdata('operacao'); 

		redirect(base_url('admin/loginempresa')); 

	}

}
