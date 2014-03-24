<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Repositories\RepositoryInterface;

class CataclysmCache extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cataclysm:rebuild';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Compile the database.';


  protected $repo;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Repositories\CompiledReader $repo)
  {
    $this->repo = $repo;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
    echo "rebuilding database cache...\n";
    $this->repo->compile($this->argument('path'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
      array('path', InputArgument::REQUIRED, 'Path to the game files')
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
