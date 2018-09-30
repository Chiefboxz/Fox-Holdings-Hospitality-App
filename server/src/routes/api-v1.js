const authenticationController = require('../controllers/AuthenticationContoller')

module.exports = (express) => {
  const router = express.Router()

  // Authentication routes
  router.post('/login', authenticationController.login)
  router.post('/register', authenticationController.login)

  /* TODO:
   * Add email verify route
   * Add forgot password
   */

  // JAMES ADD YOUR ROUTES HERE - LINK THEM TO CONTROLLERS SEE AUTH Controller as example

  return router
}
