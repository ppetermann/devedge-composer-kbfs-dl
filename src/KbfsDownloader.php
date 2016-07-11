<?php
namespace Devedge\KbfsDl;

use Composer\Downloader\DownloaderInterface;
use Composer\Downloader\FileDownloader;
use Composer\Downloader\PathDownloader;
use Composer\Package\PackageInterface;

class KbfsDownloader extends PathDownloader implements DownloaderInterface
{

}
