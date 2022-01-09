<?php

namespace Joschaefer\Flysystem\Sciebo;

use League\Flysystem\WebDAV\WebDAVAdapter;

class ScieboAdapter extends WebDAVAdapter
{
    protected $client;

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

    public function getUrl(string $path)
    {
        return $this->client->getPublicSharingUrl($path);
    }
}
