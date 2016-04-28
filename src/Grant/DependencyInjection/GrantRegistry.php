<?php
namespace Kr\OAuthServerBundle\Grant\DependencyInjection;

use Kr\OAuthServerBundle\Grant\GrantInterface;

class GrantRegistry
{
    /** @var array */
    protected $grants;

    public function __construct()
    {
        $this->grants = [];
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasGrant($type)
    {
        return isset($this->grants[$type]);
    }

    /**
     * @param string $type
     *
     * @return GrantInterface
     */
    public function getGrant($type)
    {
        if(!$this->hasGrant($type)) {
            return null;
        }
        return $this->grants[$type];
    }

    public function addGrant($type, $grant)
    {
        $this->grants[$type] = $grant;
    }
}