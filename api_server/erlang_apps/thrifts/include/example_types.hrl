-ifndef(_example_types_included).
-define(_example_types_included, yeah).

%% struct 'Message'

-record('Message', {'id' :: integer(),
                    'text' :: string() | binary()}).
-type 'Message'() :: #'Message'{}.

-endif.
