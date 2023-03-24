# Framework

Ongoing work
AppType::CLI is currently not working you can only use HTTP

##How to Use

###1.Install
``composer require therion/framework``
###2. Config
You need to add 2 files who return arrays:
1. modules.php which returns the classnames of your moduleFactories
2. services.php which returns your services you need (ex. MysqlServce, MongoService etc.)

###3. Load Application in your index.php
``$di = Application::registerApp(AppType::HTTP, $loadedModules, $loadedServices);``

AppType::CLI is currently not working you can only use HTTP

###4. Load your routes
`` 
    $di->getRouter()->route()->send();
``
The method send returns your Response from your handlers. 

Note if you want an error handling insert this here

###5. Handler and Modules
Module factories need to implement ``ModuleFactoryInterface``. This interface requests the registerRoutes function which is needed to register routes :)

Handlers need to implement ``HandlerInterface`` this interfaces. This interface requests the execute function where execution code should be inserted.

###6. Requests and Response
You can add new Types of Responses and Requests, they only need to implement the ``RequestInterface`` or the ``ResponseInterface`` of the framework
Default response is ``JsonResponse``

###7. Load Services
Services will be automatically loaded, if they are registered in the services config.

Note if you need Parameters which are not services, u can use for example the following line:
``Service::class => ['param1', 2, 'param3']``. This is for example needed for your DBService or TemplateEngineService

You also can load your Modules with static construction Parameters. 

###8. Register module classes
In your ModuleFactory you can add handler or other classes by adding them onto the DI-Container: ``$this->di->getContainer()->register(ExampleHandler::class)``

If there are dependencies to other classes you need to register them before.

###9. Register Routes
In your ModuleFactory you can register new routs in your function ``registerRoutes``.

You can add new routes by using the Routes public functions.

``registerGetRoute()``

``registerPostRoute()``

``registerPutRoute()``

``registerDeleteRoute()``

First param is always a unique routename

Second param is the uri like ``/example``

Third param is the Handler you want to call with this route

The last param is an array of your route parameters which are defined in the uri like ``/example/{id}`` (NOT IMPLEMENTED YET)
