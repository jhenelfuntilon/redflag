<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends CI_Controller {
	
	/**
	 * List of the resource
	 *
	 * @param
	 * @return json
	 */
	public function index()
	{
		$this->load->model('resources_model','resources');

		$query = $this->resources->query;

		if ($this->input->get('word') && !empty($this->input->get('word'))) {
			$query = $query->where('word', $this->input->get('word'));
		}

		if ($this->input->get('number') && !empty($this->input->get('number'))) {
			$query = $query->where('number', $this->input->get('number'));
		}

		$query = $query->get($this->resources->table);
		$data = [
			'data' => $query->result_array(),
		];
		
		return $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * Handles Create form for the resource
	 *
	 * @param 
	 * @return view
	 */
	public function create()
	{
		$views = [
			[
				'template' => 'resources/create',
				'data' => []
			]
		];
		$this->loadView($views);
	}

	/**
	 * Store Resource
	 *
	 * @param object post
	 * @return json
	 */
	public function store()
	{
		$this->load->library('form_validation');
		$validation = $this->form_validation;

		$validation->set_data([
			'word' => $this->input->post('word'),
			'number' => $this->input->post('number')
		]);

		$validation->set_rules('word', 'Word', 'required|is_unique[resources.word]');
		$validation->set_rules('number', 'Number', 'required|numeric|max_length[11]|is_unique[resources.number]');

		if ($validation->run() === FALSE) {
			return $this->output
				->set_status_header(400)
				->set_content_type('application/json')
				->set_output(json_encode(['message' => validation_errors()]));
		}

		
		$this->load->model('resources_model','resources');

		// Do create resource
		$this->resources->number = $this->input->post('number');
		$this->resources->word = $this->input->post('word');

		$resource = ['data' => $this->resources->save()];

		return $this->output
			->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($resource));
	}
}