<?php

namespace CommitM\MultiTenant\Multitenancy\Exception;

class TenantClassEntityNotExist extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct('Tenant\'s entity ' . $class .  ' is not exist');
    }
}
