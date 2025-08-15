<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\migrations\v20x;

/**
 * Migration stage 1: Update data
 */
class m1_update_data extends \phpbb\db\migration\migration
{
   /**
    * Assign migration file dependencies for this migration
    *
    * @return array Array of migration files
    * @static
    * @access public
    */
   static public function depends_on()
   {
      return array('\sitesplat\bbmembership\migrations\v10x\m3_initial_config');
   }

   /**
    * Add or update data in the database
    *
    * @return array Array of table data
    * @access public
    */
   public function update_data()
   {
      return array(
         array('custom', array(array($this, 'update_tables'))),
      );
   }

   /**
    * @return null
    * @access public
    */
   public function update_tables()
   {
      $this->bbmembership_package = json_decode($this->config['bbmembership_package'], true);
      $i = 0;
      foreach ($this->bbmembership_package as $key => $value)
      {
         $this->bbmembership_package[$key] += array('id' => ++$i);
      }
      $this->config->set('bbmembership_package', json_encode($this->bbmembership_package));

      $sql = 'SELECT id, mc_gross FROM ' . $this->table_prefix . 'bbmembership';
      $result = $this->db->sql_query($sql);
      while ($row = $this->db->sql_fetchrow($result))
      {
         $membership = $this->bbmembership_package[(int) $row['mc_gross']]['id'];
         $sql = 'UPDATE ' . $this->table_prefix . 'bbmembership SET membership = ' . $membership . ' WHERE id = ' . $row['id'];
         $this->db->sql_query($sql);
      }
   }
}