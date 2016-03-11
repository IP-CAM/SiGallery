<?php
class ModelCatalogSigallery extends Model {	
	public function getSigallery($sigallery_id) {
		$settings = $this->db->query("SELECT * FROM " . DB_PREFIX . "sigallery WHERE sigallery_id = '" . (int)$sigallery_id . "';");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sigallery_image gi LEFT JOIN " . DB_PREFIX . "sigallery_image_description gid ON (gi.sigallery_image_id  = gid.sigallery_image_id) WHERE gi.sigallery_id = '" . (int)$sigallery_id . "' AND gid.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		$sigallery_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "sigallery_description WHERE " . DB_PREFIX . "sigallery_description.sigallery_id = '" . (int)$sigallery_id . "' AND " . DB_PREFIX . "sigallery_description.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		$sigallery_children = $this->db->query("SELECT `title`, `".DB_PREFIX."sigallery`.`sigallery_id` AS `gallery`,  `gallery_image`
		FROM `".DB_PREFIX."sigallery_description` LEFT JOIN `".DB_PREFIX."sigallery` ON `".DB_PREFIX."sigallery_description`.`sigallery_id` = `".DB_PREFIX."sigallery`.`sigallery_id` 
		WHERE `".DB_PREFIX."sigallery`.`parent` = '" . (int)$sigallery_id . "' 
			AND `".DB_PREFIX."sigallery_description`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' 
			AND `".DB_PREFIX."sigallery`.`status`=1 ORDER BY `sort_order` ASC;");

		$sigallery=array(
			'settings' => $settings->rows,
			'descriptions' => $sigallery_description->rows,
			'images' => $query->rows,
			'childrens' => $sigallery_children->rows);
		return $sigallery;
	}

	public function getSigalleryList($parent=1) {
				$sigallery_children = $this->db->query("SELECT `title`, `".DB_PREFIX."sigallery`.`sigallery_id` AS `gallery`,  `gallery_image`
		FROM `".DB_PREFIX."sigallery_description` LEFT JOIN `".DB_PREFIX."sigallery` ON `".DB_PREFIX."sigallery_description`.`sigallery_id` = `".DB_PREFIX."sigallery`.`sigallery_id` 
		WHERE  `".DB_PREFIX."sigallery`.`parent`=".$parent." AND `".DB_PREFIX."sigallery_description`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' 
			AND `".DB_PREFIX."sigallery`.`status`=1 ORDER BY `sort_order` ASC;");

		return $sigallery_children->rows;
	}
}
?>