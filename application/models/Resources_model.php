<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources_model extends CI_Model {
	
	// Fields
	public $number;
	public $word;

	// Reference Table
	public $table = 'resources';

	// Instance of $this->db
	public $query;	

	public function __construct()
	{
		parent::__construct();
		$this->query = $this->db;
	}

	/**
	 * Save 
	 *
	 */
	public function save()
	{
		$data = [
			'word' => $this->word,
			'number' => $this->number,
			'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
		];

		$this->db->insert($this->table, $data);

		return [
			'id' => $this->db->insert_id(),
			'number' => $this->number,
			'word' => $this->word,
		];
	}

	public function all()
	{
		return $this->db->get($this->table)->result();
	}
}