<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 
		$this->load->model('empresa_model','modelempresa');	
		$this->modelempresa->retorna_inicio_geral();

		$this->load->model('usuarios_model','modelusuarios');

		$this->load->model('picklist_model','model_tipo_usuario'); 
		$this->load->model('caixa_model','modelcaixas'); 
		$this->lista_usuarios = $this->modelusuarios->listar_usuarios();
		$this->lista_tipo_acesso = $this->model_tipo_usuario->lista_tipo_acesso();  


	}

	public function index()
	{
		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		// dados a serem enviados para o cabeçalho
		$dados['titulo'] 		= 'Painel de Controle';
		$dados['subtitulo'] = 'Usuarios';
		$dados['lista_usuarios']  = $this->lista_usuarios;  
		$dados['lista_tipo_acesso'] = $this->lista_tipo_acesso;
		$dados['lista_caixas'] = $this->modelcaixas->getListar_caixas(); 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/usuarios');
		$this->load->view('backend/template/html-footer'); 

	}

	public function inserir()
	{
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}
		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-nome',        // id do input (template)
		'Nome do Usuario',		// nome da label (template)
		'required|min_length[3]');  

	

		$this->form_validation->set_rules('idtipo_acesso', 'Tipo de Acesso',		 
		'required');

		$this->form_validation->set_rules('txt-user', 'Login',		 
		'required|min_length[3]|is_unique[usuario.user]');

		$this->form_validation->set_rules('txt-senha', 'Senha',		 
		'required|min_length[3]');

		$this->form_validation->set_rules('txt-csenha', 'Confirmar Senha',		 
		'required|matches[txt-senha]');
															 
		if ($this->form_validation->run() == FALSE){

				$this->index();   // se nao validar, retorna para a pagina

		} else {

			$nome= $this->input->post('txt-nome');
			$email= $this->input->post('txt-email');
			$idtipo_acesso= $this->input->post('idtipo_acesso');
			$historico= $this->input->post('txt-historico');
			$user= $this->input->post('txt-user');
			$senha= $this->input->post('txt-senha');
			$idcaixa_autorizado = $this->input->post('idcaixa_autorizado'); 

			if ($this->modelusuarios->adicionar($nome,$email,$idtipo_acesso,$historico,$user,$senha, $idcaixa_autorizado)){
				$mensagem ="Usuario Adicionada Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagemAlert',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Usuário!"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/usuarios'));

		}

	}

	public function excluir($id)
	{
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

		if ($this->modelusuarios->excluir($id)){

			$mensagem ="Usuario Excluido Com Sucesso !"; 
			$this->session->set_userdata('mensagemAlert',$mensagem);  

		} else {

			$mensagem ="Erro ao Excluir Usuario!"; 
			$this->session->set_userdata('mensagemErro',$mensagem);

		}

		redirect(base_url('admin/usuarios')); 
	}

	public function alterar($id)
	{
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

		// dados a serem enviados para o cabeçalho
		$lista_usuario= $this->modelusuarios->lista_usuario($id);

		$dados['titulo'] 		= 'Painel de Controle';
		$dados['subtitulo'] = 'Usuarios - Alteração';
		$dados['lista_usuario']  = $lista_usuario; 
		$dados['lista_tipo_acesso'] = $this->lista_tipo_acesso; 
		$dados['lista_caixas'] = $this->modelcaixas->getListar_caixas(); 

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('frontend/template/mensagem-alert');
		$this->load->view('backend/altera-usuarios');
		$this->load->view('backend/template/html-footer');

	}

	public function salvar_alteracoes()
	{
		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

		// validar form
		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-nome',        // id do input (template)
		'Nome do Usuario',		// nome da label (template)
		'required|min_length[3]');  

		$this->form_validation->set_rules('idtipo_acesso', 'Tipo de Acesso',		 
		'required');

		$this->form_validation->set_rules('txt-user', 'Login',		 
		'required|min_length[3]');

		$this->form_validation->set_rules('txt-senha', 'Senha',		 
		'required|min_length[3]');

		$this->form_validation->set_rules('txt-csenha', 'Confirmar Senha',		 
		'required|matches[txt-senha]');
															 
		if ($this->form_validation->run() == FALSE){

				$this->alterar(md5($this->input->post('txt-id')));   // se nao validar, retorna para a pagina

		} else {

			$nome= $this->input->post('txt-nome');
			$email= $this->input->post('txt-email');
			$historico= $this->input->post('txt-historico');
			$idtipo_acesso= $this->input->post('idtipo_acesso');
			$user= $this->input->post('txt-user');
			$senha= $this->input->post('txt-senha');
			$id = $this->input->post('txt-id'); 
			$idcaixa_autorizado = $this->input->post('idcaixa_autorizado'); 

			if ($this->modelusuarios->alterar($nome,$email,$historico,$idtipo_acesso,$user,$senha,$id,$idcaixa_autorizado)){
				$mensagem ="Usuario Alterado Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagemAlert',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao Alterar Usuário!"; 

				$this->session->set_userdata('mensagemErro',$mensagem); 

			}

			redirect(base_url('admin/usuarios'));

		}

	}

	public function nova_imagem(){

		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

		$id = $this->input->post('id'); 
		$config['upload_path']= './assets/frontend/img/usuarios'; 
		$config['allowed_types']= 'jpg'; 
		$config['file_name']= $id.'.jpg';
		$config['overwrite']= TRUE;  // sobrepor a imagem sempre que for alterada(mesmo ID)
		$this->load->library('upload', $config); 

		if (!$this->upload->do_upload()){

				$mensagem = "ERRO!".$this->upload->display_errors(); 
				$this->session->set_userdata('mensagemErro',$mensagem);

				redirect(base_url('admin/usuarios/alterar/'.$id));

		} else {

				$config2['source_image']= './assets/frontend/img/usuarios/'.$id.'.jpg';
				$config2['create_thumb']= FALSE;
				$config2['width']= 200;   // largura da imagem
				$config2['height']= 200; 	// altura da imagem

				$this->load->library('image_lib', $config2); 

				if ($this->image_lib->resize()){

						$dir_imagem = $config2['source_image'];

						if ($this->modelusuarios->alterar_img($id, $dir_imagem)){
								$mensagem = "Upload da Imagem Realizado Com Sucesso!";
								$this->session->set_userdata('mensagemAlert',$mensagem);
						} else{
								$mensagem = "Erro ao Realizar o Upload da Imagem!";
								$this->session->set_userdata('mensagemErro',$mensagem);
						}

						redirect(base_url('admin/usuarios/alterar/'.$id)); 

				} else {

						$mensagem = "ERRO!".$this->image_lib->display_errors();
						$this->session->set_userdata('mensagemErro',$mensagem);

						redirect(base_url('admin/usuarios/alterar/'.$id)); 
						
				}

		}

	}

	private function ver_tipo_acesso(){

		$tipo_acesso = $this->input->post('vendas');
	
		if ($tipo_acesso==1){
				$this->session->set_userdata('tipo_acesso',"venda");
		} else{
				$this->session->set_userdata('tipo_acesso',"admin");
		}

	}

	public function page_login()
	{
		$this->ver_tipo_acesso(); 

		$dados['titulo'] 		= 'Painel de Controle';

		if ($this->session->userdata('tipo_acesso')=="venda") {
			$dados['subtitulo'] = 'Acesso ao Sistema de Vendas';
		}else{
			$dados['subtitulo'] = 'Acesso a Administração do Sistema';
		}

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/login');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/template/html-footer');

	}

	public function login(){

		$this->ver_tipo_acesso(); 

		$this->load->library('form_validation');
		$this->form_validation->set_rules(
		'txt-user',        // id do input (template)
		'Usuário',		     // nome da label (template)
		'required|min_length[3]'); 	//requerido|minimo 3 caract|
		$this->form_validation->set_rules(
		'txt-senha','Senha','required|min_length[3]'); 	 
				
		if ($this->form_validation->run() == FALSE){
				$this->page_login();   // se nao validar, retorna para a pagina
		} else {
				// carregar as var com os campos do formulario
				$usuario = $this->input->post('txt-user');
				$senha   = $this->input->post('txt-senha'); 

				$userLogado = $this->modelusuarios->autentica($usuario, $senha); 

				foreach ($userLogado as $user_log) {
					 $tp_acesso = $user_log->tipo_acesso; 
				}

				if (count($userLogado) == 1){
						$dadosSessao['userLogado'] = $userLogado[0];
						$dadosSessao['logado'] = TRUE; 
						$this->session->set_userdata($dadosSessao); 
						$this->session->unset_userdata('ultimoAviso'); 
						// para acesso a venda

						if ($this->session->userdata('tipo_acesso')=="venda"){ 
							
								if ($tp_acesso ==2 || $tp_acesso == 3)
								{

									// encerrar a secao
	          			//$this->session->unset_userdata('tipo_acesso'); 
									redirect(base_url('venda'));
								}else{
									$mensagem ="Usuario não tem permissão para o Acesso!"; 
									$this->session->set_userdata('mensagemErro',$mensagem); 
									$this->logout();
								}

						}else{

								if ($tp_acesso ==1 || $tp_acesso == 3) 
								{
									redirect(base_url('admin'));
								}else{
									$mensagem ="Usuario não tem permissão para o Acesso!"; 
									$this->session->set_userdata('mensagemErro',$mensagem); 
									$this->logout();
								}
						} 
				} else {
					 
						$mensagem ="Usuario ou senha invalidos"; 
						$this->session->set_userdata('mensagemErro',$mensagem); 
						//redirect(base_url('admin/login')); 
						$this->logout(); 

				}
		}
	}

	public function logout(){

		$dadosSessao['userLogado'] = NULL; 
		$dadosSessao['logado'] = FALSE; 
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

		redirect(base_url('home')); 

	}

}
