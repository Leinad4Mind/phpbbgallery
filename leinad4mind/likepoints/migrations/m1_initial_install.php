<?php

/**
 *
 * LikePoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
 * @license Proprietary
 *
 */

namespace leinad4mind\likepoints\migrations;

/**
 * Migration 1. Initial installation.
 */
class m1_initial_install extends \phpbb\db\migration\migration
{
    /**
     * Schema changes to apply when installing the extension.
     */
    public function update_schema()
    {
        return array(
            'add_columns' => array(
                $this->table_prefix . 'forums' => array(
                    'per_likes_enabled'    => array('BOOL', 1),
                    'contributors_enabled' => array('BOOL', 1),
                    'per_likes_amount'     => array('UINT:2', 10),
                ),
                $this->table_prefix . 'posts' => array(
                    'contributors' => array('VCHAR:255', ''),
                ),
                $this->table_prefix . 'bbpoints' => array(
                    'post_id' => array('INT:11', 0),
                ),
            ),
        );
    }

    /**
     * Schema changes to revert when uninstalling the extension.
     */
    public function revert_schema()
    {
        return array(
            'drop_columns' => array(
                $this->table_prefix . 'forums' => array(
                    'per_likes_enabled',
                    'contributors_enabled',
                    'per_likes_amount',
                ),
                $this->table_prefix . 'posts' => array(
                    'contributors',
                ),
                $this->table_prefix . 'bbpoints' => array(
                    'post_id',
                ),
            ),
        );
    }
}
