root = global ? @
class root.FUNDDY.JsRouting.BagFactory
  createFromObject: (object) ->
    return new FUNDDY.JsRouting.Bag(object)