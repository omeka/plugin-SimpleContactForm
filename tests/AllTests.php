<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2014
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContactForm
 */

require_once 'SimpleContactForm_IntegrationHelper.php';

/**
 * Test suite for SimpleContactForm.
 *
 * @package SimpleContactForm
 * @copyright Center for History and New Media, 2007-2014
 */
class SimpleContactForm_AllTests extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new SimpleContactForm_AllTests('SimpleContactForm Tests');
        $testCollector = new PHPUnit_Runner_IncludePathTestCollector(
          array(dirname(__FILE__) . '/cases')
        );
        $suite->addTestFiles($testCollector->collectTests());
        return $suite;
    }
}
