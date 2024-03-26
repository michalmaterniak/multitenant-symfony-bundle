<?php

namespace CommitM\MultiTenant\Multitenancy;

use CommitM\MultiTenant\Multitenancy\Exception\InterfaceTenantAwareNotExist;
use CommitM\MultiTenant\Multitenancy\Exception\TenantClassEntityNotExist;
use CommitM\MultiTenant\Multitenancy\Tenant\TenantConfig;
use CommitM\MultiTenant\Multitenancy\Tenant\TenantFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class TenantsConfiguration
{
    /**
     * @var array|Tenant[] $defaultTenant
     */
    protected array $defaultTenants;

    public function __construct(
        ParameterBag $parameterBag,
        TenantFactory $tenantFactory
    ) {
        $multitenants = $parameterBag->get('multi_tenant');

        foreach ($multitenants['tenants'] ?? [] as $name => $config) {
            switch (false) {
                case class_exists($config['entity']):
                    throw new TenantClassEntityNotExist($config['entity']);
                case interface_exists($config['aware']):
                    throw new InterfaceTenantAwareNotExist($config['aware']);
            }

            $this->defaultTenants[] = $tenantFactory->addTenant(new TenantConfig($name, $config));
        }
    }

    /**
     * @return array|TenantInterface[]
     */
    public function getDefaultTenants(): array
    {
        return $this->defaultTenants;
    }
}
