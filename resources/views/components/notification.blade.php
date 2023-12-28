@if(isset($message))
    @section('notification')
        <script type="text/javascript">
            M.toast({
                html: '{{$message}}',
                classes: '{{($color) ?: "blue"}}'
            })
        </script>
    @endsection
@endif
