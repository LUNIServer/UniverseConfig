# UniverseConfig

This is a little tool meant to replace the server-side part of the `UniverseConfig` Service originally hosted on services.lego.com
and responsable for providing download information and universe availability to the LEGO Universe Patcher.

It's written to integrate into a LUNI environment and should be put into an XAMPP instance in the root directory.
UniverseConfig may run alongside UniverseLauncher, integration between the two systems might happen in the future.

To be able to use UniverseConfig, you need two things:

1. A mirror to host the client files, that the patcher synchronizes. The only constantly running server I know for that is
	[http://www.timtechsoftware.com/lu/](http://www.timtechsoftware.com/lu/), though I recommend setting up your own mirror.
	Be aware that UniverseConfig is currently configured in a way that will not work with Timtechs sever without changing some paths.
	
2. Add some Universes! The patcher needs to know which server you want to join. Here you have two options:
	a. Adding your Universes to config/data.php following the example in there or
	b. Renaming confi/db.php.default to config/db.php and adding database credentials. The database needs a table 'universes' with 'id', 'name' and 'address'
	
3. Configure your PC to access your UniverseConfig! The LU Patcher connects to services.lego.com. It is possible to work around this by manipulating your computers 'hosts' file.
	Be VERY careful with any changes you do to that file. A corrupted or insecure file may break your internet connection and/or redirect your browser to webpages distibuting viruses etc.
	We will NOT provide a tutorial on how to do that. We plan to have a custom launcher in the future, so if you are not 100% certain of what you are doing,
	please wait for that launcher to be created.
