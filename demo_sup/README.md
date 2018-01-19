# DemoSup

**TODO: Add description**

## Installation

If [available in Hex](https://hex.pm/docs/publish), the package can be installed
by adding `demo_sup` to your list of dependencies in `mix.exs`:

```elixir
def deps do
  [
    {:demo_sup, "~> 0.1.0"}
  ]
end
```

Documentation can be generated with [ExDoc](https://github.com/elixir-lang/ex_doc)
and published on [HexDocs](https://hexdocs.pm). Once published, the docs can
be found at [https://hexdocs.pm/demo_sup](https://hexdocs.pm/demo_sup).



发布：

https://hexdocs.pm/distillery/walkthrough.html#adding-distillery-to-your-project

1>
在mix.exs 文件里添加下面的依赖

```
  defp deps do
    [
      # {:dep_from_hexpm, "~> 0.3.0"},
      # {:dep_from_git, git: "https://github.com/elixir-lang/my_dep.git", tag: "0.1.0"},
      {:distillery, "~> 1.5.2", runtime: false}
    ]
  end
```


2>
在项目根目录下产生了rel 目录

```
$ mix deps.get
$ mix compile
$ mix release.init
```

 


3>
发布

```
$ mix release
==> Assembling release..
==> Building release demo_sup:0.1.0 using environment dev
==> You have set dev_mode to true, skipping archival phase
==> Release successfully built!
    You can run it in one of the following ways:
      Interactive: _build/dev/rel/demo_sup/bin/demo_sup console
      Foreground: _build/dev/rel/demo_sup/bin/demo_sup foreground
      Daemon: _build/dev/rel/demo_sup/bin/demo_sup start
```










