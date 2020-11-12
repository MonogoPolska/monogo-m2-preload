#### Magento 2 simple preload

This module will work only with PHP 7.4 or higher

- https://www.php.net/manual/en/opcache.preloading.php
- https://wiki.php.net/rfc/preload

# **Install**

### Composer

```composer require monogo/magento-preload```

### Setup
Go to your php.ini or opcache configuration file and add line:

```opcache.preload = [PATH_TO_YOUR_PROJECT]/preload.php```

![stats](https://raw.githubusercontent.com/MonogoPolska/monogo-m2-preload/master/preload.png)

