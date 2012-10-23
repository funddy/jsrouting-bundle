FunddyJsRoutingBundle
=====================

[![Build Status](https://secure.travis-ci.org/funddy/jsrouting-bundle.png?branch=master)](http://travis-ci.org/funddy/jsrouting-bundle)

This bundle enables you to use your Symfony routes from JavaScript, allowing the generate routes in a very similar way.
Inspired by  [FOSJsRoutingBundle], it supports static and dynamic routes generation.

Setup and Configuration
-----------------------
Add the following to your composer.json file:
```json
{
    "require": {
        "funddy/jsrouting-bundle": "1.0.*"
    }
}
```
Update the vendor libraries:

    curl -s http://getcomposer.org/installer | php
    php composer.phar install

For finishing, register the Bundle FunddyJsRoutingBundle in app/AppKernel.php.
```php
// ...
public function registerBundles()
{
    $bundles = array(
        // ...
        new Funddy\Bundle\JsRoutingBundle\FunddyJsRoutingBundle()
        // ...
    );
    // ...
}
```

Usage
-----
Expose the routes that you want to have accessible from your JavaScript code adding the "expose" option to the routing
entry
```yaml
example:
    pattern: /example/{param}
    defaults: { _controller: Bundle:Controller:action }
    options:
        expose: true
```
Now it's time to decide whether you want to use static, dynamic or mixed routes.

### Dynamic Routes
This is the most flexible option. Every time you make a change in exposed routes you'll be able to access them from
JavaScript. It's ideal for development environment or for those cases where you performance is not an issue. As
everything in life, you have to pay a price, which is invoking an URL to regenerate all routes every time you make a
request.

Include FunddyJsRoutingBundle routing
```yaml
jsrouting:
    resource: "@FunddyJsRoutingBundle/Resources/config/routing.yml"
```

Include the scripts
```html
<script type="text/javascript" src="{{ path('funddy_jsrouting') }}"></script>
<script type="text/javascript" src="{{ asset('bundles/funddyjsrouting/js/jsroutingrouter.js') }}"></script>
```

### Static Routes
Is the best solution when we talk about performance, you can include the routes with your own scripts on a single one
(only one request).

Compile the routes

    php app/console funddy:jsrouting:dump

Include routes in a single script
```html
{% javascripts output='js/output.js'
    '/js/routes.js'
    '/bundles/funddyjsrouting/js/jsroutingrouter.js'
%}
<script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}
```

### Mixed Approach
So, if dynamic routes is the most flexible option and static is the one with the best performance... You can always use
dynamic approach for development environment and static for production!

```html
{% if app.environment != 'prod' %}
    <script type="text/javascript" src="{{ path('funddy_jsrouting') }}"></script>
{% endif %}

{% javascripts output='js/output.js'
    '/js/routes.js'
    '/bundles/funddyjsrouting/js/jsroutingrouter.js'
%}
<script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}
```

Don't worry, if the routes were already defined, the next load it will not override them.

### Have fun!
```html
<script type="text/javascript">
    var url = Router.generate('example', {param: 'test'});
</script>
```

Defining Your Own Router
------------------------
What if you do not want to use the default "Router" global var and define your own? Easy, include only routing runtime
and define your own router.
```html
<script type="text/javascript" src="{{ path('funddy_jsrouting') }}"></script>
<script type="text/javascript" src="{{ asset('bundles/funddyjsrouting/js/jsrouting.js') }}"></script>
<script type="text/javascript">
    var MyOwnRouter = (function() {
        router = new FUNDDY.JsRouting.Router(
            FUNDDY.JsRouting.Routes,
            new FUNDDY.JsRouting.BagFactory(),
            new FUNDDY.JsRouting.RouteFactory()
        );
        
        generate = function(routeName, parameters) {
            return router.generate(routeName, parameters);
        };
        
        return {
            generate: generate
        };
    })();
    
    var route = MyOwnRouter.generate('example');
</script>
```

  [FOSJsRoutingBundle]: https://github.com/FriendsOfSymfony/FOSJsRoutingBundle