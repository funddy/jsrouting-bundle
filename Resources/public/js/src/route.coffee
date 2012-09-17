root = global ? @
class root.FUNDDY.JsRouting.Route

  constructor: (@routeName, @tokens, @defaults) ->

  process: (parameters) ->
    url = ""
    for token in @tokens
      tokenType = token[0]

      if tokenType isnt "text" and tokenType isnt "variable"
        throw new Error "Type of token #{token[0]} not recognized"

      if tokenType is "text"
        url = token[1] + url

      else if tokenType is "variable"
        url = @generateUrlIfTokenTypeIsVariable(token, parameters) + url

    return url

  generateUrlIfTokenTypeIsVariable: (token, parameters) ->
    parameterName = token[3]

    if !parameters.has(parameterName) and !@defaults.has(parameterName)
      throw new Error "The route #{@routeName} requires de parameter #{parameterName}"

    value = @generateValue(parameterName, parameters)

    return generateUrlPart(token, value)

  generateValue: (parameterName, parameters) ->
    if @defaults.has(parameterName)
      return @defaults.get(parameterName)

    if parameters.has(parameterName)
      return parameters.get(parameterName)

    return null

  generateUrlPart = (token, value) ->
    if (value)
      return token[1] + encodeURIComponent(value).replace(/%2F/g, "/")

    return ""