const express = require('express')
const bodyParser = require('body-parser')

const port = process.env.PORT || 3000

const app = express()
app.use(bodyParser.json())

app.get('/contest', (req, res) => {
  res.send({
    message: 'Success: Routing is working 100%'
  })
})

app.listen(port, () => {
  console.log(`Server started on port ${port}`)
})
