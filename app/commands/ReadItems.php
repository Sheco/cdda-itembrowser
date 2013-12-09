<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReadItems extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'dda:items';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Parse DDA items.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}



	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
    Items::setup();
    Recipes::setup();

    $item = Items::get('needle_bone');
    print_r($item); 
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
    return array(
      array("name", InputArgument::REQUIRED, "Item name")    
    );
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
    return array();
	}

}
