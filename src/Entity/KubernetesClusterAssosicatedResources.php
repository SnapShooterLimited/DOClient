<?php

namespace DigitalOceanV2\Entity;

class KubernetesClusterAssosicatedResources extends AbstractEntity
{
    public $volumes;
    public $loadBalancers;
    public $volumeSnapshots;
}