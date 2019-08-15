<?php

declare(strict_types=1);

namespace App\DTO;

class Role
{
    /** @var string[] */
    public const SUPPORTED_ROLES = [
        'ROLE_USER',
        'ROLE_ADMIN',
    ];

    /** @var string */
    private $name;

    /**
     * @param string $name
     *
     * @throws \Exception
     */
    public function __construct(string $name)
    {
        if (!in_array($name, self::SUPPORTED_ROLES)) {
            throw new \InvalidArgumentException(sprintf("unsupported role '%s'", $name));
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
