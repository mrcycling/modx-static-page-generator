CMS systems are great ways to keep websites up to date, but they all suffer from the same issue, it takes time to build the html document before it is sent to the browser.  Time which many web visitors are not willing to waste by waiting.

Vandergraaf-M is a static generator, static html that is.  It fetches pages from the CMS backend and then stores them as static files which the server sends out when requested by a browser.  Currently available for the MODX cms.
&nbsp;<br>
&nbsp;<br>

**vandergraaf-M.php** - external php file<br>
Is a stand alone fetch and save PHP function, intended to be fired either manually or via a CRON job.  If fired by a CRON job it can be placed out of sight from prying eyes under the public_html level.  Or installed above the public level and triggered through a browser call.
&nbsp;<br>
&nbsp;<br>

**vdgf-M-main.php** - plug-in snippet<br>
This is the main snippet to use when creating a useful plug-in for clients. It is designed to handle most common functions that the end user will be performing. It should be attached to these system events: *OnDocFormSave, OnBeforeEmptyTrach, OnEmptyTrash, OnChunkFormSave, OnTempFormSave, OnSnipFormSave*

Current functions are as follow:

Editing a resource - *OnDocFormSave*<br>
If updating a resource will rebuild just the single html file for that resource. If creating a new resource, will rebuild entire website to incorporate both new html page and changes to navigation.

Deleting a resource - *OnBeforeEmptyTrash, OnEmptyTrash*<br>
The system triggers only when enptying the trash, it does nothing when the resource is initally deleted. During the OnBefore phase it will delete the html files related to the resources being purged, then after trash is emptied will rebuild the entire website without the deleted resources.

Editing template - *OnTempFormSave*<br>
Will rebuild only pages using the template that was just edited.

Editing chunks or snippets - *OnChunkFormSave, OnSnipFormSave*<br>
Will rebuild all pages
&nbsp;<br>
&nbsp;<br>

**vdgf-M-basic.php** - plug-in snippet<br>
It is designed to replace or create a single html file when that resource is edited or created a new in MODX. Also rebuilds full website on resource creation. It should be attached to this system event - *OnDocFormSave*.
&nbsp;<br>
&nbsp;<br>

Notes:

:small_orange_diamond: Need to create homepage/index file, can not use default resource #1 supplied with MODX, as that defaults to index.php and will not create an index.html file for use on the static website.

:small_orange_diamond: If media queries are used in the style section on a page, then they need to be single lined to avoid being corrupted due to white space removal by the minifying process:
```
@media only screen 
and (min-device-width : 600px) 
and (max-device-width : 1024px) 
and (orientation : portrait) {
```
should be written as
```
@media only screen and (min-device-width : 600px) and (max-device-width : 1024px) and (orientation : portrait) {
```
:small_orange_diamond: PHP functions intended to be run upon serving the saved pages can be included within the html of the template, content, chunks, tv.  MODX will ignore any PHP not included in snippets.  Of course you would need to save the file as .php or configure your server to treat .html as PHP.
