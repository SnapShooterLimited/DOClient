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

use DigitalOceanV2\Entity\VpcNatGateway as VpcNatGatewayEntity;
use DigitalOceanV2\Exception\ExceptionInterface;

/**
 * @author SnapShooter <support@snapshooter.com>
 */
class VpcNatGateway extends AbstractApi
{
    /**
     * Get all VPC NAT Gateways.
     *
     * @throws ExceptionInterface
     *
     * @return VpcNatGatewayEntity[]
     */
    public function getAll(): array
    {
        $natGateways = $this->get('vpc_nat_gateways');

        return \array_map(function ($natGateway) {
            return new VpcNatGatewayEntity($natGateway);
        }, $natGateways->vpc_nat_gateways ?? []);
    }

    /**
     * Get a VPC NAT Gateway by ID.
     *
     * @param string $id
     *
     * @throws ExceptionInterface
     *
     * @return VpcNatGatewayEntity
     */
    public function getById(string $id): VpcNatGatewayEntity
    {
        $natGateway = $this->get(\sprintf('vpc_nat_gateways/%s', $id));

        return new VpcNatGatewayEntity($natGateway->vpc_nat_gateway);
    }

    /**
     * Create a new VPC NAT Gateway.
     *
     * @param string   $name   A human-readable name for the NAT Gateway
     * @param string   $type   The type of NAT Gateway (PUBLIC)
     * @param string   $region The region slug where the NAT Gateway will be created
     * @param int      $size   The size of the NAT Gateway (1-10)
     * @param array    $vpcs   Array of VPC configurations with vpc_uuid and optional default_gateway
     * @param int|null $udpTimeoutSeconds  UDP timeout in seconds
     * @param int|null $icmpTimeoutSeconds ICMP timeout in seconds
     * @param int|null $tcpTimeoutSeconds  TCP timeout in seconds
     *
     * @throws ExceptionInterface
     *
     * @return VpcNatGatewayEntity
     */
    public function create(
        string $name,
        string $type,
        string $region,
        int $size,
        array $vpcs,
        ?int $udpTimeoutSeconds = null,
        ?int $icmpTimeoutSeconds = null,
        ?int $tcpTimeoutSeconds = null
    ): VpcNatGatewayEntity {
        $data = [
            'name' => $name,
            'type' => $type,
            'region' => $region,
            'size' => $size,
            'vpcs' => $vpcs,
        ];

        if (null !== $udpTimeoutSeconds) {
            $data['udp_timeout_seconds'] = $udpTimeoutSeconds;
        }

        if (null !== $icmpTimeoutSeconds) {
            $data['icmp_timeout_seconds'] = $icmpTimeoutSeconds;
        }

        if (null !== $tcpTimeoutSeconds) {
            $data['tcp_timeout_seconds'] = $tcpTimeoutSeconds;
        }

        $natGateway = $this->post('vpc_nat_gateways', $data);

        return new VpcNatGatewayEntity($natGateway->vpc_nat_gateway);
    }

    /**
     * Update a VPC NAT Gateway.
     *
     * @param string   $id                 The NAT Gateway ID
     * @param string   $name               A human-readable name for the NAT Gateway
     * @param int|null $udpTimeoutSeconds  UDP timeout in seconds
     * @param int|null $icmpTimeoutSeconds ICMP timeout in seconds
     * @param int|null $tcpTimeoutSeconds  TCP timeout in seconds
     *
     * @throws ExceptionInterface
     *
     * @return VpcNatGatewayEntity
     */
    public function update(
        string $id,
        string $name,
        ?int $udpTimeoutSeconds = null,
        ?int $icmpTimeoutSeconds = null,
        ?int $tcpTimeoutSeconds = null
    ): VpcNatGatewayEntity {
        $data = ['name' => $name];

        if (null !== $udpTimeoutSeconds) {
            $data['udp_timeout_seconds'] = $udpTimeoutSeconds;
        }

        if (null !== $icmpTimeoutSeconds) {
            $data['icmp_timeout_seconds'] = $icmpTimeoutSeconds;
        }

        if (null !== $tcpTimeoutSeconds) {
            $data['tcp_timeout_seconds'] = $tcpTimeoutSeconds;
        }

        $natGateway = $this->put(\sprintf('vpc_nat_gateways/%s', $id), $data);

        return new VpcNatGatewayEntity($natGateway->vpc_nat_gateway);
    }

    /**
     * Delete a VPC NAT Gateway.
     *
     * @param string $id
     *
     * @throws ExceptionInterface
     *
     * @return void
     */
    public function remove(string $id): void
    {
        $this->delete(\sprintf('vpc_nat_gateways/%s', $id));
    }
}
