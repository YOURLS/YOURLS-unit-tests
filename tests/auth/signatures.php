<?php
/**
 * Tests with signatures
 *
 * @group auth
 * @group signatures
 * @since 0.1
 */
class Auth_Sig_Tests extends PHPUnit_Framework_TestCase
{
    protected $backup_request;
    
    protected function setUp()
    {
        $this->backup_request = $_REQUEST;
    }

    protected function tearDown()
    {
        $_REQUEST = $this->backup_request;
    }
    
    /**
     * Check that empty signature isn't valid
     *
     * @since 0.1
     */
    public function test_signature_empty()
    {
        unset($_REQUEST['signature']);
        $this->assertFalse(yourls_check_signature());
    }

    /**
     * Check that random signature isn't valid
     *
     * @since 0.1
     */
    public function test_signature_random()
    {
        $_REQUEST['signature'] = rand_str();
        $this->assertFalse(yourls_check_signature());
    }

    /**
     * Check that empty signature and timestamp isn't valid
     *
     * @since 0.1
     */
    public function test_signature_timestamp_empty()
    {
        unset($_REQUEST['signature']);
        unset($_REQUEST['timestamp']);
        $this->assertFalse(yourls_check_signature_timestamp());
    }

    /**
     * Check that random signature and timestamp isn't valid
     *
     * @since 0.1
     */
    public function test_signature_timestamp_random()
    {
        $_REQUEST['signature'] = rand_str();
        $_REQUEST['timestamp'] = rand_str();
        $this->assertFalse(yourls_check_signature_timestamp());
    }
    
    /**
     * Provide valid and invalid timestamps as compared to current time and nonce life
     */
    public function timestamps()
    {
        $now = time();
        $little_in_the_future = $now + (YOURLS_NONCE_LIFE / 2);
        $little_in_the_past   = $now - (YOURLS_NONCE_LIFE / 2);
        $far_in_the_future    = $now + (YOURLS_NONCE_LIFE * 2);
        $far_in_the_past      = $now - (YOURLS_NONCE_LIFE * 2);
        
        return array(
            array( 0, false ),
            array( $now, true ),
            array( $little_in_the_future, true ),
            array( $little_in_the_past, true ),
            array( $far_in_the_future, false ),
            array( $far_in_the_past, false ),
        );
    }

    /**
     * Check that timestamps are correctly handled (too old = bad, too future = bad, ...)
     *
     * @since 0.1
     * @dataProvider timestamps
     */
    public function test_check_timestamp($timestamp, $is_valid)
    {
        $this->assertSame(yourls_check_timestamp($timestamp), $is_valid);
    }
}
