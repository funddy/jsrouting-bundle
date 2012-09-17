should = require("chai").should()

require "#{__dirname}/../src/namespaces"
require "#{__dirname}/../src/bag"

describe "Bag", ->
  beforeEach ->
    @bag = new FUNDDY.JsRouting.Bag({})

  describe "#get()", ->
    it "return value if exist key", ->
      @bag.set("key", "value")
      @bag.get("key").should.equal("value")

  describe "#has()", ->
    it "return true if exists", ->
      @bag.has("key").should.equal(false)

    it "return false if not exist", ->
      @bag.set("key", "value")
      @bag.has("key").should.equal(true)