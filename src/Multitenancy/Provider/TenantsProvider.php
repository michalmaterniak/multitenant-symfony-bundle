<?php

namespace CommitM\MultiTenant\Multitenancy\Provider;

use CommitM\MultiTenant\Multitenancy\TenantInterface;
use CommitM\MultiTenant\Multitenancy\TenantsConfiguration;
use Doctrine\ORM\EntityManagerInterface;

class TenantsProvider
{
    /**
     * @var array|TenantInterface[] $tenantsByAwareInterface
     */
    protected array $tenantsByInterfaceAware;

    /**
     * @var array|TenantInterface[] $tenantsByClass
     */
    protected array $tenantsByClass;

    /**
     * @var array|string[] $awares
     */
    protected array $awares;

    public function __construct(
        TenantsConfiguration $tenantsConfiguration,
        protected EntityManagerInterface $entityManager
    ) {
        foreach ($tenantsConfiguration->getDefaultTenants() as $defaultTenant) {
            $this->injectTenant($defaultTenant);
        }
    }

    public function injectTenant(TenantInterface $tenant): void
    {
        $this->tenantsByClass[$tenant->getEntityClass()] = $tenant;
        $this->tenantsByInterfaceAware[$tenant->getInterfaceAware()] = $tenant;
        $this->awares[$tenant->getInterfaceAware()] = true;
    }

    public function hasTenantByClass(string $entityClass): bool
    {
        return isset($this->tenantsByClass[$entityClass]);
    }

    public function getTenantByClass(string $entityClass): TenantInterface
    {
        return $this->tenantsByClass[$entityClass];
    }

    public function hasTenantByInterfaceAware(string $interfaceAware): bool
    {
        return isset($this->tenantsByInterfaceAware[$interfaceAware]);
    }

    public function getTenantByInterfaceAware(string $interfaceAware): TenantInterface
    {
        return $this->tenantsByInterfaceAware[$interfaceAware];
    }

    public function hasAware(string $interface): bool
    {
        return isset($this->awares[$interface]);
    }
}
