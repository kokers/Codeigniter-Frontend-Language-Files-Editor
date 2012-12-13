CodeIgniter Frontend Language Files Editor
=============

It's a frontend for editing language files for CodeIgniter 2.x stored in `/application/language` directory.

WARNING!
-----------
It's not a good idea to put this files unprotected on production server.

It's probably ok on localhost when your project is still in development. But **you should implement some authentication** before go live.

If you use some library for authentication, add one line to contructor in controller like:

```
if(!login){
  show_404();
}
```

Basic idea
-----------

* Using Language Class my files for language are stored in `/my_application_folder/language/`
* I want edit all pairs `key=>value` for languages without opening my file. Add new keys which will be enable for another languages.
* I want to create new languages, new files and copy structure of file to another language while new file is created
* I want to delete languages or files.
* I want to delete one key from all files and from database.
* I want to remove keys from database for file if file does not exist in other languages
* I want to create backup file just in case
* I want to set main language and see translation of it while editing other language
* I want to add comments

Requirements
-----------

Codeigniter 2.x, jQuery, database

Installation
-----------

Grab it from github and extract to corresponding folders.
 
Be aware that there is `application/core/MY_Lang.php` file, so if you use i18n for multilanguage or any other library for that purpose most likely you have MY_Lang in that folder already. So be sure that you want to overwrite it.

How it works
-----------

You call it by entering address: `http://yourdomainhere/language/`

The list of languages are created by folder structure in `/my_application_folder/language/`.

The list of files are created by content in language directory. Only `.php` files are considered and backup files are excluded.

When you choose some file for the first time (keys are not in database) you will be asked if you want to add them.

If there are some differences between keys in file and keys in database we have two options.
1. Some keys exists in file and not in database - you will be asked if you want to add them. Until than, that keys will not be available in form. Warning! If you save your file before adding those keys, the translation and key will be erased from the file.
2. Some keys exists in database and not in the file - you will see (NEW!) next to key name. You will see that most likely when new key was added to the file in other language.

In case anything goes wrong I added copy function which creates backup file so you can restore last file after crash. Better be save than sorry ;o)

If you delete key from file it is also deleted from other languages and database.

All translations are escaped by `addslashes` php function. So if you're using `$this->lang->line('key')` and there was some escaping, remember to use `stripslashes` before you echo `$this..`. You could also use `core/My_Lang.php` file which already has it. Then you don't have to worry about that.

If you have CSRF protection on - remember that it has expire time - so don't edit your files too long ;o) 

I assume that if you want a line break in your translation, you need to add `<br/>` tag.

This frontend already use language class. All buttons, information etc are already put into `language_lang.php` file so you can translate it into your language. 

Comments
-----------

You can add comments to your `key=>translation`. They are stored in database and added as `/* comment */` after saving changes in file. Comments are shared to the same files for different languages. You can disable it in `config/language_editor.php` file.

Todo
-----------

* Switch button between input/textarea for translations
* textarea config - on/off/string length for which textarea will be not input
* line break support - on/off


License
-----------

MIT
