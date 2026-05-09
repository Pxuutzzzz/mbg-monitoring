const http = require('http');
const server = http.createServer();
const io = require('socket.io')(server, {
  cors: { origin: "*" }
});

io.on('connection', socket => {
  console.log('User connected: ' + socket.id);

  // Driver emits GPS update
  socket.on('gps-update', data => {
    console.log('GPS Update:', data);
    io.emit('delivery-update', data);
  });

  // Driver confirms delivery
  socket.on('delivery-confirm', data => {
    console.log('Delivery Confirmed');
    io.emit('status-update', data);
  });

  socket.on('disconnect', () => {
    console.log('User disconnected');
  });
});

const PORT = 3000;
server.listen(PORT, () => {
  console.log(`Socket.io Server running on port ${PORT}`);
});
