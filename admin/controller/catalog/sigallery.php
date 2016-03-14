<?php 
class ControllerCatalogSigallery extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/sigallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/sigallery');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/sigallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/sigallery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_sigallery->addSigallery($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/sigallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/sigallery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_sigallery->editSigallery($this->request->get['sigallery_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/sigallery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/sigallery');

		if (isset($this->request->post['selected']) && $this->validateDelete($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $sigallery_id) {
				$check = $this->parentValidateDelete($sigallery_id);
				if ($check)
					$this->model_catalog_sigallery->deleteSigallery($sigallery_id);
			}
			if ($check)
			{
				$this->session->data['success'] = $this->language->get('text_success');

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				$this->response->redirect($this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url, 'SSL'),
		);

		$data['add'] = $this->url->link('catalog/sigallery/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/sigallery/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['sigallerys'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$sigallery_total = $this->model_catalog_sigallery->getTotalSigallerys();

		$results = $this->model_catalog_sigallery->getSigallerys($filter_data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/sigallery/update', 'token=' . $this->session->data['token'] . '&sigallery_id=' . $result['sigallery_id'] . $url, 'SSL')
			);

			$data['sigallerys'][] = array(
				'sigallery_id' => $result['sigallery_id'],
				'name'      => $result['title'],	
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'selected'  => isset($this->request->post['selected']) && in_array($result['sigallery_id'], $this->request->post['selected']),				
				'action'    => $action
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_list'] = $this->language->get('text_list');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $sigallery_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/sigallery_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_list'] = $this->language->get('text_list');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_images'] = $this->language->get('tab_images');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_settings'] = $this->language->get('tab_settings');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_description_after'] = $this->language->get('entry_description_after');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_width_popup'] = $this->language->get('entry_width_popup');
		$data['entry_height_popup'] = $this->language->get('entry_height_popup');
		$data['entry_autoplay'] = $this->language->get('entry_autoplay');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_gallery_image'] = $this->language->get('entry_gallery_image');

		$data['type_fade'] = $this->language->get('type_fade');
		$data['type_single'] = $this->language->get('type_single');
		$data['type_multiple'] = $this->language->get('type_multiple');
		$data['type_centerMode'] = $this->language->get('type_centerMode');
		$data['type_grid'] = $this->language->get('type_grid');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_order'] = $this->language->get('help_order');
		$data['help_autoplay'] = $this->language->get('help_autoplay');
		$data['help_popup'] = $this->language->get('help_popup');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_sigallery'] = $this->language->get('button_add_sigallery');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		if (isset($this->error['sigallery_image'])) {
			$data['error_sigallery_image'] = $this->error['sigallery_image'];
		} else {
			$data['error_sigallery_image'] = array();
		}	

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url, 'SSL'),
		);

		if (!isset($this->request->get['sigallery_id'])) { 
			$data['action'] = $this->url->link('catalog/sigallery/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/sigallery/update', 'token=' . $this->session->data['token'] . '&sigallery_id=' . $this->request->get['sigallery_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/sigallery', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['sigallery_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$sigallery_info = $this->model_catalog_sigallery->getSigallery($this->request->get['sigallery_id']);
		}
		else
		{
			$sigallery_info=array();
		}
		$filter_data=array('sort'  => 'sort_order');
		$parents = $this->model_catalog_sigallery->getSigallerys($filter_data);
		$dataset=array();
		foreach ($parents as $id=>&$node) {
			if ($node['parent'] === 0) {
				$tree[$id] = &$node;
			} else {
				$dataset[$node['parent']]['children'][$id]['title'] = &$node['title'];
				$dataset[$node['parent']]['children'][$id]['id'] = &$node['sigallery_id'];
				$dataset[$node['parent']]['children'][$id]['parent'] = &$node['parent'];
			}
		}
		$data['parents']=$dataset;

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($sigallery_info)) {
			$data['keyword'] = $sigallery_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($sigallery_info)) {
			$data['width'] = $sigallery_info['width'];
		} else {
			$data['width'] = 200;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($sigallery_info)) {
			$data['height'] = $sigallery_info['height'];
		} else {
			$data['height'] = 200;
		}
		if (isset($this->request->post['width_popup'])) {
			$data['width_popup'] = $this->request->post['width_popup'];
		} elseif (!empty($sigallery_info)) {
			$data['width_popup'] = $sigallery_info['width_popup'];
		} else {
			$data['width_popup'] = 0;
		}

		if (isset($this->request->post['height_popup'])) {
			$data['height_popup'] = $this->request->post['height_popup'];
		} elseif (!empty($sigallery_info)) {
			$data['height_popup'] = $sigallery_info['height_popup'];
		} else {
			$data['height_popup'] = 0;
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($sigallery_info)) {
			$data['type'] = $sigallery_info['type'];
		} else {
			$data['type'] = 5;
		}

		if (isset($this->request->post['autoplay'])) {
			$data['autoplay'] = $this->request->post['autoplay'];
		} elseif (!empty($sigallery_info)) {
			$data['autoplay'] = $sigallery_info['autoplay'];
		} else {
			$data['autoplay'] = 2000;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($sigallery_info)) {
			$data['sort_order'] = $sigallery_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['parent'])) {
			$data['parent'] = $this->request->post['parent'];
		} elseif (!empty($sigallery_info)) {
			$data['parent'] = $sigallery_info['parent'];
		} else {
			$data['parent'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($sigallery_info)) {
			$data['status'] = $sigallery_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if ($sigallery_info['gallery_image'] != '')
			$data['gallery_image'] = $sigallery_info['gallery_image'];
		else
			$data['gallery_image'] = 'no_image.png';

		if (isset($this->request->post['sigallery-one-image']) && is_file(DIR_IMAGE . $this->request->post['sigallery-one-image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['sigallery-one-image'], 100, 100);
		} elseif (!empty($sigallery_info) && is_file(DIR_IMAGE . $sigallery_info['gallery_image'])) {
			$data['thumb'] = $this->model_tool_image->resize($sigallery_info['gallery_image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['sigallery_image'])) {
			$sigallery_images = $this->request->post['sigallery_image'];
		} elseif (isset($this->request->get['sigallery_id'])) {
			$sigallery_images = $this->model_catalog_sigallery->getSigalleryImages($this->request->get['sigallery_id']);
			$sigallery_descriptions = $this->model_catalog_sigallery->getSigalleryDescription($this->request->get['sigallery_id']);
		} else {
			$sigallery_images = array();
			$sigallery_descriptions = array();
		}

		$data['sigallery_images'] = array();
		$data['sigallery_description'] = array();

		foreach ($sigallery_images as $sigallery_image) {
			if ($sigallery_image['image'] && file_exists(DIR_IMAGE . $sigallery_image['image'])) {
				$image = $sigallery_image['image'];
			} else {
				$image = 'no_image.png';
			}

			$data['sigallery_images'][] = array(
				'sigallery_image_description' => $sigallery_image['sigallery_image_description'],
				'link'                        => $sigallery_image['link'],
				'image'                       => $image,
				'thumb'                       => $this->model_tool_image->resize($image, 100, 100)
			);	
		} 

		foreach ($sigallery_descriptions as $key => $sigallery_description) {
			$data['sigallery_description'][$key] = array(
				'description'         => $sigallery_description['description'],
				'description_after'   => $sigallery_description['description_after'],
				'title'               => $sigallery_description['title'],
				'meta_title'          => $sigallery_description['meta_title'],
				'meta_description'    => $sigallery_description['meta_description'],
				'meta_keyword'        => $sigallery_description['meta_keyword'],
			);	
		}

		$data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);		

		$this->load->model('design/layout');
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/sigallery_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/sigallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['sigallery_description'] as $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'] = $this->language->get('error_name');
			}
		}

		if (isset($this->request->post['sigallery_image'])) {
			foreach ($this->request->post['sigallery_image'] as $sigallery_image_id => $sigallery_image) {
				foreach ($sigallery_image['sigallery_image_description'] as $language_id => $sigallery_image_description) {
				
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete($array) {
		if (in_array(1, $array)) {
			$this->error['warning'] = $this->language->get('error_root');
			return false;
		}
		if (!$this->user->hasPermission('modify', 'catalog/sigallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function parentValidateDelete($sigallery_id) {
		$childs=$this->model_catalog_sigallery->checkDeleteSigallerys($sigallery_id);
		if (count($childs) > 1) {
			$title = "";
			foreach ($childs as $titles) {
				if ($sigallery_id == $titles['id'])
					$parent = $titles['title'];
				else
					$title.= $titles['title'].", ";
			}
			$this->error['warning'] = sprintf($this->language->get('error_parent'), $parent, $title);
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>