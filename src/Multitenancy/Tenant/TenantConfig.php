<?php

namespace CommitM\MultiTenant\Multitenancy\Tenant;

readonly class TenantConfig
{
    protected string $class;

    protected string $property;

    protected string $aware;

    public function __construct(
        protected string $name,
        array            $config
    ){
        $this->class =      $config['entity'];
        $this->property =   $config['property'];
        $this->aware =      $config['aware'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getAware(): string
    {
        return $this->aware;
    }
}
