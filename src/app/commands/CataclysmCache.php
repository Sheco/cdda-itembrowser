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
	protected $name = 'cataclysm:cache';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Rebuild the database cache.';


  protected $repo;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(RepositoryInterface $repo)
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
    Cache::flush();
    $this->repo->get("item", "fire");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
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
