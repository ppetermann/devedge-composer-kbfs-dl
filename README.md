# devedge/composer-kbfs-dl

## what is this

basically this is an attempt on creating a "downloader" for composer, 
which allows to install packages through the magic of the keybase 
filesystem, thus ensuring that the package that is supposed to be 
installed, is the one the original author provided.
 
## sounds cool, should i use this?

if you are interested in this, you could, however bear in mind that this
so far is only a very basic implementation, a lot of things are still 
missing, and without further changes this will be rather useless for 
the current composer eco-system, as packagist for example does not 
support this.

## ok, i understand, but i still want to try it out, how do i do that?

1. first of all you need a keybase.io account, and the account needs 
kbfs  enabled.

2. this currently only works with the linux version of kbfs, as i yet
have to figure out how to find the path of the kbfs mount on win. So
you will need linux as your working machine (mac might maybe work too)

3. you need to install this plugin, this can either be done globally
for your composer installation, by editing ~/.composer/composer.json 
and then running an composer update in that directory, or for your 
current project - by editing its composer.json. The information you need
for this are answered in the next question

4. you need packages that are available through kbfs, meaning someone 
has to publish composer packages here. currently i do not provide any.
to provide a package through kbfs you need to tar+gz it and put it 
in something like: 
    `/keybase/public/USERNAME/[composer/vendorname/]package-1.0.0.tar.gz`

5. you then need a repository which tells composer where the file is.
as there is no such repository public yet, your best bet is probably to 
place a packages.json on some http(s) accessible path and describe the 
package there. for an example see the question after the next one.

6. you ahve to add the packages.json from 5) to the composer.json of the 
project where you want to use the package from kbfs.

7. composer update, if you have done everything right you should get 
your package installed this way.
 
## what are the information i need to add to my global or local composer.json?

```json
    {
        "require": {
            "devedge/composer-kbfs-dl": "dev-master"
        },
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/ppetermann/devedge-composer-kbfs-dl"
            }
        ]
    }
```


## how would the packages.json look like?
hint: this package does not exist

```json
    {
        "packages": {
            "vendorname/packagename": {
                "1.0.0": {
                    "name": "vendorname/packagename",
                    "version": "1.0.0",
                    "dist": {
                        "url": "ppetermann/composer/vendorname/package-1.0.0.tar.gz",
                        "type": "kbfs"
                    }
                }
            }
        }
    }
```

## open to-dos 

 * find a better, and secure way of providing the repository information
 * make at least some basic checks if the source dir is actually kbfs, and not some random dir with that name
 * sanitize pathes used in package-descriptions
 * make error messages more composer-like
 * make it work on windows
 
## who are you?

https://keybase.io/ppetermann
