<?php

namespace CommitM\MultiTenant\Multitenancy\Tenant;

use CommitM\MultiTenant\Doctrine\Filter\TenantFilter;
use CommitM\MultiTenant\Multitenancy\TenantInterface;
use Doctrine\ORM\EntityManagerInterface;

class TenantFactory
{
    protected TenantFilter $tenantFilter;

    public function __construct(protected EntityManagerInterface $entityManager)
    {}

    protected function createTenant(TenantConfig $tenantConfig): TenantInterface
    {
        return new Tenant($tenantConfig);
    }

    public function addTenant(TenantConfig $tenantConfig): TenantInterface
    {
        $tenant = $this->createTenant($tenantConfig);

        $this->entityManager->getConfiguration()->addFilter($tenantConfig->getName(), TenantFilter::class);
        $this->tenantFilter = $this->entityManager->getFilters()->enable($tenantConfig->getName());
        $this->tenantFilter->setTenant($tenant);

        return $tenant;
    }
}
