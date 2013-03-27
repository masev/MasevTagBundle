MasevTagBundle
==============

This an alpha proof of concept of implementing support for eZ Tags in eZ Publish 5.

For now it only allows you to read which tags have been stored in an eztags fieldtype.

Installation
============

Add the following to your composer.json and update your dependencies

```jinja
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/masev/MasevTagBundle"
        }
    ],
    "require": {
        "masev/tag-bundle": "dev-master"
    },
```

The eZ Tags fieldtype is already mapped to the Null fieldtype in the eZPublishCoreBundle.
If you want to use this implementation you need to comment the definition of the service in fieldtypes.yml