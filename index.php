
<script>
    ws = new WebSocket("ws://127.0.0.1:1001");
    /*ws.onopen = function() {
        alert("连接成功");
        ws.send('all|tom');
    };*/
    ws.onmessage = function(e) {
        alert(e.data);
    };
</script>