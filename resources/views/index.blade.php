<div id="wechat-menu">
    <div id="vue">
        <wechat-menus  :menus="{{json_encode($menus)}}" :events="{{json_encode($events)}}"  :types="{{json_encode($types)}}" :news="{{json_encode($news)}}"></wechat-menus>
    </div>
</div>
<script>
    $(function () {
        $.getScript('/vendor/laravel-admin-ext/wechat/wechat.js');
    });
</script>