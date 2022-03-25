<?php

namespace Drupal\Tests\testing_demo\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Sample Kernel test.
 * 
 * @group testing_demo
 */
class AlwaysPassingKernelTest extends KernelTestBase {

  public static $modules = ['system', 'field'];


  /**
   * Always succeed.
   */
  public function testTrue() {
    $this->assertTrue(TRUE);
  }

}
