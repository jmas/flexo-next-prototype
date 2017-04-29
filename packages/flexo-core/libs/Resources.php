<?php

namespace Flexo\Core;
use Symfony\Component\Filesystem\Filesystem;

class Resources {
	protected $paths = [];
	protected $publicPath;
	protected $publicUrl;
	protected $fs;

	public function __construct(array $paths, string $publicPath, string $publicUrl)
	{
		$this->paths = $paths;
		$this->publicPath = $publicPath;
		$this->publicUrl = $publicUrl;
		$this->fs = new Filesystem();
	}

	public function makePublicUrl($path)
	{
		$filePublicPath = $this->getPublicFilePath($path);
		if (!$this->isPublic($path)) {
			$isFound = false;
			foreach ($this->paths as $localPath) {
				$filePath = $localPath . DIRECTORY_SEPARATOR . $path;
				if (file_exists($filePath)) {
					$this->fs->copy($filePath, $filePublicPath, true);
					$isFound = true;
					break;
				}
			}
			if (!$isFound) {
				return null;
			}
		}
		return $this->publicUrl . '/' . $this->normalizePath($path, '/');
	}

	public function isPublic($path)
	{
		return $this->fs->exists($this->getPublicFilePath($path));
	}

	public function removePublic($path)
	{

	}

	public function getContent($path)
	{

	}

	public function getPublicFilePath($path)
	{
		return $this->publicPath . DIRECTORY_SEPARATOR . $this->normalizePath($path);
	}

	protected function normalizePath($path, $separator=DIRECTORY_SEPARATOR)
	{
		return preg_replace('/[\\\\\/]/', $separator, preg_replace('/^[\.\/\\\\]+/', '', $path));
	}
}
