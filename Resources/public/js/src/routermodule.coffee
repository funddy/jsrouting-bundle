@Router = (->
  NOT_FOUND = -1
  CONTROLLER_EXTENSION = ".php"

  getControllerName = ->
    pathName = window.location.pathname
    index = pathName.indexOf CONTROLLER_EXTENSION
    return "" if (index is NOT_FOUND)
    return pathName.substr(0, index + CONTROLLER_EXTENSION.length)

  router = new FUNDDY.JsRouting.Router(
    FUNDDY.JsRouting.Routes,
    new FUNDDY.JsRouting.BagFactory(),
    new FUNDDY.JsRouting.RouteFactory(),
    getControllerName()
  )

  generate = (routeName, parameters) ->
    return router.generate(routeName, parameters)

  return {
    generate: generate
  }
)()