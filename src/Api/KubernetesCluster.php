<?php

declare(strict_types=1);

/*
 * This file is part of the DigitalOcean API library.
 *
 * (c) Antoine Kirk <contact@sbin.dk>
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOceanV2\Api;

use DigitalOceanV2\Entity\KubernetesCluster as KubernetesClusterEntity;

use DigitalOceanV2\Entity\KubernetesClusterAssosicatedResources;
use DigitalOceanV2\Exception\ExceptionInterface;

/**
 * @author Simon Bennett <simon@digitalocean.com>
 */
class KubernetesCluster extends AbstractApi
{
    /**
     * @throws ExceptionInterface
     *
     * @return KubernetesClusterEntity[]
     */
    public function getAllClusters()
    {
        $clusters = $this->get('kubernetes/clusters');

        return \array_map(function ($cluster) {
            return new KubernetesClusterEntity($cluster);
        }, $clusters->kubernetes_clusters);
    }

    /**
     * @param string $id
     *
     * @throws ExceptionInterface
     *
     * @return KubernetesClusterEntity
     */
    public function getClusterById(string $id)
    {
        $cluster = $this->get(\sprintf('kubernetes/clusters/%s', $id));

        return new KubernetesClusterEntity($cluster->kubernetes_cluster);
    }

    /**
     * @param string $id
     *
     * @throws ExceptionInterface
     *
     * @return string
     */
    public function getClusterKubeConfigById(string $id)
    {
        $cluster = $this->get(\sprintf('kubernetes/clusters/%s/kubeconfig', $id));

        return $cluster->kubeconfig;
    }
    public function getAssociatedResourcesById(string $id)
    {
        $resources = $this->get(\sprintf('kubernetes/clusters/%s/destroy_with_associated_resources', $id));

        return new KubernetesClusterAssosicatedResources($resources);
    }

}
