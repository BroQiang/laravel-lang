<?php

namespace BroQiang\LaravelLang\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Publish extends Command
{
    protected $signature = 'lang:publish
                            {locales=all : Comma-separated list of, eg: zh_CN,en}
                            {--force : override existing files.}';

    protected $description = 'publish language files to resources directory.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locale = $this->argument('locales');
        $force = $this->option('force') ? 'f' : 'n';

        $sourcePath = base_path('vendor/broqiang/laravel-lang/src/lang');
        $targetPath = base_path('resources/lang/');

        if (!is_dir($targetPath) || !is_writable($targetPath)) {
            return $this->error('The lang path "resources/lang/" does not exist or not writable.');
        }

        $files = [];
        $published = [];

        if ($locale == 'all') {
            $files = $sourcePath.'/*';
            $message = 'all';
        } else {
            foreach (explode(',', $locale) as $filename) {
                $file = $sourcePath.'/'.trim($filename);

                if (!file_exists($file)) {
                    $this->error("lang '$filename' not found.");
                    continue;
                }

                $published[] = $filename;
                $files[] = $file;
            }

            if (empty($files)) {
                return;
            }

            $files = implode(' ', $files);
            $message = json_encode($published);
        }

        $process = new Process("cp -r{$force} $files $targetPath");

        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                return $this->error(trim($buffer));
            }
        });

        $type = ($force == 'f') ? 'overwrite' : 'no overwrite,if wang overwrite,add --force';

        $this->info("published languages <comment>({$type})</comment>: {$message}.");
    }
}
