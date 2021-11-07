<?php

namespace MGGFLOW\LinksFlow\Interfaces;

interface LinkData
{
    public function existsByAlias(string $alias): bool;

    public function createLink(object $link);

    public function updateById(int $id, object $link);

    public function getByAlias(string $alias);

    public function removeById(int $id);

    public function findByOwnerId(int $ownerId, int $count, int $offset);
}