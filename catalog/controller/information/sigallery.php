<?php
class ControllerInformationSigallery extends Controller {
public function index() {
	 
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home')
		);

		$this->language->load('module/sigallery');
		
		$this->load->model('catalog/sigallery');
		$this->load->model('tool/image');
		
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/slick/slick.css');
		$this->document->addStyle('catalog/view/javascript/jquery/slick/slick-theme.css');
		$this->document->addScript('catalog/view/javascript/jquery/slick/slick.min.js');

		$path_gallery = '';

		$parts = explode('_', (string)$this->request->get['path_gallery']);

		foreach ($parts as $path_id) {
			if (!$path_gallery) {
				$path_gallery = (int)$path_id;
			} else {
				$path_gallery .= '_' . (int)$path_id;
			}

			$sigallery_info = $this->model_catalog_sigallery->getSigallery($path_id);

			if ($sigallery_info) {
				$data['breadcrumbs'][] = array(
					'text' => $sigallery_info['descriptions'][0]['title'],
					'href' => $this->url->link('information/sigallery', 'path_gallery=' . $path_gallery)
				);
			}
		}

		$data['sigallerys'] = array();
		$sigallery_id = (int)array_pop($parts);

		$results = $this->model_catalog_sigallery->getSigallery($sigallery_id);

		foreach ($results['childrens'] as $children) {
			if (empty($children['gallery_image'])) {
				$thumb=$this->model_tool_image->resize('no_image.png', $results['settings'][0]['width'], $results['settings'][0]['height']);
			} else {
				$thumb=$this->model_tool_image->resize($children['gallery_image'], $results['settings'][0]['width'], $results['settings'][0]['height']);
			}
			$data['childrens'][]=array(
				'title' => $children['title'],
				'gallery_id' => $children['gallery'],
				'thumb' => $thumb,
				'href' => $this->url->link('information/sigallery', 'path_gallery=' . $this->request->get['path_gallery'] . '_' . $children['gallery'])
				);
		}

		foreach ($results['images'] as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				if (($results['settings'][0]['width_popup']==0)OR($results['settings'][0]['height_popup']==0))
					$popup_image = '/image/'.$result['image'];
				else
					$popup_image = $this->model_tool_image->resize($result['image'], $results['settings'][0]['width_popup'], $results['settings'][0]['height_popup']);
				$data['sigallerys'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $results['settings'][0]['width'], $results['settings'][0]['height']),
					'popup' => $popup_image
				);
			}
		}

		$data['description']=html_entity_decode($results['descriptions'][0]['description'], ENT_QUOTES, 'UTF-8');
		$data['description_after']=html_entity_decode($results['descriptions'][0]['description_after'], ENT_QUOTES, 'UTF-8');
		$data['type']=$results['settings'][0]['type'];
		$data['parameters']='$(".single-item").slick({';
		if ($results['settings'][0]['autoplay']>0){
			$data['parameters'].='infinite: true, slidesToScroll: 1,autoplay: true, autoplaySpeed: 2000, 
			';
		}

		$data['parent']=$results['settings'][0]['parent'];

		if ($results['settings'][0]['type']==3)
		{
			$data['parameters'].='dots: true,
			infinite: false,
			speed: 300,
			dots: true,
			slidesToShow: 4,
			slidesToScroll: 4,
			responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
			]});';
		}
		elseif ($results['settings'][0]['type']==4)
		{
			$data['parameters'].= "centerMode: true,
			centerPadding: '60px',
			slidesToShow: 3,
			dots: true,
			responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 3
				}
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 1
				}
			}
			]});";
		}
		elseif ($results['settings'][0]['type']==1)
		{
			$data['parameters'].= "
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.single-for',
			dots: true,
			centerMode: true,
			focusOnSelect: true
			});
			$('.single-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			asNavFor: '.single-item'
			});";
		}
		elseif ($results['settings'][0]['type']==2)
		{
			$data['parameters'].= " dots: true, fade: true});";
		}
		elseif ($results['settings'][0]['type']==5)
		{
			$data['parameters'].= "});";
		}
		$data['heading_title'] = $results['descriptions'][0]['title'];
		$data['button_back'] = $this->language->get('button_back');

		$this->document->setTitle($results['descriptions'][0]['title']);
		$this->document->setDescription($results['descriptions'][0]['meta_description']);
		$this->document->setKeywords($results['descriptions'][0]['meta_keyword']);
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/sigallery', $data));
	}
}
?>