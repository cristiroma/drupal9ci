<?php

namespace Drupal\Tests\testing_demo\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\ban\BanIpManager;

/**
 * Tests IP address banning.
 *
 * @group ban
 */
class ExampleFunctionalTest extends BrowserTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  protected static $modules = ['ban'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Tests various user input to confirm correct validation and saving of data.
   *
   * @SuppressWarnings(PHPMD.StaticAccess)
   */
  public function testIpAddressValidation() {
    // Create user.
    $adminUser = $this->drupalCreateUser(['ban IP addresses']);
    $this->drupalLogin($adminUser);
    $this->drupalGet('admin/config/people/ban');
    $connection = \Drupal::service('database');

    // Ban a valid IP address.
    $edit = [];
    $edit['ip'] = '1.2.3.3';
    $this->drupalGet('admin/config/people/ban');
    $this->submitForm($edit, 'Add');
    $ipAddress = $connection->select('ban_ip', 'bi')->fields('bi', ['iid'])->condition('ip', $edit['ip'])->execute()->fetchField();
    $this->assertNotEmpty($ipAddress, 'IP address found in database.');
    $this->assertSession()->pageTextContains('The IP address 1.2.3.3 has been banned.');

    // Try to block an IP address that's already blocked.
    $edit = [];
    $edit['ip'] = '1.2.3.3';
    $this->drupalGet('admin/config/people/ban');
    $this->submitForm($edit, 'Add');
    $this->assertSession()->pageTextContains('This IP address is already banned.');

    // Try to block a reserved IP address.
    $edit = [];
    $edit['ip'] = '255.255.255.255';
    $this->drupalGet('admin/config/people/ban');
    $this->submitForm($edit, 'Add');
    $this->assertSession()->pageTextContains('Enter a valid IP address.');

    // Try to block a reserved IP address.
    $edit = [];
    $edit['ip'] = 'test.example.com';
    $this->drupalGet('admin/config/people/ban');
    $this->submitForm($edit, 'Add');
    $this->assertSession()->pageTextContains('Enter a valid IP address.');

    // Submit an empty form.
    $edit = [];
    $edit['ip'] = '';
    $this->drupalGet('admin/config/people/ban');
    $this->submitForm($edit, 'Add');
    $this->assertSession()->pageTextContains('Enter a valid IP address.');

    // Pass an IP address as a URL parameter and submit it.
    $submitIp = '1.2.3.4';
    $this->drupalGet('admin/config/people/ban/' . $submitIp);
    $this->submitForm([], 'Add');
    $ipAddress = $connection->select('ban_ip', 'bi')->fields('bi', ['iid'])->condition('ip', $submitIp)->execute()->fetchField();
    $this->assertNotEmpty($ipAddress, 'IP address found in database');
    $this->assertSession()->pageTextContains("The IP address $submitIp has been banned.");

    // Test duplicate ip address are not present in the 'blocked_ips' table.
    // when they are entered programmatically.
    $banIp = new BanIpManager($connection);
    $ipAddress = '1.0.0.0';
    $banIp->banIp($ipAddress);
    $banIp->banIp($ipAddress);
    $banIp->banIp($ipAddress);
    $query = $connection->select('ban_ip', 'bip');
    $query->fields('bip', ['iid']);
    $query->condition('bip.ip', $ipAddress);
    $ipCount = $query->execute()->fetchAll();
    $this->assertCount(1, $ipCount);
    $ipAddress = '';
    $banIp->banIp($ipAddress);
    $banIp->banIp($ipAddress);
    $query = $connection->select('ban_ip', 'bip');
    $query->fields('bip', ['iid']);
    $query->condition('bip.ip', $ipAddress);
    $ipCount = $query->execute()->fetchAll();
    $this->assertCount(1, $ipCount);
  }

}
