<?php

/**
 * File related plugin functions
 *
 * @group plugins
 * @since 0.1
 */
class Plugin_Files_Tests extends PHPUnit_Framework_TestCase
{

    /**
     * Check that valid plugins are found
     *
     * @since 0.1
     */
    public function test_get_plugins()
    {
        $plugins = array_keys(yourls_get_plugins());
        $this->assertNotEmpty($plugins);
        
        // Pick one random plugin
        $plugin = $plugins[ array_rand($plugins) ];
        return $plugin;
    }

    /**
     * Check that a random valid plugin file validates as a plugin file
     *
     * @depends test_get_plugins
     * @since 0.1
     */
    public function test_plugin_validate($plugin)
    {
        $this->assertTrue(yourls_validate_plugin_file(YOURLS_PLUGINDIR . '/' . $plugin));
    }

    /**
     * Check that an invalid plugin file does not validate as a plugin file
     *
     * @since 0.1
     */
    public function test_invalid_plugin_validate()
    {
        $plugin = rand_str();
        $this->assertFalse(yourls_validate_plugin_file(YOURLS_PLUGINDIR . '/' . $plugin));
    }

    /**
     * Check that a random valid plugin activates correctly
     *
     * @depends test_get_plugins
     * @since 0.1
     */
    public function test_plugin_activate($plugin)
    {
        $this->assertTrue(yourls_activate_plugin($plugin));
        $this->assertGreaterThan(0, yourls_has_active_plugins());
        $this->assertTrue(yourls_is_active_plugin($plugin));
        return $plugin;
    }

    /**
     * Check that an active plugin does not activate
     *
     * @depends test_get_plugins
     * @since 0.1
     */
    public function test_plugin_activate_twice($plugin)
    {
        $this->assertNotSame(true, yourls_activate_plugin($plugin));
        return $plugin;
    }

    /**
    * Simulate initial plugin loading
    *
    * @depends test_plugin_activate
    * @since 0.1
    */
    public function test_load_plugins($plugin)
    {
        global $ydb;
        
        // at this point, we have a plugin activated
        $this->assertSame($ydb->get_plugins(), array( $plugin ));
        
        // Register a fake plugin to simulate one that was once activated but deleted since
        $fake_plugin = rand_str() . '/plugin.php';
        $ydb->add_plugin($fake_plugin);
        yourls_update_option('active_plugins', $ydb->get_plugins());
        
        // Check that a notice has been triggered to warn about deleted plugin
        $this->assertFalse(yourls_has_action('admin_notices'));
        yourls_load_plugins();
        $this->assertTrue(yourls_has_action('admin_notices'));
        
        // Check only our valid plugin is left registered
        $this->assertSame($ydb->get_plugins(), array( $plugin ));
    }

    /**
     * Check that valid plugin deactivates correctly
     *
     * @depends test_plugin_activate
     * @since 0.1
     */
    public function test_plugin_deactivate($plugin)
    {
        $this->assertTrue(yourls_deactivate_plugin($plugin));
        $this->assertSame(0, yourls_has_active_plugins());
        $this->assertFalse(yourls_is_active_plugin($plugin));
    }

    /**
     * Check that an invalid plugin does not activate
     *
     * @since 0.1
     */
    public function test_invalid_plugin_activate()
    {
        $plugin = rand_str();
        
        $this->assertNotSame(true, yourls_activate_plugin($plugin));
        $this->assertFalse(yourls_is_active_plugin($plugin));
    }

    /**
     * Check that an invalid plugin does not deactivate
     *
     * @since 0.1
     */
    public function test_invalid_plugin_deactivate()
    {
        $plugin = rand_str();
        
        $this->assertFalse(yourls_is_active_plugin($plugin));
        $this->assertNotSame(true, yourls_deactivate_plugin($plugin));
    }
}
