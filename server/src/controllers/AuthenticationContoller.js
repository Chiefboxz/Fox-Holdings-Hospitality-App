const { User } = require('../models/init')

exports.login = (req, res) => {
  res.send({
    message: `Welcome to the login page ${req.body.email}`
  })
}

exports.register = async (req, res) => {
  try {
    const user = await User.create(req.body)
    res.status(200).send({
      message: `The account with ${req.body.email} was created successfuly`,
      usr: user.toJSON()
    })
  } catch (err) {
    res.status(400).send({
      message: `${req.body.email} are already in use`
    })
  }
  res.send({
    message: `You have registered with ${req.body.email} succesfully`
  })
}
