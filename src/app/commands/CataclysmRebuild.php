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
    $this->info("rebuilding database cache...");
    $this->repo->compile($this->argument('path'), $this->option('adhesion'));
    \Cache::flush();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
    $path = \Config::get('cataclysm.dataPath');
		return array(
      array('path', InputArgument::OPTIONAL, 'Path to the game files', $path)
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
      array('adhesion', 'a', InputOption::VALUE_OPTIONAL, "Chunk adhesion, reduces the amount of files created", 100)
		);
	}

}
