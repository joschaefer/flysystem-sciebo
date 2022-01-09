<?php

namespace Joschaefer\Flysystem\Sciebo;

use League\Flysystem\WebDAV\WebDAVAdapter;

class ScieboAdapter extends WebDAVAdapter
{
    /**
     * @inheritDoc
     */
    public function __construct(ScieboClient $client, $prefix = null, $useStreamedCopy = true)
    {
        parent::__construct($client, 'remote.php/webdav/' . $prefix, $useStreamedCopy);
    }
}
