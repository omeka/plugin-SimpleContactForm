<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2014
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContact
 */

require_once 'SimpleContact_IntegrationHelper.php';

/**
 * Test suite for SimpleContact.
 *
 * @package SimpleContact
 * @copyright Center for History and New Media, 2007-2014
 */
class SimpleContact_AllTests extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new SimpleContact_AllTests('SimpleContact Tests');
        $testCollector = new PHPUnit_Runner_IncludePathTestCollector(
          array(dirname(__FILE__) . '/cases')
        );
        $suite->addTestFiles($testCollector->collectTests());
        return $suite;
    }
}
