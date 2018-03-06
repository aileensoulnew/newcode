var socket = require('socket.io');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;

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
    
    socket.on('getBusinessChatUserList', function (data) {
        console.log(data);
        io.sockets.emit('getBusinessChatUserList', {
            message_slug:data.message_slug, message_to_slug:data.message_to_slug, message: data.message, message_file: data.message_file, message_file_type: data.message_file_type, message_file_size: data.message_file_size, timestamp: data.timestamp, message_from_profile_id: data.message_from_profile_id, company_name: data.company_name, business_user_image: data.business_user_image, date: data.date
        });
    });
    
    socket.on('getRecruiterChatUserList', function (data) {
        console.log(data);
        io.sockets.emit('getRecruiterChatUserList', {
            message_slug:data.message_slug, message_to_slug:data.message_to_slug, message: data.message, message_file: data.message_file, message_file_type: data.message_file_type, message_file_size: data.message_file_size, timestamp: data.timestamp, message_from_profile_id: data.message_from_profile_id, company_name: data.company_name, business_user_image: data.business_user_image, date: data.date
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
