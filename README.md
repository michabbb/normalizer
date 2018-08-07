# This a copy of a deleted project of https://github.com/Ejz


# Normalizer 

String normalization library for PHP.

### Quick start

```bash
$ mkdir myproject && cd myproject
$ curl -sS 'https://getcomposer.org/installer' | php
$ nano -w composer.json
```

Insert following code:

```javascript
{
    "require": {
        "ejz/normalizer": "~1.0"
    }
}
```

Now install dependencies:

```bash
$ php composer.phar install
```

If everything is OK, let's go with testing:

```php
<?php

define('ROOT', __DIR__);
require(ROOT . '/vendor/autoload.php');

use Ejz\Normalizer;

$str = " Hello, world! ";
$_str = Normalizer::go($str, 'en');
echo "'{$str}' --> '{$_str}'", chr(10);
```

```php
' Hello, world! ' --> 'hello world'
```

