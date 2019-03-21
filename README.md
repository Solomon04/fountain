# fountain-php
Fountain is an automated tracking system. This is a PHP library for the software, built from their curl-library. Please check that out here: https://developer.fountain.com/docs

### Getting Started
To download the package run `composer require solomon_04/fountain-php`

Here is an example of how to use the package:  

```
<?php
   require_once __DIR__ . '/path/to/vendor/autoload.php';
   
   
   \Fountain\Applicants::setApiKey("1234456");
   \Fountain\Applicants::listApplicants();
```

### API 
Please reference the API-README.md to learn how to use the functions 

### Issues:
If you find issues please open them within Github