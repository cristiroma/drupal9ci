<?php

namespace Drupal\Tests\testing_demo\Unit;

use Drupal\Tests\UnitTestCase;

/**
 * Sample unit test.
 *
 * @group testing_demo
 */
class AlwaysPassingUnitTest extends UnitTestCase {

  /**
   * Always succeed.
   */
  public function testTrue() {
    $this->assertTrue(TRUE);
  }

}
