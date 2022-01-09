<?php

namespace Joschaefer\Flysystem\Sciebo;

use League\Flysystem\WebDAV\WebDAVAdapter;

class ScieboAdapter extends WebDAVAdapter
{
    /**
     * Constructor.
     *
     * @param ScieboClient $client
     * @param null         $prefix
     * @param bool         $useStreamedCopy
     */
    public function __construct(ScieboClient $client, $prefix = null, $useStreamedCopy = true)
    {
        parent::__construct($client, 'remote.php/webdav/' . $prefix, $useStreamedCopy);
    }
}
