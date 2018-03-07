
hex.pm

安装万金油： =================================


https://elixir-lang.org/install.html

wget https://packages.erlang-solutions.com/erlang-solutions_1.0_all.deb 
sudo dpkg -i erlang-solutions_1.0_all.deb
sudo apt-get update
sudo apt-get install elixir

$ elixir -v
Erlang/OTP 18 [erts-7.3] [source] [64-bit] [smp:4:4] [async-threads:10] [hipe] [kernel-poll:false]

Elixir 1.5.2





安装凤凰： ============================

https://hexdocs.pm/phoenix/installation.html

$ sudo mix archive.install https://github.com/phoenixframework/archives/raw/master/phx_new.ez

$ mix -h
mix                   # Runs the default task (current: "mix run")
mix app.start         # Starts all registered apps
mix app.tree          # Prints the application tree
mix archive           # Lists installed archives
mix archive.build     # Archives this project into a .ez file
mix archive.install   # Installs an archive locally
mix archive.uninstall # Uninstalls archives
mix clean             # Deletes generated application files
mix cmd               # Executes the given command
mix compile           # Compiles source files
mix deps              # Lists dependencies and their status
mix deps.clean        # Deletes the given dependencies' files
mix deps.compile      # Compiles dependencies
mix deps.get          # Gets all out of date dependencies
mix deps.tree         # Prints the dependency tree
mix deps.unlock       # Unlocks the given dependencies
mix deps.update       # Updates the given dependencies
mix do                # Executes the tasks separated by comma
mix escript           # Lists installed escripts
mix escript.build     # Builds an escript for the project
mix escript.install   # Installs an escript locally
mix escript.uninstall # Uninstalls escripts
mix help              # Prints help information for tasks
mix loadconfig        # Loads and persists the given configuration
mix local             # Lists local tasks
mix local.hex         # Installs Hex locally
mix local.phoenix     # Updates Phoenix locally
mix local.phx         # Updates the Phoenix project generator locally
mix local.public_keys # Manages public keys
mix local.rebar       # Installs Rebar locally
mix new               # Creates a new Elixir project
mix phoenix.new       # Creates a new Phoenix v1.3.0 application
mix phx.new           # Creates a new Phoenix v1.3.0 application
mix phx.new.ecto      # Creates a new Ecto project within an umbrella project
mix phx.new.web       # Creates a new Phoenix web project within an umbrella project
mix profile.cprof     # Profiles the given file or expression with cprof
mix profile.fprof     # Profiles the given file or expression with fprof
mix run               # Runs the given file or expression
mix test              # Runs a project's tests
mix xref              # Performs cross reference checks
iex -S mix            # Starts IEx and runs the default task


init =====================================================
mix help phoenix.new

mix phoenix.new hello_world

We are all set! Run your Phoenix application:

    $ cd hello_world
    $ mix phoenix.server

You can also run your app inside IEx (Interactive Elixir) as:

    $ iex -S mix phoenix.server

Before moving on, configure your database in config/dev.exs and run:

    $ mix ecto.create


Phoenix uses an optional assets build tool called brunch.io
that requires node.js and npm. Installation instructions for
node.js, which includes npm, can be found at http://nodejs.org.

After npm is installed, install your brunch dependencies by
running inside your app:

    $ npm install

If you don't want brunch.io, you can re-run this generator
with the --no-brunch option.


热更新参考：

https://www.jianshu.com/p/98d5167cb7f1

https://hexdocs.pm/distillery/walkthrough.html

the erlang run-time system:
https://happi.github.io/theBeamBook/
