<?php
class ModelCatalogSigallery extends Model {
	public function addSigallery($data) {
		$this->event->trigger('pre.admin.sigallery.add', $data);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery` SET 
			`sort_order` = '" . (int)$data['sort_order'] . "', 
			`width` = '" . (int)$data['width'] . "', 
			`height` = '" . (int)$data['height'] . "', 
			`width_popup` = '" . (int)$data['width_popup'] . "', 
			`height_popup` = '" . (int)$data['height_popup'] . "', 
			`type` = '" . (int)$data['type'] . "', 
			`autoplay` = '" . (int)$data['autoplay'] . "', 
			`parent` = '" . (int)$data['parent'] . "', 
			`status` = '" . (int)$data['status'] . "',
			`gallery_image` = '" . $this->db->escape($data['sigallery-one-image']) . "'
			;");

		$sigallery_id = $this->db->getLastId();

		foreach ($data['sigallery_description'] as $key => $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_description` SET 
				`title` = '" . $this->db->escape($value['title']) . "', 
				`description` = '" . $this->db->escape($value['description']) . "', 
				`description_after` = '" . $this->db->escape($value['description_after']) . "', 
				`meta_title` = '" . $this->db->escape($value['meta_title']) . "', 
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "', 
				`meta_keyword` = '" . $this->db->escape($value['meta_keyword']) . "', 
				`sigallery_id` = '" . (int)$sigallery_id . "',
				`language_id` = '".$key."';");
		}

		if (isset($data['sigallery_image'])) {
			foreach ($data['sigallery_image'] as $sigallery_image) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_image` SET `sigallery_id` = '" . (int)$sigallery_id . "', `link` = '" .  $this->db->escape($sigallery_image['link']) . "', `image` = '" .  $this->db->escape($sigallery_image['image']) . "';");

				$sigallery_image_id = $this->db->getLastId();

				foreach ($sigallery_image['sigallery_image_description'] as $language_id => $sigallery_image_description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_image_description` SET `sigallery_image_id` = '" . (int)$sigallery_image_id . "', `language_id` = '" . (int)$language_id . "', `sigallery_id` = '" . (int)$sigallery_id . "', `title` = '" .  $this->db->escape($sigallery_image_description['title']) . "';");
				}
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'sigallery_id=" . (int)$sigallery_id . "', `keyword` = '" . $this->db->escape($data['keyword']) . "';");
		}

		$this->cache->delete('sigallery');

		$this->event->trigger('post.admin.sigallery.add', $sigallery_id);
	}

	public function editSigallery($sigallery_id, $data) {
		$this->event->trigger('pre.admin.sigallery.edit', $data);
		$this->db->query("UPDATE `" . DB_PREFIX . "sigallery` SET 
			`sort_order` = '" . (int)$data['sort_order'] . "', 
			`width` = '" . (int)$data['width'] . "', 
			`height` = '" . (int)$data['height'] . "', 
			`width_popup` = '" . (int)$data['width_popup'] . "', 
			`height_popup` = '" . (int)$data['height_popup'] . "', 
			`type` = '" . (int)$data['type'] . "', 
			`autoplay` = '" . (int)$data['autoplay'] . "', 
			`parent` = '" . (int)$data['parent'] . "', 
			`status` = '" . (int)$data['status'] . "',
			`gallery_image` = '" . $this->db->escape($data['sigallery-one-image']) . "'
		 WHERE `sigallery_id` = '" . (int)$sigallery_id . "'");

		foreach ($data['sigallery_description'] as $key => $value) {
			$this->db->query("UPDATE `" . DB_PREFIX . "sigallery_description` SET 
				`title` = '" . $this->db->escape($value['title']) . "', 
				`description` = '" . $this->db->escape($value['description']) . "', 
				`description_after` = '" . $this->db->escape($value['description_after']) . "', 
				`meta_title` = '" . $this->db->escape($value['meta_title']) . "', 
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "', 
				`meta_keyword` = '" . $this->db->escape($value['meta_keyword']) . "' 
				WHERE `sigallery_id` = '" . (int)$sigallery_id . "' AND `language_id` = '".$key."'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery_image` WHERE `sigallery_id` = '" . (int)$sigallery_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery_image_description` WHERE `sigallery_id` = '" . (int)$sigallery_id . "'");

		if (isset($data['sigallery_image'])) {
			foreach ($data['sigallery_image'] as $sigallery_image) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_image` SET `sigallery_id` = '" . (int)$sigallery_id . "', link = '" .  $this->db->escape($sigallery_image['link']) . "', image = '" .  $this->db->escape($sigallery_image['image']) . "'");

				$sigallery_image_id = $this->db->getLastId();

				foreach ($sigallery_image['sigallery_image_description'] as $language_id => $sigallery_image_description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_image_description` SET `sigallery_image_id` = '" . (int)$sigallery_image_id . "', language_id = '" . (int)$language_id . "', sigallery_id = '" . (int)$sigallery_id . "', title = '" .  $this->db->escape($sigallery_image_description['title']) . "'");
				}
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'sigallery_id=" . (int)$sigallery_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'sigallery_id=" . (int)$sigallery_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('sigallery');

		$this->event->trigger('post.admin.sigallery.edit', $sigallery_id);

	}

	public function checkDeleteSigallerys($sigallery_id) {
		$query = $this->db->query("SELECT  `title`, `i`.`sigallery_id` AS `id`
								FROM  `" . DB_PREFIX . "sigallery`  `i` 
								LEFT JOIN  `" . DB_PREFIX . "sigallery_description`  `id` ON (  `i`.`sigallery_id` =  `id`.`sigallery_id` ) 
								WHERE  `id`.`language_id` =  '" . (int)$this->config->get('config_language_id') . "'
								AND  `parent` =  '".(int)$sigallery_id."'
								OR  `i`.`sigallery_id` =  '".(int)$sigallery_id."'
								ORDER BY `i`.`sigallery_id` DESC");

		return $query->rows;
	}

	public function deleteSigallery($sigallery_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery` WHERE `sigallery_id` = '" . (int)$sigallery_id . "';");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery_image` WHERE `sigallery_id` = '" . (int)$sigallery_id . "';");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery_image_description` WHERE `sigallery_id` = '" . (int)$sigallery_id . "';");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery_description` WHERE `sigallery_id` = '" . (int)$sigallery_id . "';");
	}

	public function getSigallery($sigallery_id) {
		//$query = $this->db->query("SELECT DISTINCT *, (SELECT `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'sigallery_id=" . (int)$sigallery_id . "') AS `keyword` FROM `" . DB_PREFIX . "sigallery` WHERE `sigallery_id` = '" . (int)$sigallery_id . "'");
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.title ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "sigallery_path cp LEFT JOIN " . DB_PREFIX . "sigallery_description cd1 ON (cp.path_id = cd1.sigallery_id AND cp.sigallery_id != cp.path_id) WHERE cp.sigallery_id = c.sigallery_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.sigallery_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'sigallery_id=" . (int)$sigallery_id . "') AS keyword FROM " . DB_PREFIX . "sigallery c LEFT JOIN " . DB_PREFIX . "sigallery_description cd2 ON (c.sigallery_id = cd2.sigallery_id) WHERE c.sigallery_id = '" . (int)$sigallery_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function repairSigallery($parent_id = 0) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sigallery WHERE parent = '" . (int)$parent_id . "'");

		foreach ($query->rows as $sigallery) {

			$this->db->query("DELETE FROM `" . DB_PREFIX . "sigallery_path` WHERE sigallery_id = '" . (int)$sigallery['sigallery_id'] . "'");

			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "sigallery_path` WHERE sigallery_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "sigallery_path` SET sigallery_id = '" . (int)$sigallery['sigallery_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "sigallery_path` SET sigallery_id = '" . (int)$sigallery['sigallery_id'] . "', `path_id` = '" . (int)$sigallery['sigallery_id'] . "', level = '" . (int)$level . "'");

			$this->repairSigallery($sigallery['sigallery_id']);
		}
	}

	public function getSigallerys($data = array()) {
		$parent_id =0;

		$sql = "SELECT 
			`cp`.`sigallery_id` AS `sigallery_id`, 
			GROUP_CONCAT(`cd1`.`title` ORDER BY `cp`.`level` SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS `title`, 
			`c1`.`parent`, `c1`.`sort_order`, `c1`.`status`
		FROM " . DB_PREFIX . "sigallery_path cp LEFT JOIN " . DB_PREFIX . "sigallery c1 
			ON (cp.sigallery_id = c1.sigallery_id) LEFT JOIN " . DB_PREFIX . "sigallery c2 
			ON (cp.path_id = c2.sigallery_id) LEFT JOIN " . DB_PREFIX . "sigallery_description cd1 
			ON (cp.path_id = cd1.sigallery_id) LEFT JOIN " . DB_PREFIX . "sigallery_description cd2 
			ON (cp.sigallery_id = cd2.sigallery_id) 
		WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.sigallery_id";

		$sort_data = array(
			'status'
		);

		if (isset($data['where'])) {
			$sql .= " AND ".$data['where'];
		}
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY `parent`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}


		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		//echo $sql;
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAllSigallerys() {
		$sql = "SELECT `i`.`sigallery_id`,`title`,`parent` FROM `" . DB_PREFIX . "sigallery` `i` LEFT JOIN `" . DB_PREFIX . "sigallery_description` `id` ON (`i`.`sigallery_id` = `id`.`sigallery_id`) WHERE `id`.`language_id` = '" . (int)$this->config->get('config_language_id') . "';";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getSigalleryImages($sigallery_id) {
		$sigallery_image_data = array();

		$sigallery_image_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "sigallery_image` WHERE `sigallery_id` = '" . (int)$sigallery_id . "'");

		foreach ($sigallery_image_query->rows as $sigallery_image) {
			$sigallery_image_description_data = array();

			$sigallery_image_description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "sigallery_image_description` WHERE `sigallery_image_id` = '" . (int)$sigallery_image['sigallery_image_id'] . "' AND `sigallery_id` = '" . (int)$sigallery_id . "';");

			foreach ($sigallery_image_description_query->rows as $sigallery_image_description) {
				$sigallery_image_description_data[$sigallery_image_description['language_id']] = array('title' => $sigallery_image_description['title']);
			}

			$sigallery_image_data[] = array(
				'sigallery_image_description' => $sigallery_image_description_data,
				'link'                        => $sigallery_image['link'],
				'image'                       => $sigallery_image['image']
			);
		}

		return $sigallery_image_data;
	}

	public function getSigalleryDescription($sigallery_id) {
		$sigallery_data = array();
		$sigallery_description_data = array();

		$sigallery_description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "sigallery_description` WHERE `sigallery_id` = '" . (int)$sigallery_id . "';");

		foreach ($sigallery_description_query->rows as $sigallery_description) {			
			$sigallery_description_data[$sigallery_description['language_id']] = array(
				'title'                          => $sigallery_description['title'],
				'meta_title'                     => $sigallery_description['meta_title'],
				'meta_description'               => $sigallery_description['meta_description'],
				'meta_keyword'                   => $sigallery_description['meta_keyword'],
				'description'                    => $sigallery_description['description'],
				'description_after'              => $sigallery_description['description_after']);
		}

		return $sigallery_description_data;
	}

	public function getTotalSigallerys() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sigallery");

		return $query->row['total'];
	}

}
?>