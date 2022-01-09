<?php

namespace Joschaefer\Flysystem\Sciebo;

use Sabre\DAV\Client;

class ScieboClient extends Client
{
    /**
     * @param string $node     The node within the Sciebo mesh, e.g. "rwth-aachen"
     * @param string $username The name of the user accessing the storage
     * @param string $password The password of the user accessing the storage
     */
    public function __construct(string $node, string $username, string $password)
    {
        parent::__construct([
            'baseUri' => sprintf('https://%s.sciebo.de/', $node),
            'userName' => $username,
            'password' => $password,
        ]);
    }
}
