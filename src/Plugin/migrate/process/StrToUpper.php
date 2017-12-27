<?php
/**
 * @file
 * Example of how to write a Migrate API process plugin.
 */

// Process plugins live in the Drupal\{MODULE}\Plugin\migrate\process
// namespace.
namespace Drupal\baseball_migration\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin converts a string to uppercase.
 *
 * @MigrateProcessPlugin(
 *   id = "strtoupper"
 * )
 */
class StrToUpper extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // In the transform() method we perform whatever operations our process
    // plugin is going to do in order to transform the $value provided into its
    // desired form, and then return that value.
    if (is_string($value)) {
      // Check the plugin configuration to see if we should be using the ucfirst
      // or strtoupper function to perform our transformation. Configuration is
      // read from the migration YAML file where we've specified that we want
      // this process plugin to be used for a specific field.
      if (isset($this->configuration['ucfirst']) && $this->configuration['ucfirst'] == TRUE) {
        return ucfirst($value);
      }
      else {
        return strtoupper($value);
      }
    }
    else {
      // Throw an exception indicating our process plugin failed to transform
      // this value.
      throw new MigrateException(sprintf('%s is not a string', var_export($value, TRUE)));
    }
  }
}
