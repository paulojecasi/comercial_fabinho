<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{

		parent::__construct(); 

		$this->load->model('usuarios_model','modelusuarios');
		$this->lista_usuarios = $this->modelusuarios->listar_usuarios(); 

	}

	public function index()
	{

		if (!$this->session->userdata('logado')){
				redirect(base_url('admin/login')); 
		}

		// vamos carregar a biblioteca de TABELAS
		$this->load->library('table'); 

		// dados a serem enviados para o cabeçalho
		$dados['titulo'] 		= 'Painel de Controle';
		$dados['subtitulo'] = 'Usuarios';
		$dados['lista_usuarios']  = $this->lista_usuarios;  

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
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

		$this->form_validation->set_rules('txt-email', 'E-mail',		 
		'required|is_unique[usuario.email]');

		$this->form_validation->set_rules('txt-historico', 'Historico',		 
		'required|min_length[10]');

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
			$historico= $this->input->post('txt-historico');
			$user= $this->input->post('txt-user');
			$senha= $this->input->post('txt-senha');

			if ($this->modelusuarios->adicionar($nome,$email,$historico,$user,$senha)){
				$mensagem ="Usuario Adicionada Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 
				
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
			$this->session->set_userdata('mensagem',$mensagem);  

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

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/template/template');
		$this->load->view('backend/mensagem');
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

		$this->form_validation->set_rules('txt-email', 'E-mail',		 
		'required');

		$this->form_validation->set_rules('txt-historico', 'Historico',		 
		'required|min_length[10]');

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
			$user= $this->input->post('txt-user');
			$senha= $this->input->post('txt-senha');
			$id = $this->input->post('txt-id'); 

			if ($this->modelusuarios->alterar($nome,$email,$historico,$user,$senha,$id)){
				$mensagem ="Usuario Adicionada Com Sucesso !"; 

				// usando seção da framework (session)
				$this->session->set_userdata('mensagem',$mensagem); 
				
			} else {

				$mensagem = "Houve um erro ao adicionar Usuário!"; 

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
								$this->session->set_userdata('mensagem',$mensagem);
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

	public function page_login()
	{
		$dados['titulo'] 		= 'Painel de Controle';
		$dados['subtitulo'] = 'Entrar no Sistema';

		$this->load->view('backend/template/html-header', $dados);
		$this->load->view('backend/login');
		$this->load->view('backend/mensagem');
		$this->load->view('backend/template/html-footer');

	}

	public function login(){
		// validar form
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

				$this->db->where('user=',$usuario);
				$this->db->where('senha=',md5($senha));
				$userLogado = $this->db->get('usuario')->result();

				if (count($userLogado) == 1){
						$dadosSessao['userLogado'] = $userLogado[0];
						$dadosSessao['logado'] = TRUE; 
						$this->session->set_userdata($dadosSessao); 
						redirect(base_url('admin')); 
				} else {
						$dadosSessao['userLogado'] = NULL; 
						$dadosSessao['logado'] = FALSE; 
						$this->session->unset_userdata($dadosSessao); 

						$mensagem ="Usuario ou senha invalidos"; 
						$this->session->set_userdata('mensagemErro',$mensagem); 

						redirect(base_url('admin/login')); 

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

		redirect(base_url('admin/login')); 

	}

}
