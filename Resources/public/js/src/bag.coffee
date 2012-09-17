root = global ? @
class root.FUNDDY.JsRouting.Bag
  constructor: (@items) ->

  has: (name) ->
    name of @items

  get: (name) ->
    @items[name]

  set: (name, value) ->
    @items[name] = value