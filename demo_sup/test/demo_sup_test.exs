defmodule DemoSupTest do
  use ExUnit.Case
  doctest DemoSup

  test "greets the world" do
    assert DemoSup.hello() == :world
  end
end
