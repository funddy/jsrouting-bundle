root = global ? @
class root.FUNDDY.JsRouting.RouteFactory
  create: (routeName, tokens, defaults) ->
    return new FUNDDY.JsRouting.Route(routeName, tokens, defaults)
