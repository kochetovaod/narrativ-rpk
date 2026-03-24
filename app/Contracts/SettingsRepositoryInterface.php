<?php

// app/Contracts/SettingsRepositoryInterface.php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface SettingsRepositoryInterface
{
    public function all(): Collection;

    public function findByKey(string $key): ?array;

    public function getGroup(string $group): array;

    public function clearCache(): void;
}
