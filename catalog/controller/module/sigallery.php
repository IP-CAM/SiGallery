<?php  
class ControllerModuleSigallery extends Controller {
	public function index($setting) {
		$this->language->load('module/sigallery'); 

		//$data['heading_title'] = $this->language->get('heading_title');
		$data['heading_title'] = $setting['name'];

		$this->load->model('catalog/sigallery');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');

		if (isset($this->request->get['path_gallery'])) {
			$parts = explode('_', (string)$this->request->get['path_gallery']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['gallery_id'] = $parts[0];
		} else {
			$data['gallery_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		if ($setting['module_type']==1)
		{
			$data['sigallerys'] = array();
			$results = $this->model_catalog_sigallery->getSigallery($setting['gallery']);
			foreach ($results['images'] as $result) {
				if (is_file(DIR_IMAGE . $result['image'])) {
					if (($setting['width_popup']==0)OR($setting['height_popup']==0))
						$popup_image = $result['image'];
					else
						$popup_image = $this->model_tool_image->resize($result['image'], $setting['width_popup'], $setting['height_popup']);
					$data['sigallerys'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
						'popup' => $popup_image
					);
				}
			}
		} else {
			$menu = $this->model_catalog_sigallery->getSigalleryList();
			foreach ($menu as $value) {
				$children_data=false;
				if ($value['gallery'] == $data['gallery_id']) {
					$childs = $this->model_catalog_sigallery->getSigalleryList($value['gallery']);
					foreach ($childs as $child) {
						$children_data[] = array(
							'sigallery_id' => $child['gallery'], 
							'title' => $child['title'], 
							'href' => $this->url->link('information/sigallery', 'path_gallery=' . $value['gallery'] . '_' . $child['gallery'])
						);
					}
				}
				$data['menu'][] = array(
					'gallery'      => $value['gallery'],
					'title'        => $value['title'],
					'children'    => $children_data,
					'href'        => $this->url->link('information/sigallery', 'path_gallery=' . $value['gallery'])
				);
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/sigallery.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/sigallery.tpl', $data);
		} else {
			return $this->load->view('default/template/module/sigallery.tpl', $data);
		}
	}
}
?>