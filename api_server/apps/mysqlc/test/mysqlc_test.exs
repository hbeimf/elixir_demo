defmodule MysqlcTest do
  use ExUnit.Case
  doctest Mysqlc

  test "greets the world" do
    assert Mysqlc.hello() == :world
  end
end
