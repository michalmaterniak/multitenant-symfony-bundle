<?php

namespace CommitM\MultiTenant\Multitenancy\Exception;

class TenantNotExist extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct('Tenant ' . $class .  ' is not exist');
    }
}
