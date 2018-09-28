module.exports = (express) => {
  const router = express.Router()

  router.use('/test', (req, res) => {
    res.send({
      message: 'Success: Routing is working 100%'
    })
  })

  return router
}
