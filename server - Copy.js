var fs = require('fs');
var socket = require('socket.io');
var express = require('express');
var app = express();
var options = {
    key: fs.readFileSync('/etc/apache2/ssl/server.key'),
    cert: fs.readFileSync('/etc/apache2/ssl/gd_bundle-g2-g1.crt'),
    requestCert: true
};
var server = require('https').createServer(options, app);
//var server = require('http').createServer(app);
var io = socket.listen(server);
//console.log(io);
var port = process.env.PORT || 8443;


server.listen(port, function () {
    console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {

    socket.on('notification_count', function (data) {
        console.log(data);
        io.sockets.emit('notification_count', {
            notification_count: data.notification_count,
            to_id: data.to_id,
        });
    });
    
    socket.on('contact_request_count', function (data) {
        console.log(data);
        io.sockets.emit('contact_request_count', {
            contact_request_count: data.contact_request_count,
            contact_to_id: data.contact_to_id,
        });
    });


    socket.on('new_count_message', function (data) {
        io.sockets.emit('new_count_message', {
            new_count_message: data.new_count_message

        });
    });

    socket.on('update_count_message', function (data) {
        io.sockets.emit('update_count_message', {
            update_count_message: data.update_count_message
        });
    });

    socket.on('new_message', function (data) {
        io.sockets.emit('new_message', {
            name: data.name,
            email: data.email,
            subject: data.subject,
            created_at: data.created_at,
            id: data.id
        });
    });


});
