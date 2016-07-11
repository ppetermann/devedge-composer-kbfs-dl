<?php
namespace Devedge\KbfsDl;

use Composer\Config;
use Composer\Downloader\DownloaderInterface;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Util\Filesystem;
use Composer\Util\Platform;

/**
 * Downloader interface.
 * @author Peter Petermann
 */
class KbfsDownloader implements DownloaderInterface
{
    protected $filesystem;
    /**
     * @var IOInterface
     */
    private $io;
    /**
     * @var Config
     */
    private $config;

    /**
     * KbfsDownloader constructor.
     * @param IOInterface $io
     * @param Config $config
     */
    public function __construct(IOInterface $io, Config $config)
    {
        $this->io = $io;
        $this->config = $config;
        $this->filesystem = new Filesystem();
    }

    /**
     * Returns installation source (either source or dist).
     *
     * @return string "source" or "dist"
     */
    public function getInstallationSource()
    {
        return "dist";
    }

    /**
     * Downloads specific package into specific folder.
     *
     * @param PackageInterface $package package instance
     * @param string $path download path
     * @throws \Exception
     * @todo make the error reporting more composer like
     */
    public function download(PackageInterface $package, $path)
    {
        if (Platform::isWindows()) {
            throw new \Exception("the kbfs plugin does not support windows yet");
        }
        $archiveName = "/keybase/public/" . $package->getDistUrl();

        if (!file_exists($archiveName)) {
            throw new \Exception("archive not found: $archiveName");
        }

        // extract the archive
        $archive = new \PharData($archiveName);
        $archive->extractTo($path, null, true);
    }

    /**
     * Updates specific package in specific folder from initial to target version.
     *
     * @param PackageInterface $initial initial package
     * @param PackageInterface $target updated package
     * @param string $path download path
     */
    public function update(PackageInterface $initial, PackageInterface $target, $path)
    {
        $this->remove($initial, $path);
        $this->download($target, $path);
    }


    /**
     * Removes specific package from specific folder.
     *
     * @param PackageInterface $package package instance
     * @param string $path download path
     */
    public function remove(PackageInterface $package, $path)
    {
        $this->io->writeError("  - Removing <info>" . $package->getName() . "</info> (<comment>" . $package->getFullPrettyVersion() . "</comment>)");
        if (!$this->filesystem->removeDirectory($path)) {
            throw new \RuntimeException('Could not completely delete '.$path.', aborting.');
        }
    }

    /**
     * Sets whether to output download progress information or not
     *
     * @param  bool $outputProgress
     * @return DownloaderInterface
     */
    public function setOutputProgress($outputProgress)
    {
        return $this;
    }
}
