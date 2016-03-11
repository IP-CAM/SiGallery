<?php
class ControllerModuleSigallery extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('module/sigallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('sigallery', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_module_image'] = $this->language->get('text_module_image');
		$data['text_module_menu'] = $this->language->get('text_module_menu');
		$data['entry_sigallery'] = $this->language->get('entry_sigallery');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_module_type'] = $this->language->get('entry_module_type');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_manage_gallery'] = $this->language->get('button_manage_gallery');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['dimension'])) {
			$data['error_dimension'] = $this->error['dimension'];
		} else {
			$data['error_dimension'] = false;
		}
		$data['manage_gallery'] = $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'], 'SSL');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/sigallery', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/sigallery', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/sigallery', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 130;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 100;
		}	
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		if (isset($this->request->post['gallery'])) {
			$data['gallery'] = $this->request->post['gallery'];
		} elseif (!empty($module_info)) {
			$data['gallery'] = $module_info['gallery'];
		} else {
			$data['gallery'] = '';
		}
		if (isset($this->request->post['module_type'])) {
			$data['module_type'] = $this->request->post['module_type'];
		} elseif (!empty($module_info)) {
			$data['module_type'] = $module_info['module_type'];
		} else {
			$data['module_type'] = 0;
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('catalog/sigallery');
		$data['sigallerys'] = $this->model_catalog_sigallery->getSigallerys();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/sigallery.tpl', $data));
	}
	
	public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "sigallery` (
  `sigallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width_popup` int(11) NOT NULL,
  `height_popup` int(11) NOT NULL,
  `autoplay` int(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `gallery_image` tinytext NOT NULL,
  PRIMARY KEY (`sigallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "sigallery_description` (
  `sigallery_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `description_after` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`sigallery_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "sigallery_image` (
  `sigallery_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `sigallery_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`sigallery_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "sigallery_image_description` (
  `sigallery_image_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `sigallery_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`sigallery_image_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery` (`sigallery_id`, `status`, `sort_order`, `parent`, `width`, `height`, `width_popup`, `height_popup`, `autoplay`, `type`, `gallery_image`) VALUES
(1, 1, 1, 0, 200, 200, 0, 0, 0, 1, '');");
		$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_description` (`sigallery_id`, `language_id`, `title`, `description`, `description_after`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'root', '', '', '', '', '');");
    }
	
	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "sigallery`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "sigallery_description`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "sigallery_image`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "sigallery_image_description`;");
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/sigallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['sigallery_module'])) {
			foreach ($this->request->post['sigallery_module'] as $key => $value) {
				if (!$value['width'] || !$value['height']) {
					$this->error['dimension'][$key] = $this->language->get('error_dimension');
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>