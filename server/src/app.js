const express = require('express')
const bodyParser = require('body-parser')
const path = require('path')
const { sequelize } = require('./models/init')
const morgan = require('morgan')

const api = require('./routes/api-v1')(express)
const config = require('./config/config')

const app = express()

app.use(morgan(function (tokens, req, res) {
  return [
    tokens.method(req, res),
    tokens.url(req, res),
    tokens.status(req, res),
    tokens.res(req, res, 'content-length'), '-',
    tokens['response-time'](req, res), 'ms'
  ].join(' ')
}))

app.use(bodyParser.json())
app.use('/static', express.static(path.join(__dirname, 'public')))

app.get('/', (req, res) => {
  res.send({
    message: 'Success: Routing is working 100%'
  })
})

app.use('/api/v1/', api)

sequelize.sync()
  .then(() => {
    app.listen(config.port, () => {
      console.log(`Server started on port ${config.port}`)
    })
  })
