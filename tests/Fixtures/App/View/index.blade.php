<html lang="en">
    <head>
        <title>Laravel Translator</title>
    </head>
    <body>
        <div>
            @lang('Welcome, :name', [':name' => 'Arthur Dent'])
        </div>

        <div>
            {{ lang('Trip to :planet, check-in opens :time', [':place' => 'Argabuthon', ':time' => '9 days']) }}
        </div>

        <div>
            {{ __('Check offers to :planet', [':place' => 'Damogran']) }}
        </div>

        <div>
            {{ __("Translations should also work with double quotes.") }}
        </div>

        <div>
            {{ __('Shouldn\'t escaped quotes within strings also be correctly added?') }}
        </div>

        <div>
            {{ __("Same goes for \"double quotes\".") }}
        </div>

        <div>
            {{ __('String using (parentheses).') }}
        </div>

        <div>
            {{ __("Double quoted string using \"double quotes\", and C-style escape sequences.\n\t\\") }}
        </div>
    </body>
</html>
