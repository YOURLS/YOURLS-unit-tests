<?php
if( !defined( 'YOURLS_TESTS_CI' ) || YOURLS_TESTS_CI === false ) {
	define( 'YOURLS_TESTS_CI', true );

	define( 'YOURLS_ABSPATH', dirname( dirname( __FILE__ ) ) );

	define( 'YOURLS_DB_USER', 'root' );
	define( 'YOURLS_DB_PASS', '' );
	define( 'YOURLS_DB_NAME', 'yourls_tests' );
	define( 'YOURLS_DB_HOST', 'localhost' );
	define( 'YOURLS_DB_PREFIX', 'yourls_' );

	define( 'YOURLS_SITE', 'http://localhost/YOURLS' );
	define( 'YOURLS_HOURS_OFFSET', 0 ); 
	define( 'YOURLS_LANG', 'fr_FR' ); 
	define( 'YOURLS_UNIQUE_URLS', true );
	define( 'YOURLS_PRIVATE', true );
	define( 'YOURLS_COOKIEKEY', 'Op@G)SqI~sNQtBqv|8}0(gqM}Ft&g-n&|tVZR2B$' );

	$yourls_user_passwords = array(
	  'yourls' => 'travis-ci-test'
	);

	define( 'YOURLS_URL_CONVERT', 62 );

	$yourls_reserved_URL = array(
		'porn', 'faggot', 'sex', 'nigger', 'fuck', 'cunt', 'dick', 'gay',
	);
}