<?php

namespace Soloist\Bundle\BlockBundle\EventListener;

final class BlockEvents
{
    /**
     * The soloist_block.request_types event is thrown when retrieving all block types.
     * Used in the "Manage blocks" back-office
     *
     * @var string
     */
    const onRequestTypes = 'soloist_block.request_types';
}
