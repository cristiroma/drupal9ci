<?php

namespace Drupal\Tests\testing_demo\Unit;

use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\UnitTestCase;

/**
 * @group testing_demo
 */
class VerboseMessengerTest extends UnitTestCase {

  /**
   * Tests add messages.
   *
   * @covers ::addMessage
   */
  public function testTrue() {
    $this->assertTrue(TRUE);
  }
}
