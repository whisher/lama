@section('content')
<div class="content" data-ui-view></div>
    <script type="text/javascript">
        window.user = <% $data['user'] %>; 
        document.cookie = "XSRF-TOKEN=<% $data['token'] %>";
    </script>
@stop
