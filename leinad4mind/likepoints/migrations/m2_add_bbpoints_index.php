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

class m2_add_bbpoints_index extends \phpbb\db\migration\migration
{
    public static function depends_on()
    {
        return array('\leinad4mind\likepoints\migrations\m1_initial_install');
    }

    public function update_schema()
    {
        return array(
            'add_indexes' => array(
                $this->table_prefix . 'bbpoints' => array(
                    'post_id_idx' => array('post_id'),
                ),
                $this->table_prefix . 'posts' => array(
                    'contributors_index' => array('contributors'),
                ),
                $this->table_prefix . 'forums' => array(
                    'per_likes_enabled_index' => array('per_likes_enabled'),
                    'contributors_enabled_index' => array('contributors_enabled'),
                ),
            ),
        );
    }

    public function revert_schema()
    {
        return array(
            'drop_indexes' => array(
                $this->table_prefix . 'bbpoints' => array('post_id_idx'),
                $this->table_prefix . 'posts' => array('contributors_index'),
                $this->table_prefix . 'forums' => array('per_likes_enabled_index', 'contributors_enabled_index'),
            ),
        );
    }
}
