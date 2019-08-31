<?php

return PhpCsFixer\Config::create()
  ->setUsingCache(false)
  ->setRiskyAllowed(true)
  ->setRules([
    '@PSR1' => true,
    '@PSR2' => true,
    'psr4' => true,
  ])
  ->setFinder(PhpCsFixer\Finder::create()
    ->in(__DIR__ )
    ->in(__DIR__ . '/data')
    ->in(__DIR__ . '/includes')
    ->in(__DIR__ . '/tests')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true));
