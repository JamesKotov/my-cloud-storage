<?php

abstract class StorageApi {

	protected $container;
	protected $oFolder;
	protected $oFile;
	protected $isError;

	public function __construct($container) {
		$this->container = $container;
		$this->oFolder = FolderQuery::create()->findPK(0);
		$this->oFile = null;
		$this->isError = false;
	}

	public function parseUrl($path) {
		$aPath = array_filter(explode('/', trim($path, '/')));

		$oFile = null;

		$iParentId = 0;

		if (sizeof($aPath))
		{
			foreach ($aPath as $index => $sPathItem)
			{
				$this->oFolder = FolderQuery::create()
					->filterByName($sPathItem)
					->filterByParentId($iParentId)
					->findOne();

				// Found
				if (!is_null($this->oFolder))
				{
					$iParentId = $this->oFolder->getId();
				} else
				{
					// Stop search if folder not found
					$index--;
					$this->oFolder = FolderQuery::create()->findPK($iParentId);
					break;
				}
			}
			$aPath = array_slice($aPath, $index + 1);

			if (sizeof($aPath) > 1)
			{
				$this->isError = true;
			}

			if (sizeof($aPath) === 1)
			{
				// try to find a file
				$this->oFile = FileQuery::create()
					->filterByName($aPath[0])
					->filterByFolderId($this->oFolder->getId())
					->findOne();

				if (is_null($this->oFile))
				{
					$this->isError = true;
				}
			}
		} else
		{
			$this->oFolder = FolderQuery::create()->findPK($iParentId);
		}
	}

	public function __invoke($request, $response, $args) {
		$this->parseUrl(isset($args['path']) ? $args['path'] : '');
	}
}
