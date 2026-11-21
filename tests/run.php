<?php
// Runs the website tests with the PHPUnit that is installed in the CRM next to it
// (../crm-sales/vendor), without loading the CRM itself. Local use only:
//   php tests/run.php
$crm = dirname(__DIR__, 2).'/crm-sales/vendor';
require dirname(__DIR__).'/vendor/autoload.php';
$map = require $crm.'/composer/autoload_classmap.php';
$prefixes = ['PHPUnit\\', 'SebastianBergmann\\', 'TheSeer\\', 'PharIo\\', 'DeepCopy\\', 'PhpParser\\', 'staabm\\', 'Mockery', 'Hamcrest\\'];
spl_autoload_register(function ($class) use ($map, $prefixes) {
    foreach ($prefixes as $p) {
        if (str_starts_with($class, $p) && isset($map[$class])) {
            require $map[$class];
            return;
        }
    }
});
foreach (['/myclabs/deep-copy/src/DeepCopy/deep_copy.php', '/phpunit/phpunit/src/Framework/Assert/Functions.php', '/hamcrest/hamcrest-php/hamcrest/Hamcrest.php', '/mockery/mockery/library/helpers.php'] as $f) {
    if (is_file($crm.$f)) {
        require_once $crm.$f;
    }
}
exit((new PHPUnit\TextUI\Application)->run(array_merge(['phpunit', '-c', dirname(__DIR__).'/phpunit.xml'], array_slice($argv, 1))));
