<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="ISO-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Clevory</title>



    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
    <link rel='stylesheet' href='{{ URL::asset('js/bootstrap.min.css') }}' />
    <link rel='stylesheet' href='{{ URL::asset('js/mainc.css') }}' />
    <link rel='stylesheet' href='{{ URL::asset('js/PopperTooltip.css') }}' />
    <link rel='stylesheet' href='{{ URL::asset('js/navbar.css') }}' />


    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<div class="d-flex" id="wrapper">

    <div id="page-content-wrapper">
    <nav class="navbar navbar-default navbar-static-top navbar-dark text-white" style="background-color: #036ffc;">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img border="0" alt="Clevory" src="Clevory.png" width="100" height="30">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::guest() || Auth::user()->password_changed_at == NULL)
                    <li></li>
                    @else
                    <li><a href="{{ url('/home') }}">Accueil</a></li>
                    <li><a href="{{ url('/sessions') }}">Sessions</a></li>
                    <li><a href="{{ url('/inscriptions') }}">Inscriptions</a></li>
                    <li><a href="{{ url('/utilisateurs') }}">Utilisateurs</a></li>
                    <li><a href="{{ url('/themes') }}">Themes</a></li>
                    <li><a href="{{ url('/categories') }}">Catégories</a></li>
                    <li><a href="{{ url('/formateurs') }}">Formateurs</a></li>
                    <li><a href="{{ url('/stagiaires') }}">Stagiaires</a></li>
                    <li><a href="{{ url('/editeurs') }}">Editeurs</a></li>
                    <li><a href="{{ url('/salles') }}">Salles</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <!--<li><a href="{{ url('/register') }}">Register</a></li>-->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/changePassword"><i class="fa fa-btn fa-key"></i>Changer mot de passe</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Déconnexion</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    </div>
</div>



    <!-- JavaScripts -->

<!--    <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tableToExcel.js') }}"></script>
    <script src="{{ asset('js/mainc.js') }}"></script>
    <script type="text/javascript">
        var tableToExcel = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
                , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
            return function(table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
                window.location.href = uri + base64(format(template, ctx))
            }
        })()
    </script>
    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
    <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('content')
</body>
</html>