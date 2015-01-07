<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Repositories\Indexers;

class CataclysmCache extends Command
{
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
     * @return mixed
     */
    public function fire()
    {
        $this->info("rebuilding database cache...");
        \Cache::flush();

        $this->registerIndexers();

        $localreader = new Repositories\LocalRepository($this->argument('path'));

        $repo = new Repositories\CacheRepository;
        $repo->compile($localreader);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('path', InputArgument::REQUIRED, 'Path to the game files'),
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

    private function registerIndexers()
    {
        //TODO: find a way to find the indexers automatically
        // instead of hardcoding them here.
        $this->registerIndexer(new Indexers\Item());
        $this->registerIndexer(new Indexers\Material());
        $this->registerIndexer(new Indexers\Recipe());
        $this->registerIndexer(new Indexers\Quality());
        $this->registerIndexer(new Indexers\Monster());
        $this->registerIndexer(new Indexers\MonsterGroup());
    }

    private function registerIndexer(Indexers\IndexerInterface $indexer)
    {
        \Event::listen('cataclysm.newObject',
            array($indexer, 'onNewObject'));

        \Event::listen('cataclysm.finishedLoading',
            array($indexer, 'onFinishedLoading'));
    }
}
