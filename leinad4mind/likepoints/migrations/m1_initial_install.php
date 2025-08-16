<?php
namespace oreolek\likepoints\migrations;

/**
* Migration 1. Initial installation.
*/
class m1_initial_install extends \phpbb\db\migration\migration
{
  public function update_schema() {
    return array(
      'add_columns'	=> array(
        $this->table_prefix . 'forums'	=> array(
          'likepoints_enabled'	=> array('BOOL', 1),
          'likepoints_amount'	=> array('UINT:2', 10),
        ),
        $this->table_prefix . 'posts'	=> array(
          'kudos'	=> array('VARCHAR:255', ''),
        ),
      )
    );
  }
}
