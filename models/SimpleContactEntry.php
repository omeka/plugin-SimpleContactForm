/** 
* SimpleContactFormEntry 
*
* @author CHNM
* @copyright CHNM, 2 June, 2009
* @package: Omeka 
*
*/

//will need to be changed for .10 version
get_db()->addTable('SimpleContactFormEntry', 'simple_contact_form_entries');

class SimpleContactFormEntry extends Omeka_Record {
	public $message;
	public $email;
	public $name;
}
