CMS systems are great ways to keep websites up to date, but they all suffer from the same issue, it takes time to build the html document before it is sent to the browser.  Time which many web visitors are not willing to waste by waiting.

Vandergraaf-M is a static generator, static html that is.  It fetches pages from the CMS backend and then stores them as static files which the server sends out when requested by a browser.  Currently available for the MODX cms.

vandergraaf-M.php is a stand alone fetch and save PHP function, intended to be fired either manually or via a CRON job.  If fired by a CRON job it can be placed out of site from prying eyes under the public_html level.  Or installed above the public level and triggered through a browser call.

vdgf-M-one.php is a MODX snippet intnede to be used as a plug-in.  It is designed to replace or create a single html file when that resource is edited or created a new in MODX.  It should be attached to this system event - onDocFormSave.

vdgf-M-all.php is designed to rebuild all pages whenever the templates, chunks or snippets are updated.  It should be attahced to these system events: OnChunkSave, OnChunkFormSave, OnTemplateSave, OnTempFormSave, OnSnippetSave, OnSnipFormSave

Notes:

Need to create homepage/index file, can not use default resource supplied with MODX.

There is a bug with creating a new html file when the reource is saved for the first time.  Wayfinder will not add the new page into it output until the file is saved a second time.

