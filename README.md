# Adventofcode2023

This repository contains all the code written for https://adventofcode.com/2023. These are Christmas themed exercices that you can answer in any language. Mine is made in PHP/Symfony6

I try to be as clean as possible but sometimes time is leaving me no choice than "quick and dirty" (sorry !) 

Install the project : ```composer install```

Run the symfony server : ```symfony serve -d```

Initialize a new day : ```php bin/console generate:day X``` where X is the day number

Run php-cs-fixer : ```vendor/bin/php-cs-fixer fix```

Run the tests : 
```vendor/bin/phpunit``` (unit)
```vendor/bin/behat``` (functional)
