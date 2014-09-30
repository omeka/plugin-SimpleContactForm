Simple Contact Form (plugin for Omeka)
======================================


Summary
-------

This plugin for the [Omeka] platform adds a simple contact page to allow users
to send a mail to a recipient. A notification can be sent to an admin too.

The form can be used alone or be included in any page via a helper or a
shortcode.


Installation
------------

Unzip [Simple Contact Form] into the plugin directory, rename the folder
"SimpleContactForm" if needed, then install it from the settings panel.

The main form is available at http://example.com/contact.

To add a simple contact form in a page, add this php code inside the view:

```
    echo $this->simpleContactForm();
```

You can add a default message like this:

```
    echo $this->simpleContactForm(array(
        'message' => 'My default message',
    ));
```

You can use the shortcode "simple_contact" too.


Warning
-------

Use it at your own risk.

It's always recommended to backup your files and database so you can roll back
if needed.


Troubleshooting
---------------

See online [Simple Contact Form issues] page on GitHub.


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

* Copyright 2008-2013 Roy Rosenzweig Center for History and New Media


[Omeka]: https://omeka.org
[Simple Contact Form]: https://github.com/Omeka/plugin-SimpleContactForm
[Simple Contact Form issues]: https://github.com/Omeka/plugin-SimpleContactForm/issues
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
