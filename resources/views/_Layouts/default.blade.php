<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIE</title>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/fusioncharts@3.12.2/fusioncharts.js" charset="utf-8"></script>
    {{-- <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js" charset="utf-8"></script> --}}
    <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css" />

</head>
<body>

    <x-navbar />

    <main class="container">

        @yield('notification')

        @yield('main')

    </main>

    <x-footer />

    <!-- <img id="chat-toggle" onclick="toggleChat()" src="{{ URL::asset('images/chat-button.png') }}" alt=""> -->

    <!-- <iframe width="300" height="430" frameborder="0" class="animate__animated animate__fadeInUp animate__faster" id="chatbot" src="https://console.dialogflow.com/api-client/demo/embedded/01970b95-bf99-4e66-9310-835fbfc583e7"></iframe> -->

    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        let chatState = false

        const chatButtonToggle = document.querySelector('#chat-toggle')
        const chatFrame = document.querySelector('#chatbot')

        function toggleChat() {
            chatState = !chatState

            if(chatState) {
                chatFrame.classList.remove('animate__fadeInUp')
                chatFrame.classList.add('animate__fadeOutDown')

                chatButtonToggle.style.bottom = '20px'

                setTimeout(() => {
                    chatFrame.style.display = 'none'
                }, 400)
            } else {
                chatFrame.classList.remove('animate__fadeOutDown')
                chatFrame.classList.add('animate__fadeInUp')
                chatFrame.style.display = 'block'

                chatButtonToggle.style.bottom = '443px'
            }
        }
    </script>

</body>
</html>
