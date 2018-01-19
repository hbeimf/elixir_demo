defmodule RediscTest do
  use ExUnit.Case
  doctest Redisc

  test "greets the world" do
    assert Redisc.hello() == :world
  end
end
