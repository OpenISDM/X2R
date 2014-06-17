Quick Start
===========

1. X2R_EM (PHP version) uses [composer](https://getcomposer.org/) to manage package dependency. To resolve the dependency, simply run the command, 
    ```
    php composer.phar install
    ```
    
2. Then you can do the POST request to two Web services:
    
    Extractor: 
    
    ```
    http://your_web_server/em/extractor.php
    ```
    [parameters of Extractor](http://x2r-me.readthedocs.org/en/latest/user_guide.html)
    
    
    Mapper:
    
    ```
    http://your_web_server/em/mapper.php
    ```
    [parameters of Mapper](http://x2r-me.readthedocs.org/en/latest/user_guide.html#mapper)
    
    The POST parameters can be found in the [python version documents](http://x2r-me.readthedocs.org/en/latest/). 
3. Two testBots are available for simple auto-tests, testBotExtractor.py and testBotMapper.py.