const bodyParser = require('body-parser');
const app = require('express')();
const http = require('http').Server(app);
const io = require('socket.io')(http);
const port = process.env.PORT || 3000;
const { Client, LocalAuth} = require('whatsapp-web.js');
const QRCode = require('qrcode')

app.use(bodyParser.urlencoded({ extended: true }));

let currentQR = ""
let log = [];

function logging(data)
{
    data = (new Date()).toLocaleString() + " | " + data
    log.push(data)
    console.log(data)
}

const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: { headless: true }
});

app.get('/', (req, res) => {
  res.send(`<!DOCTYPE html>
  <html lang="id">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Verifikasi QR Code</title>
  </head>
  <body>
      <img src="" alt="">
      <script src="/socket.io/socket.io.js"></script>
      <script>
          let socket = io()
          socket.on('qr', data => {
              document.querySelector('img').src = data
          })
      </script>
  </body>
  </html>`);
});

app.post('/send', (req, res) => {
    logging("[WA] "+req.body.phone+" meminta code")
    client.sendMessage('62'+req.body.phone+'@c.us', req.body.message)
    res.send({status: true})
})

app.get('/test', async (req, res) => {
    try {
        let data = await client.sendMessage('6282228403855@c.us', "Ini pesan percobaan")
        res.send({status: true, message: data})
    } catch (error) {
        res.send({status: false, message: error})
    }
})

io.on('connection', (socket) => {
  socket.emit('qr', currentQR)
  socket.emit('log', log)
});

http.listen(port, () => {
  logging(`Server Dijalankan di port 3000`);
});

client.on('qr', (qr) => {
    logging('[WA] Permintaan Pindai QR Code')
    QRCode.toDataURL(qr, (err, data) => {
        currentQR = data
        io.emit('qr', currentQR)
    })
});

client.on('loading_screen', (percent, message) => {
    logging('[WA] Memuat Pesan', percent);
});

client.on('ready', () => {
    logging('[WA] READY');
});

client.initialize();