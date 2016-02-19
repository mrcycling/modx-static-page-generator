CMS systems are great ways to keep websites up to date, but they all suffer from the same issue, it takes time to build the html document before it is sent to the browser.  Time which many web visitors are not willing to waste by waiting.

Vandergraaf-M is a static generator, static html that is.  It fetches pages from the CMS backend and then stores them as static files which the server sends out when requested by a browser.  Currently available for the MODX cms.
&nbsp;<br>
&nbsp;<br>

**vandergraaf-M.php**
Is a stand alone fetch and save PHP function, intended to be fired either manually or via a CRON job.  If fired by a CRON job it can be placed out of site from prying eyes under the public_html level.  Or installed above the public level and triggered through a browser call.
&nbsp;<br>
&nbsp;<br>

**vdgf-M-one.php**
Is a MODX snippet intnede to be used as a plug-in.  It is designed to replace or create a single html file when that resource is edited or created a new in MODX.  It should be attached to this system event - *onDocFormSave*.
&nbsp;<br>
&nbsp;<br>

**vdgf-M-all.php**
Designed to rebuild all pages whenever the templates, chunks or snippets are updated.  It should be attached to these system events: *OnChunkSave, OnChunkFormSave, OnTemplateSave, OnTempFormSave, OnSnippetSave, OnSnipFormSave*
&nbsp;<br>
&nbsp;<br>

Notes:

Need to create homepage/index file, can not use default resource #1 supplied with MODX, as that defaults to index.php and will not create an index.html file for use on the static website.

There is a bug when creating a new html file. When the reource is saved for the first time, Wayfinder will not add the new page into the navigation system.  The resource needs to be saved a second time and then the new page will appear in the navgiation tree.

