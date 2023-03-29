<?php

namespace DigitalOceanV2\Entity;

final class KubernetesCluster extends AbstractEntity
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $region;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $clusterSubnet;

    /**
     * @var string
     */
    public $serviceSubnet;

    /**
     * @var string
     */
    public $vpcUuid;

    /**
     * @var string
     */
    public $ipv4;

    /**
     * @var string
     */
    public $endpoint;

    /**
     * @var string[]
     */
    public $tags  = [];


    /**
     * @param string $createdAt
     *
     * @return void
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = static::convertToIso8601($createdAt);
    }
}