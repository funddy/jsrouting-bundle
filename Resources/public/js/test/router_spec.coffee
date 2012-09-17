chai = require "chai"
expect = chai.expect
should = chai.should()
sinon = require "sinon"

require "#{__dirname}/../src/namespaces"
require "#{__dirname}/../src/bag"
require "#{__dirname}/../src/bagfactory"
require "#{__dirname}/../src/route"
require "#{__dirname}/../src/routefactory"
require "#{__dirname}/../src/router"

describe "Router", ->
  describe "#generate()", ->

    createBag = -> new FUNDDY.JsRouting.Bag()
    createBagFactory = -> new FUNDDY.JsRouting.BagFactory()
    createRoute = -> new FUNDDY.JsRouting.Route()
    createRouteFactory = -> new FUNDDY.JsRouting.RouteFactory()

    routesData = {"test_route": [["text","\/edit"],["variable","\/","[^\/]+","tokenId"]]}

    it "throw exception when route doesn't exist", ->
      bagFactory = createBagFactory()

      sinon.stub(bagFactory, "createFromObject").returns()

      router = new FUNDDY.JsRouting.Router(routesData, bagFactory)
      expect(-> router.generate("non_existent_route", {})).to.throw(Error)

    it "generate valid route", ->
      processedRoutes = createBag()
      sinon.stub(processedRoutes, "has").returns(false)
      sinon.stub(processedRoutes, "set")

      bagFactory = createBagFactory()
      sinon.stub(bagFactory, "createFromObject").returns(processedRoutes)

      route =  createRoute()
      sinon.stub(route, "process").returns("/edit")
      sinon.stub(processedRoutes, "get").returns(route)

      routeFactory =  createRouteFactory()
      sinon.stub(routeFactory, "create").returns(route)

      router = new FUNDDY.JsRouting.Router(routesData, bagFactory, routeFactory)
      expect(router.generate("test_route", {})).to.eql("/edit")

    it "concatenate base url", ->
      processedRoutes =  createBag()
      sinon.stub(processedRoutes, "has").returns(true)

      bagFactory = createBagFactory()
      sinon.stub(bagFactory, "createFromObject").returns(processedRoutes)

      route =  createRoute()
      sinon.stub(route, "process").returns("/edit")
      sinon.stub(processedRoutes, "get").returns(route)

      router = new FUNDDY.JsRouting.Router(routesData, bagFactory, null, "http://test.com")
      expect(router.generate("test_route", {})).to.eql("http://test.com/edit")
