const express = require('express')
const bodyParser = require('body-parser')
const path = require('path')
const { sequelize } = require('./models/init')

const config = require('./config/config')

const app = express()
const api = require('./routes/api')(express)

app.use(bodyParser.json())
app.use('/static', express.static(path.join(__dirname, 'public')))

app.get('/', (req, res) => {
  res.send({
    message: 'Success: Routing is working 100%'
  })
})

app.use('/api', api)

sequelize.sync()
  .then(() => {
    app.listen(config.port, () => {
      console.log(`Server started on port ${config.port}`)
    })
  })
