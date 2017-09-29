<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Handles Page pages
class Page extends CI_Controller {

	/**
	 * Displays Landing Page
	 *
	 * @param
	 * @return view
	 */
	public function index()
	{
		$this->load->model('resources_model','resources');
		$resources = $this->resources->all();
		$views = [
			[
				'template' => 'page/index',
				'data' => [
					'resources' => $resources,
				],
			]
		];

		$this->loadView($views);
	}
}