const { Customer } = require('../models/init')

/* exports.login = (req, res) => {
  // var uname = req.body.name
  var email = req.body.email
  var pass = req.body.password
  try {
    Customer.findAll({ where: { cEmail: email } }).then(Customer => {
      // customer will be an array of customer instances with the specified name

      if (Customer.comparePassword(pass)) {
        res.status(200).send({
          message: `Successfully logged in.`,
          Customer: Customer.toJSON()
        })
      } else {
        res.status(200).send({
          message: `Wrong password`
        })
      }
    }
    )
  } catch (err) {
    res.status(400).send({
      message: `The entered email is not valid.`
    })
  }
} */

exports.login = (req, res) => {
  // var uname = req.body.name
  res.status(200).send({
    message: `Successfully logged in.`
  })
    
    
}

exports.register = async (req, res) => {
  try {
    const Customer = await Customer.create(req.body)
    res.status(200).send({
      message: `The account with ${req.body.email} was created successfuly`,
      Customer: Customer.toJSON()
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

exports.updateUser = async (req, res) => {
  var firstname = req.body.fname
  var lastname = req.body.lname
  var number = req.body.num
  var email = req.body.email

  try {
    Customer.update({
      cFirstname: firstname,
      cLastname: lastname,
      cNumber: number

    }, {
      where: {
        cEmail: email
      }
    })
  } catch (err) {
    res.status(400).send({
      message: `Something went wrong!!!`
    })
  }
}
