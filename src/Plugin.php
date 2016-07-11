<?php
namespace Devedge\KbfsDl;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Util\Filesystem;
use Composer\Util\ProcessExecutor;

class Plugin implements PluginInterface
{

    /**
     * Apply plugin modifications to Composer
     *
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        // this is a bit cheesy, but seems to be the easiest way
        $executor = new ProcessExecutor($io);
        $fs = new Filesystem($executor);

        $composer->getDownloadManager()->setDownloader(
            "kbfs",
            new KbfsDownloader($io, $composer->getConfig(), $executor, $fs)
        );
    }
}
