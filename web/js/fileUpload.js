$(function() {
    var conn = new WebSocket('ws://localhost:8082');
    conn.onmessage = function(e) {
        console.log('Response:' + e.data);
    };
    conn.onopen = function(e) {
        console.log("Connection established!");
        console.log('Hey!');
        conn.send('Hey!');
    };

    $('#file-upload-form').on('submit', function(e) {
        e.preventDefault()

        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "/store/upload-file",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data.success) {
                    conn.send(data.message)
                } else {
                    alert(data.message)
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    })
})