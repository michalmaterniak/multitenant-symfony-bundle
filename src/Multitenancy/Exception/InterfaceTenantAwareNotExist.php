<?php

namespace CommitM\MultiTenant\Multitenancy\Exception;

class InterfaceTenantAwareNotExist extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct('Tenant\'s aware interface ' . $class .  ' is not exist');
    }
}
