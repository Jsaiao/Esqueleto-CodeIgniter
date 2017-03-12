<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function view($page = 'home') {

		$this->load->model('menus_model');

		$data['title'] = '';

		if ($page == "home") {
			$data['title'] = 'Home';
		}

		$data['menus'] = $this->menus_model->getMenus();
		$data['menu_ativo'] = $page;

		$this->load->model('paginas_model');

		if ($this->paginas_model->paginaExisteNoDb($page) == true) {
			// Existe essa página no banco de dados
			$this->template->load_from_db('pages', $page, $data, 'default');
		} else {
			// Não existe essa página no banco de dados
			if (!file_exists(APPPATH.'views/frontend/pages/'.$page.'.php')) {
				show_my_404();
				exit;
			}
			
			$this->template->load('pages', $page, $data, 'default');
		}
	}

}
