@Router = (->
  getControllerName = ->
    pathName = window.location.pathname
    index = pathName.indexOf ".php"
    return "" if (index is -1)
    return pathName.substr(0, index + 4)

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