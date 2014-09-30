Simple Contact (plugin for Omeka)
=================================


Summary
-------

This plugin for the [Omeka] platform adds a simple contact page to allow users
to send a mail to a recipient. A notification can be sent to an admin too.

The form can be used alone or be included in any page via a helper or a
shortcode.

If wanted, messages can be saved in the database in order to be able to manage
them via the admin interface. This is useful if the server cannot send emails or
for any particular reason. Furthermore, it adds the possibility to ask to
Akismet if the message is a spam.


Installation
------------

Unzip [Simple Contact] into the plugin directory, rename the folder
"SimpleContact" if needed, then install it from the settings panel.

Upgrade from prior than 0.6:
unzip it in a separate folder and keep "SimpleContactForm" folder until end of
installation, then uninstall and remove it. Config is automatically updated.


Usage
-----

The main form is available at http://example.com/contact.

To add a simple contact form in a page, add this php code inside the view:

```php
    echo $this->simpleContactForm();
```

You can add a default message like this:

```php
    echo $this->simpleContactForm(array(
        'message' => 'My default message',
    ));
```

You can use the shortcode "simple_contact" too.


Warning
-------

Use it at your own risk.

It's always recommended to backup your files and database regularly so you can
roll back if needed.


Troubleshooting
---------------

See online [Simple Contact issues] page on GitHub.


License
-------

* This plugin is published under [GNU/GPL].

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.


Contact
-------

Current maintainers:

* Roy Rosenzweig Center for History and New Media


Copyright
---------

* Copyright 2008-2014 Roy Rosenzweig Center for History and New Media
* Copyright 2013-2014 Daniel Berthereau (see [Daniel-KM] on GitHub)


[Omeka]: https://omeka.org
[Simple Contact]: https://github.com/Omeka/plugin-SimpleContactForm
[Simple Contact issues]: https://github.com/Omeka/plugin-SimpleContactForm/issues
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
[Daniel-KM]: https://github.com/Daniel-KM "Daniel Berthereau"
