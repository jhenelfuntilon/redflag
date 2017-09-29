<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faker extends CI_Controller {
	
	private $faker;

	public function __construct()
	{
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			$this->output
				->set_status_header(403)
				->set_output('Action not allowed');
			exit;	
		}
		// initiate faker
        $this->faker = Faker\Factory::create();
	}

	/**
	* Geneate Faker Data
	*
	* @param int $rows
	* @return void
	*/
	public function generate($rows = 5)
	{
		if ((int) $rows) {
			if ($rows > 20) {
				echo 'Faker only allow not more 20 fakers' . PHP_EOL;
				exit;
			}
			$this->load->model('resources_model','resources');
			
			for ($i=0; $i < $rows; $i++) { 
				$this->resources->number = $this->faker->randomNumber(NULL, true);
				$this->resources->word = $this->faker->unique()->word();
				$this->resources->save();
			}
			echo 'Faker successfully added ' . (int) $rows . ' records.' . PHP_EOL;
			exit;
		} else {
			echo 'Invalid command. Faker generate must follow with a number.' . PHP_EOL;
			exit;
		}
	}
}