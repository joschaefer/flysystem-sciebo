<?php

namespace Joschaefer\Flysystem\Sciebo;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Sabre\DAV\Client;

class ScieboClient extends Client
{
    protected string $node;

    /**
     * Constructor.
     *
     * @param string $node     The node within the Sciebo mesh, e.g. "rwth-aachen"
     * @param string $username The name of the user accessing the storage
     * @param string $password The password of the user accessing the storage
     */
    public function __construct(string $node, string $username, string $password)
    {
        $this->node = sprintf('https://%s.sciebo.de/', $node);

        parent::__construct([
            'baseUri' => $this->node . 'remote.php/webdav/',
            'userName' => $username,
            'password' => $password,
        ]);
    }

    public function getPublicSharingUrl(string $path): ?string
    {
        $guzzle = new HttpClient([
            'base_uri' => $this->node,
            'auth' => explode(':', $this->curlSettings['10005']),
            'headers' => ['OCS-APIRequest' => 'true'],
        ]);

        try {
            $response = $guzzle->post('ocs/v1.php/apps/files_sharing/api/v1/shares', [
                'form_params' => [
                    'path' => $path,
                    'shareType' => 3,
                    'permissions' => 1
                ],
            ])->getBody()->getContents();
        } catch(GuzzleException $e) {
            return null;
        }

        if (!preg_match('/<url>([^<]+)<\/url>/', $response, $matches)) {
            return null;
        }

        return $matches[1];
    }
}
