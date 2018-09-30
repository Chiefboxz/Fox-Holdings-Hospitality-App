const authenticationController = require('../controllers/AuthenticationContoller')

module.exports = (express) => {
  const router = express.Router()

  router.get('/', (req, res) => {
    res.send({
      message: 'Test'
    })
  })

  router.post('/login', authenticationController.login)

  return router
}
