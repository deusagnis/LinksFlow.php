<?php

namespace MGGFLOW\LinksFlow\Interfaces;

interface LinkData
{
    /**
     * Returns true if Link exists by alias.
     * @param string $alias
     * @return bool
     */
    public function existsByAlias(string $alias): bool;

    /**
     * Create Link.
     * @param object $link
     * @return mixed
     */
    public function createLink(object $link);

    /**
     * Update Link by id.
     * @param int $id
     * @param object $link
     * @return mixed
     */
    public function updateById(int $id, object $link);

    /**
     * Get Link by alias.
     * @param string $alias
     * @return mixed
     */
    public function getByAlias(string $alias);

    /**
     * Remove Link by id.
     * @param int $id
     * @return mixed
     */
    public function removeById(int $id);
}