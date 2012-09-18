root = global ? @
class root.FUNDDY.JsRouting.Router
  processedRoutes = null

  constructor: (@routesData, @bagFactory, @routeFactory, @baseUrl = "") ->
    processedRoutes = @bagFactory.createFromObject({})

  generate: (routeName, parameters = {}) ->
    routeData = @getAndcheckRouteDataExist(routeName)

    processedRoutes.set(routeName, @createRouteFromData(routeName, routeData)) unless processedRoutes.has(routeName)

    parameters = @bagFactory.createFromObject(parameters)
    @baseUrl + processedRoutes.get(routeName).process(parameters)

  createRouteFromData: (routeName, routeData) ->
    defaults = @bagFactory.createFromObject(routeData.defaults)
    return @routeFactory.create(routeName, routeData.tokens, defaults)

  getAndcheckRouteDataExist: (routeName) ->
    throw new Error "Route '#{routeName}' doesn't exist" if !@routesData.hasOwnProperty(routeName)
    @routesData[routeName]