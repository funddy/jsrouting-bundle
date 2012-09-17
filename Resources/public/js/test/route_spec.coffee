chai = require "chai"
expect = chai.expect
should = chai.should()
sinon = require "sinon"

require "#{__dirname}/../src/namespaces"
require "#{__dirname}/../src/bag"
require "#{__dirname}/../src/route"

describe "Route", ->
  describe "#process()", ->

    createBag = -> new FUNDDY.JsRouting.Bag({})

    tokens = [["text","\/edit"],["variable","\/","[^\/]+","tokenId"]]
    defaults = createBag()
    route = new FUNDDY.JsRouting.Route("test_route", tokens, defaults)
    parameters = createBag()

    it "throw exception when pass not recognized type of token", ->

      myRoute = new FUNDDY.JsRouting.Route("test_route", [["invalid"]], new FUNDDY.JsRouting.Bag({}))
      expect(-> route.process()).to.throw(Error)

    it "throw exception when required parameters are not found", ->
      expect(-> route.process(parameters)).to.throw(Error)

    it "get values from defaults if parameters are not defined", ->
      myDefaultsBag = createBag()

      bagShouldHasTokenId(myDefaultsBag)
      bagGetTokenIdShouldReturn(myDefaultsBag, "default")

      myRoute = new FUNDDY.JsRouting.Route("test_route", tokens, myDefaultsBag)

      expect(myRoute.process(parameters)).to.eql("/default/edit")

    bagShouldHasTokenId = (bag) ->
      sinon.stub(bag, "has")
        .withArgs("tokenId").returns(true)

    bagGetTokenIdShouldReturn = (bag, ret) ->
      sinon.stub(bag, "get")
        .withArgs("tokenId").returns(ret)

    it "build a correct url", ->
      myParametersBag = createBag()

      bagShouldHasTokenId(myParametersBag)
      bagGetTokenIdShouldReturn(myParametersBag, "JhGsh7")

      expect(route.process(myParametersBag)).to.eql("/JhGsh7/edit")