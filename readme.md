## Installation - Composer
Add the following code into your composer.json

    {
      "repositories": [
        {
          "type": "package",
          "package": {
            "name": "klyp/hummingbird",
            "version": "0.0.1",
            "type": "wordpress-theme",
            "source": {
              "url": "git@github.com:klyp/hummingbird.git",
              "type": "git",
              "reference": "tags/v0.0.1"
            }
          }
        }
      ],
      "require": {
        "klyp/hummingbird": "0.0.1"
      },
    }
