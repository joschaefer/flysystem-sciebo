<?php

namespace Joschaefer\Flysystem\Sciebo;

use League\Flysystem\WebDAV\WebDAVAdapter;

class ScieboAdapter extends WebDAVAdapter
{
    protected ScieboClient $client;

    public function __construct(
        ScieboClient $client,
        string $prefix = '',
        string $visibilityHandling = self::ON_VISIBILITY_THROW_ERROR,
        bool $manualCopy = false,
        bool $manualMove = false
    ) {
        parent::__construct($client, $prefix, $visibilityHandling, $manualCopy, $manualMove);
    }

    public function getUrl(string $path): ?string
    {
        return $this->client->getPublicSharingUrl($path);
    }
}
